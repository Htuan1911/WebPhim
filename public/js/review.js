// Xử lý chọn sao
document.querySelectorAll('.star-rating').forEach(container => {
    const orderId = container.dataset.order;
    container.querySelectorAll('input').forEach(radio => {
        radio.addEventListener('change', function () {
            const ratingInput = document.getElementById('rating-' + orderId);
            if (ratingInput) {
                ratingInput.value = this.value;
            }
        });
    });
});

// Validate form trước khi gửi
function validateReview(orderId) {
    const rating = document.getElementById('rating-' + orderId).value;
    const comment = document.getElementById('comment-' + orderId).value.trim();

    if (!rating) {
        alert('Vui lòng chọn số sao đánh giá!');
        return false;
    }
    if (!comment) {
        alert('Vui lòng nhập nhận xét của bạn!');
        return false;
    }
    return true;
}