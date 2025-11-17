const selectedSeats = new Set();

document.addEventListener('DOMContentLoaded', function () {
    const modal = new bootstrap.Modal(document.getElementById('step1Modal'), {
        backdrop: 'static',
        keyboard: false
    });
    modal.show();
    updateStep1Summary();
    updateStep2Summary();
});

document.getElementById('cancel-booking-btn')?.addEventListener('click', () => {
    window.history.back();
});

document.querySelectorAll('.modal .btn-close').forEach(closeBtn => {
    closeBtn.addEventListener('click', function () {
        bootstrap.Modal.getInstance(this.closest('.modal')).hide();
        window.history.back();
    });
});

// ==================== CHỌN GHẾ + TẠM TÍNH MODAL 1 ====================
document.querySelectorAll('.seat').forEach(seat => {
    if (!seat.classList.contains('booked') && !seat.classList.contains('sample')) {
        seat.addEventListener('click', function () {
            const seatId = this.dataset.id;

            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedSeats.delete(seatId);
            } else {
                this.classList.add('selected');
                selectedSeats.add(seatId);
            }

            updateStep1Summary();
            updateStep2Summary();
        });
    }
});


function updateStep1Summary() {
    let total = 0;
    const selectedSeatNames = [];

    document.querySelectorAll('#step1Modal .seat.selected').forEach(seat => {
        const price = parseInt(seat.dataset.price) || 0;
        const seatName = seat.textContent.trim(); 

        total += price;
        selectedSeatNames.push(seatName);
    });

    const seatListEl = document.getElementById('temp-seat-list');
    if (seatListEl) {
        if (selectedSeatNames.length === 0) {
            seatListEl.textContent = 'Chưa chọn ghế';
            seatListEl.classList.remove('text-primary');
        } else {
            seatListEl.textContent = selectedSeatNames.join(', ');
            seatListEl.classList.add('text-primary');
        }
    }

    const priceEl = document.getElementById('temp-ticket-price');
    if (priceEl) {
        priceEl.textContent = total.toLocaleString() + ' đ';
    }

    const totalEl = document.getElementById('temp-total-price');
    if (totalEl) {
        totalEl.textContent = total.toLocaleString() + ' đ';
    }

    document.getElementById('to-step-2').disabled = selectedSeatNames.length === 0;
}

document.querySelectorAll('.btn-plus, .btn-minus').forEach(btn => {
    btn.addEventListener('click', function () {
        const input = this.closest('.quantity-control')?.querySelector('.combo-quantity');
        if (!input) return;

        let qty = parseInt(input.value) || 0;
        qty = this.classList.contains('btn-plus') ? qty + 1 : (qty > 0 ? qty - 1 : 0);
        input.value = qty;

        updateStep2Summary();
    });
});


function updateStep2Summary() {
    let ticketTotal = 0;
    document.querySelectorAll('#step1Modal .seat.selected').forEach(seat => {
        ticketTotal += parseInt(seat.dataset.price) || 0;
    });

    let comboTotal = 0;
    document.querySelectorAll('.combo-quantity').forEach(input => {
        const qty = parseInt(input.value) || 0;
        const price = parseInt(input.dataset.price) || 0;
        comboTotal += qty * price;
    });

    const grandTotal = ticketTotal + comboTotal;

    document.getElementById('combo-temp-ticket')?.then?.(el => el.textContent = ticketTotal.toLocaleString() + ' đ');
    document.getElementById('combo-temp-price')?.then?.(el => el.textContent = comboTotal.toLocaleString() + ' đ');
    document.getElementById('combo-temp-total')?.then?.(el => el.textContent = grandTotal.toLocaleString() + ' đ');

    const ticketEl = document.getElementById('combo-temp-ticket');
    const comboEl = document.getElementById('combo-temp-price');
    const totalEl = document.getElementById('combo-temp-total');

    if (ticketEl) ticketEl.textContent = ticketTotal.toLocaleString() + ' đ';
    if (comboEl) comboEl.textContent = comboTotal.toLocaleString() + ' đ';
    if (totalEl) totalEl.textContent = grandTotal.toLocaleString() + ' đ';
}

