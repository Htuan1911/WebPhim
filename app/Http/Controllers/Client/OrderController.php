<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\ComboOrder;
use App\Models\Order;
use App\Models\OrderSeat;
use App\Models\Payment;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function create($showtimeId)
    {
        $showtime = Showtime::with(['movie', 'cinemaRoom', 'cinemaRoom.theater'])->findOrFail($showtimeId);

        // Lấy danh sách ghế theo cinema_room_id của suất chiếu
        $seats = $showtime->cinemaRoom->seats;

        // Lấy danh sách ghế đã đặt
        $bookedSeatIds = OrderSeat::where('showtime_id', $showtime->id)->pluck('seat_id')->toArray();

        $combos = Combo::all();

        return view('client.orders.create', compact('showtime', 'seats', 'bookedSeatIds', 'combos'));
    }


    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        // 1. Validate đầu vào
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'combos' => 'array',
            'combos.*.id' => 'exists:combos,id',
            'combos.*.quantity' => 'integer|min:0',
            'summary-total' => 'required|numeric|min:0', // Dùng để hiển thị nhưng sẽ không tin tưởng
        ]);

        $userId = auth()->id();
        $showtimeId = $request->input('showtime_id');
        $seats = $request->input('seats');

        // 2. Lấy suất chiếu để tính giá vé
        $showtime = Showtime::findOrFail($showtimeId);
        $ticketPrice = $showtime->ticket_price;

        // 3. Tính tổng tiền vé
        $total = count($seats) * $ticketPrice;

        // 4. Xử lý combo
        $comboData = [];
        foreach ($request->input('combos', []) as $combo) {
            if (isset($combo['id']) && isset($combo['quantity']) && $combo['quantity'] > 0) {
                $comboModel = Combo::find($combo['id']);
                if ($comboModel) {
                    $subtotal = $comboModel->price * $combo['quantity'];
                    $total += $subtotal;
                    $comboData[] = [
                        'combo_id' => $comboModel->id,
                        'quantity' => $combo['quantity'],
                        'subtotal' => $subtotal,
                    ];
                }
            }
        }

        // 5. Tạo đơn hàng
        $order = Order::create([
            'user_id' => $userId,
            'showtime_id' => $showtimeId,
            'total_price' => $total,
            'payment_status' => 'pending',
            'payment_method' => 'momo',
            'booking_code' => strtoupper(Str::random(10)),
        ]);

        // 6. Lưu ghế
        foreach ($seats as $seatId) {
            OrderSeat::create([
                'order_id' => $order->id,
                'seat_id' => $seatId,
                'showtime_id' => $showtimeId,
            ]);
        }

        // 7. Lưu combo
        foreach ($comboData as $c) {
            ComboOrder::create([
                'order_id' => $order->id,
                'combo_id' => $c['combo_id'],
                'quantity' => $c['quantity'],
                'subtotal' => $c['subtotal'],
            ]);
        }

        // 8. Tạo bản ghi thanh toán
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $userId,
            'amount' => $total,
            'method' => 'momo',
            'status' => 'pending',
        ]);

        // 9. Gọi API MoMo
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

        $orderInfo = "Thanh toán vé xem phim - Mã: " . $order->booking_code;
        $amountStr = (string) $total;
        $orderIdMomo = (string) time();
        $requestId = (string) time();
        $redirectUrl = route('client.order.momo_return');
        $ipnUrl = route('client.order.momo_ipn');
        $extraData = json_encode(['payment_id' => $payment->id]);

        $requestType = "payWithATM";

        // 10. Tạo chữ ký
        $rawHash = "accessKey={$accessKey}&amount={$amountStr}&extraData={$extraData}&ipnUrl={$ipnUrl}&orderId={$orderIdMomo}&orderInfo={$orderInfo}&partnerCode={$partnerCode}&redirectUrl={$redirectUrl}&requestId={$requestId}&requestType={$requestType}";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amountStr,
            'orderId' => $orderIdMomo,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);

        if (!isset($jsonResult['payUrl'])) {
            return back()->with('error', $jsonResult['message'] ?? 'Không thể tạo yêu cầu thanh toán MoMo.');
        }

        return redirect()->to($jsonResult['payUrl']);
    }



    public function handleMomoReturn(Request $request)
    {
        return redirect()->route('client.orders.history')->with('success', 'Thanh toán MoMo đang được xử lý, vui lòng chờ xác nhận.');
    }

    public function momo_ipn(Request $request)
    {
        $data = $request->all();

        // Giải mã extraData để lấy payment_id
        $extraData = json_decode($data['extraData'] ?? '{}', true);
        $paymentId = $extraData['payment_id'] ?? null;

        if (!$paymentId) {
            return response()->json(['message' => 'Thiếu thông tin thanh toán'], 400);
        }

        $payment = Payment::find($paymentId);

        if (!$payment || $payment->status === 'paid') {
            return response()->json(['message' => 'Đã xử lý hoặc không tồn tại'], 200);
        }

        // Xác thực chữ ký MoMo gửi về (đảm bảo không giả mạo)
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $rawHash = "amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        if ($signature !== ($data['signature'] ?? '')) {
            return response()->json(['message' => 'Sai chữ ký'], 400);
        }

        // Nếu thanh toán thành công
        if ($data['resultCode'] == 0) {
            $payment->update([
                'status' => 'paid',
                'transaction_code' => $data['transId'],
                'paid_at' => now(),
            ]);

            // Cập nhật đơn hàng
            $payment->order->update([
                'payment_status' => 'paid',
            ]);
        } else {
            $payment->update(['status' => 'failed']);
            $payment->order->update(['payment_status' => 'failed']);
        }

        return response()->json(['message' => 'IPN handled successfully'], 200);
    }

    public function history()
    {
        if (auth()->check()) {
            // Người đăng nhập: lấy theo user_id
            $orders = Order::with(['showtime.movie', 'orderSeats.seat'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        } else {
            // Khách vãng lai: lấy từ session
            $bookingCodes = session('guest_orders', []);

            $orders = Order::with(['showtime.movie', 'orderSeats.seat'])
                ->whereIn('booking_code', $bookingCodes)
                ->latest()
                ->paginate(10);
        }
        return view('client.orders.history', compact('orders'));
    }
}
