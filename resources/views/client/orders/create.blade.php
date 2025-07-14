@extends('layouts.master')

@section('content')
    <style>
        .seat {
            width: 36px;
            height: 36px;
            border-radius: 6px;
            text-align: center;
            line-height: 36px;
            font-size: 13px;
            cursor: pointer;
            border: 1px solid #ccc;
            user-select: none;
        }

        .seat.normal {
            background-color: #fcd34d;
        }

        .seat.vip {
            background-color: #f9a8d4;
        }

        .seat.booked {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .seat.selected {
            background-color: #93c5fd !important;
        }

        .seat:hover:not(.booked):not(.selected) {
            opacity: 0.8;
        }

        .screen {
            width: 100%;
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
        }

        .seat-label {
            font-size: 14px;
            width: 30px;
            text-align: center;
        }

        .combo-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            background-color: #f8f9fa;
        }

        .combo-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .combo-info {
            flex-grow: 1;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity-control button {
            padding: 2px 8px;
            border: 1px solid #ccc;
            background-color: #e2e8f0;
            border-radius: 4px;
            cursor: pointer;
        }

        .quantity-control input {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>

    <div class="container py-5">
        {{-- STEP 1: CHỌN GHẾ --}}
        <div id="step-1">
            <h4>01 CHỌN GHẾ</h4>
            <div class="screen">MÀN HÌNH</div>

            <div class="d-flex flex-column align-items-center gap-2">
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

            <div class="mt-4 d-flex flex-wrap gap-4 align-items-center">
                <div>🎫 Ghế thường: <span class="seat normal sample">A1</span></div>
                <div>💺 Ghế VIP: <span class="seat vip sample">A1</span></div>
                <div>❌ Đã đặt: <span class="seat booked sample">A1</span></div>
                <div>✅ Đang chọn: <span class="seat selected sample">A1</span></div>
            </div>

            <button class="btn btn-primary mt-4" id="to-step-2">Tiếp tục chọn combo</button>
        </div>

        {{-- STEP 2: CHỌN COMBO --}}
        <div id="step-2" style="display: none;">
            <h4>02 CHỌN BỎNG NƯỚC</h4>
            <form id="comboForm">
                @foreach ($combos as $combo)
                    <div class="combo-item">
                        <img src="{{ asset('storage/' . $combo->image) }}" alt="{{ $combo->name }}">
                        <div class="combo-info">
                            <strong>{{ $combo->name }}</strong><br>
                            <small>{{ number_format($combo->price) }} đ</small>
                        </div>
                        <div class="quantity-control">
                            <button type="button" class="btn-minus" data-id="{{ $combo->id }}">−</button>
                            <input type="text" class="combo-quantity" value="0" readonly
                                data-id="{{ $combo->id }}">
                            <button type="button" class="btn-plus" data-id="{{ $combo->id }}">+</button>
                        </div>
                    </div>
                @endforeach
            </form>
            <button class="btn btn-secondary mt-3" id="back-to-step-1">⬅ Quay lại chọn ghế</button>
            <button class="btn btn-primary mt-3" id="to-step-3">Tiếp tục thanh toán</button>
        </div>

        {{-- STEP 3: THANH TOÁN --}}
        <div id="step-3" style="display: none;">
            <h4>03 XÁC NHẬN THANH TOÁN</h4>
            <p><strong>Phim:</strong> {{ $showtime->movie->title }}</p>
            <p><strong>Ghế đã chọn:</strong> <span id="summary-seats"></span></p>
            <p><strong>Combo:</strong> <span id="summary-combos"></span></p>
            <p><strong>Tổng tiền:</strong> <span id="summary-total">0 đ</span></p>
            <button class="btn btn-secondary mt-3" id="back-to-step-2">⬅ Quay lại chọn combo</button>
            <form action="{{ route('client.order.momo_payment') }}" method="POST" id="final-order-form">
                @csrf
                <input type="hidden" name="summary-total" id="summary-total-input" value="0">
                <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                <!-- Nơi để JS thêm các input ẩn seats[] và combos[] -->
                <div id="selected-seats-inputs"></div>
                <div id="selected-combos-inputs"></div>

                <button type="submit" class="btn btn-success mt-3">Đặt vé</button>
            </form>

        </div>
    </div>

    <script>
        const selectedSeats = new Set();

        document.querySelectorAll('.seat').forEach(seat => {
            if (!seat.classList.contains('booked') && !seat.classList.contains('sample')) {
                seat.addEventListener('click', function() {
                    const seatId = this.dataset.id;
                    const price = parseInt(this.dataset.price);

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selectedSeats.delete(seatId);
                    } else {
                        this.classList.add('selected');
                        selectedSeats.add(seatId);
                    }
                });
            }
        });

        document.getElementById('to-step-2').addEventListener('click', () => {
            if (selectedSeats.size === 0) {
                alert('Vui lòng chọn ít nhất một ghế!');
                return;
            }
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
        });

        document.getElementById('back-to-step-1').addEventListener('click', () => {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-1').style.display = 'block';
        });

        document.getElementById('to-step-3').addEventListener('click', () => {
            // Lấy tên ghế đã chọn
            const selectedNames = [...document.querySelectorAll('.seat.selected:not(.sample)')]
                .map(s => s.innerText)
                .join(', ');
            document.getElementById('summary-seats').innerText = selectedNames || 'Chưa chọn';

            let comboSummary = '';
            let total = 0;

            // Tính tổng tiền ghế
            const selectedSeats = document.querySelectorAll('.seat.selected:not(.sample)');
            selectedSeats.forEach(s => {
                const price = parseInt(s.dataset.price) || 0; // Fallback to 0 if price is NaN
                total += price;
            });

            // Tính tổng tiền combo
            document.querySelectorAll('.combo-item').forEach(item => {
                const name = item.querySelector('.combo-info strong').innerText;
                const priceText = item.querySelector('.combo-info small').innerText.replace(/[^\d]/g, '');
                const price = parseInt(priceText) || 0; // Fallback to 0 if price is NaN
                const input = item.querySelector('input');
                const quantity = parseInt(input.value) || 0; // Fallback to 0 if quantity is NaN

                if (quantity > 0) {
                    comboSummary +=
                        `- ${name} x ${quantity} (${new Intl.NumberFormat().format(price * quantity)} đ)<br>`;
                    total += price * quantity;
                }
            });

            // Cập nhật tổng tiền
            document.getElementById('summary-combos').innerHTML = comboSummary || 'Không chọn';
            document.getElementById('summary-total').innerText = new Intl.NumberFormat().format(total) + ' đ';
            document.getElementById('summary-total-input').value = total;

            // Chuyển sang bước thanh toán
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-3').style.display = 'block';
        });

        document.getElementById('back-to-step-2').addEventListener('click', () => {
            document.getElementById('step-3').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
        });

        // Nút tăng giảm combo
        document.querySelectorAll('.btn-minus').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                let current = parseInt(input.value);
                if (current > 0) input.value = current - 1;
            });
        });

        document.querySelectorAll('.btn-plus').forEach(btn => {
            btn.addEventListener('click', function() {
                const input = this.parentElement.querySelector('input');
                let current = parseInt(input.value);
                input.value = current + 1;
            });
        });

        document.getElementById('final-order-form').addEventListener('submit', function(e) {
            const seatsInputWrapper = document.getElementById('selected-seats-inputs');
            const combosInputWrapper = document.getElementById('selected-combos-inputs');

            // Xóa input cũ nếu có
            seatsInputWrapper.innerHTML = '';
            combosInputWrapper.innerHTML = '';

            // ✅ Gửi ghế đã chọn
            document.querySelectorAll('.seat.selected:not(.sample)').forEach(seat => {
                const seatId = seat.dataset.id;
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'seats[]';
                input.value = seatId;
                seatsInputWrapper.appendChild(input);
            });

            // ✅ Gửi combo đã chọn
            let comboIndex = 0;
            document.querySelectorAll('.combo-item').forEach(item => {
                const comboId = item.querySelector('.btn-minus')?.dataset.id;
                const quantity = item.querySelector('input')?.value;

                if (comboId && parseInt(quantity) > 0) {
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = `combos[${comboIndex}][id]`;
                    inputId.value = comboId;

                    const inputQty = document.createElement('input');
                    inputQty.type = 'hidden';
                    inputQty.name = `combos[${comboIndex}][quantity]`;
                    inputQty.value = quantity;

                    combosInputWrapper.appendChild(inputId);
                    combosInputWrapper.appendChild(inputQty);

                    comboIndex++;
                }
            });
        });
    </script>
@endsection