document.getElementById('to-step-2').addEventListener('click', () => {
    if (selectedSeats.size === 0) {
        alert('Vui lòng chọn ít nhất một ghế!');
        return;
    }
    updateStep2Summary();
    bootstrap.Modal.getInstance(document.getElementById('step1Modal')).hide();
    new bootstrap.Modal(document.getElementById('step2Modal')).show();
});

document.getElementById('to-step-3').addEventListener('click', () => {
    let total = 0;
    const seatNames = [];

    document.querySelectorAll('.seat.selected:not(.sample)').forEach(seat => {
        total += parseInt(seat.dataset.price) || 0;
        seatNames.push(seat.innerText.trim());
    });

    let comboSummary = '';
    document.querySelectorAll('.combo-item').forEach(item => {
        const nameEl = item.querySelector('.combo-info strong');
        const priceEl = item.querySelector('.combo-info small');
        const input = item.querySelector('.combo-quantity');

        if (!nameEl || !priceEl || !input) return;

        const name = nameEl.innerText;
        const price = parseInt(priceEl.innerText.replace(/[^\d]/g, '')) || 0;
        const qty = parseInt(input.value) || 0;

        if (qty > 0) {
            const comboPrice = price * qty;
            total += comboPrice;
            comboSummary += `- ${name} x ${qty} (${comboPrice.toLocaleString()} đ)<br>`;
        }
    });

    document.getElementById('summary-seats').textContent = seatNames.join(', ') || 'Chưa chọn';
    document.getElementById('summary-combos').innerHTML = comboSummary || 'Không chọn combo';
    document.getElementById('summary-total').textContent = total.toLocaleString() + ' đ';
    document.getElementById('summary-total-input').value = total;

    bootstrap.Modal.getInstance(document.getElementById('step2Modal')).hide();
    new bootstrap.Modal(document.getElementById('step3Modal')).show();
});

document.querySelectorAll('[data-bs-target="#step1Modal"]').forEach(btn => {
    btn.addEventListener('click', () => {
        bootstrap.Modal.getInstance(document.getElementById('step2Modal')).hide();
        updateStep1Summary();
    });
});

document.querySelectorAll('[data-bs-target="#step2Modal"]').forEach(btn => {
    btn.addEventListener('click', () => {
        bootstrap.Modal.getInstance(document.getElementById('step3Modal')).hide();
        updateStep2Summary();
    });
});

document.getElementById('final-order-form').addEventListener('submit', function (e) {
    const seatsWrapper = document.getElementById('selected-seats-inputs');
    const combosWrapper = document.getElementById('selected-combos-inputs');

    seatsWrapper.innerHTML = '';
    combosWrapper.innerHTML = '';

    document.querySelectorAll('.seat.selected:not(.sample)').forEach(seat => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'seats[]';
        input.value = seat.dataset.id;
        seatsWrapper.appendChild(input);
    });

    let index = 0;
    document.querySelectorAll('.combo-item').forEach(item => {
        const comboId = item.querySelector('.btn-minus')?.dataset.id;
        const qty = parseInt(item.querySelector('.combo-quantity')?.value) || 0;
        if (comboId && qty > 0) {
            combosWrapper.innerHTML += `
                <input type="hidden" name="combos[${index}][id]" value="${comboId}">
                <input type="hidden" name="combos[${index}][quantity]" value="${qty}">
            `;
            index++;
        }
    });

    if (selectedSeats.size === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất một ghế trước khi thanh toán!');
        bootstrap.Modal.getInstance(document.getElementById('step3Modal')).hide();
        new bootstrap.Modal(document.getElementById('step1Modal')).show();
    }
});