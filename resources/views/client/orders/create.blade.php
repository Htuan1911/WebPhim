@extends('layouts.master')

@section('content')
    <div class="container py-5 d-none d-md-block">
        <div class="text-center mb-4">
            <h2 class="fw-bold">{{ $showtime->movie->title }}</h2>
            <p class="text-muted">
                {{ $showtime->cinemaRoom->theater->name }} •
                {{ $showtime->cinemaRoom->name }} •
                {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i d/m/Y') }}
            </p>
        </div>
    </div>

    {{-- ====================== MODAL 1 – CHỌN GHẾ ====================== --}}
    <div class="modal fade" id="step1Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">01 CHỌN GHẾ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="screen">MÀN HÌNH</div>

                    <div class="d-flex flex-column align-items-center gap-2 mt-4">
                        @php
                            $groupedSeats = $seats->groupBy(fn($item) => substr($item->seat_number, 0, 1));
                        @endphp

                        @foreach ($groupedSeats as $row => $seatsInRow)
                            <div class="d-flex align-items-center gap-2">
                                <div class="seat-label">{{ $row }}</div>
                                <div class="d-flex gap-2">
                                    @foreach ($seatsInRow->sortBy(fn($seat) => (int) filter_var($seat->seat_number, FILTER_SANITIZE_NUMBER_INT)) as $seat)
                                        @php
                                            $isBooked = in_array($seat->id, $bookedSeatIds);
                                            $class = $seat->seat_type === 'vip' ? 'vip' : 'normal';
                                            if ($isBooked) {
                                                $class = 'booked';
                                            }
                                            $basePrice = $showtime->ticket_price;
                                            $seatPrice = $seat->seat_type === 'vip' ? $basePrice + 25000 : $basePrice;
                                        @endphp
                                        <div class="seat {{ $class }}" data-id="{{ $seat->id }}"
                                            data-price="{{ $seatPrice }}">
                                            {{ $seat->seat_number }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex flex-wrap gap-4 align-items-center justify-content-center">
                        <div>Ghế thường: <span class="seat normal sample">A1</span></div>
                        <div>Ghế VIP: <span class="seat vip sample">A1</span></div>
                        <div>Đã đặt: <span class="seat booked sample">A1</span></div>
                    </div>
                </div>

                <div class="mt-4 p-4 bg-light rounded shadow-sm border">
                    <h5 class="text-primary mb-3 fw-bold">Tạm tính</h5>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <span class="fw-medium">Ghế đã chọn:</span>
                            <strong id="temp-seat-list" class="text-primary text-end">
                                Chưa chọn ghế
                            </strong>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tiền vé:</span>
                        <strong id="temp-ticket-price" class="text-danger">0 đ</strong>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Tổng cộng:</span>
                        <span id="temp-total-price" class="text-danger">0 đ</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="cancel-booking-btn">
                        Hủy đặt vé
                    </button>
                    <button type="button" class="btn btn-primary" id="to-step-2">
                        Tiếp tục chọn combo
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== MODAL 2 – CHỌN COMBO ====================== --}}
    <div class="modal fade" id="step2Modal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title">02 CHỌN BỎNG NƯỚC</h5>
                </div>
                <div class="modal-body">
                    <form id="comboForm">
                        @foreach ($combos as $combo)
                            <div
                                class="combo-item d-flex align-items-center justify-content-between p-3 border rounded mb-3">
                                <img src="{{ asset('storage/' . $combo->image) }}" alt="{{ $combo->name }}"
                                    style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                                <div class="combo-info flex-grow-1 ms-3">
                                    <strong>{{ $combo->name }}</strong><br>
                                    <small class="text-danger fw-bold">{{ number_format($combo->price) }} đ</small>
                                </div>
                                <div class="quantity-control d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-danger btn-minus"
                                        data-id="{{ $combo->id }}">−</button>
                                    <input type="text" class="combo-quantity text-center mx-2" style="width:50px;"
                                        value="0" readonly data-id="{{ $combo->id }}"
                                        data-price="{{ $combo->price }}">
                                    <button type="button" class="btn btn-outline-danger btn-plus"
                                        data-id="{{ $combo->id }}">+</button>
                                </div>
                            </div>
                        @endforeach
                    </form>
                </div>

                <div class="mt-5 p-4 bg-light rounded shadow">
                    <h5 class="text-warning mb-3">Tạm tính đơn hàng</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Vé phim ({{ $showtime->movie->title }})</span>
                        <strong id="combo-temp-ticket">0 đ</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Combo & Bỏng nước</span>
                        <strong id="combo-temp-price">0 đ</strong>
                    </div>
                    <hr class="my-3">
                    <div class="d-flex justify-content-between fw-bold fs-4">
                        <span>Tổng thanh toán:</span>
                        <span id="combo-temp-total" class="text-danger">0 đ</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-target="#step1Modal" data-bs-toggle="modal">
                        Quay lại chọn ghế
                    </button>
                    <button type="button" class="btn btn-primary" id="to-step-3">
                        Tiếp tục thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================== MODAL 3 – XÁC NHẬN THANH TOÁN (FULL NỘI DUNG) ====================== --}}
    <div class="modal fade" id="step3Modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-ticket-perforated me-2"></i>
                        XÁC NHẬN & THANH TOÁN
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-danger">{{ $showtime->movie->title }}</h3>
                    </div>

                    <div class="row g-4 mb-4 text-muted">
                        <div class="col-sm-6">
                            <div class="fw-medium">Thời gian</div>
                            <div class="fw-bold fs-5">
                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fw-medium">Ngày chiếu</div>
                            <div class="fw-bold fs-5">
                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fw-medium">Rạp</div>
                            <div class="fw-bold">{{ $showtime->cinemaRoom->theater->name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="fw-medium">Phòng chiếu</div>
                            <div class="fw-bold text-primary fs-5">{{ $showtime->cinemaRoom->name }}</div>
                        </div>
                        <div class="col-12">
                            <div class="fw-medium">Định dạng</div>
                            <div class="fw-bold">2D Phụ đề</div>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">Ghế đã chọn</h5>
                        <div class="fs-4 fw-bold text-danger" id="summary-seats">
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">Combo & Bỏng nước</h5>
                        <div id="summary-combos" class="text-dark">
                        </div>
                    </div>

                    <div class="pt-4 border-top border-3 border-danger">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold mb-0">Tổng thanh toán</h4>
                            <h2 class="text-danger fw-bold mb-0">
                                <span id="summary-total">0 đ</span>
                            </h2>
                        </div>
                        <small class="text-muted d-block mt-2">
                            Ưu đãi (nếu có) sẽ được áp dụng ở bước thanh toán cuối cùng.
                        </small>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light justify-content-between px-4 py-4">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-target="#step2Modal"
                        data-bs-toggle="modal">
                        Quay lại chọn combo
                    </button>

                    <form action="{{ route('client.order.momo_payment') }}" method="POST" id="final-order-form">
                        @csrf
                        <input type="hidden" name="summary-total" id="summary-total-input" value="0">
                        <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                        <div id="selected-seats-inputs"></div>
                        <div id="selected-combos-inputs"></div>

                        <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold">
                            Đặt vé ngay 
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
