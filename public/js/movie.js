document.addEventListener('DOMContentLoaded', function () {
    const currentUrl = new URL(window.location);

    // ================== LỌC THEO NGÀY ==================
    document.querySelectorAll('.dateBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const date = this.dataset.date;

            if (date) {
                currentUrl.searchParams.set('date', date);
            } else {
                currentUrl.searchParams.delete('date');
            }
            currentUrl.searchParams.delete('page'); // reset phân trang
            window.location = currentUrl;
        });
    });

    // ================== LỌC THEO HÃNG RẠP (category_id) ==================
    document.querySelectorAll('.categoryBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const categoryId = this.dataset.categoryId; // "" hoặc "1", "2"...

            if (!categoryId || categoryId === 'all' || categoryId === '') {
                currentUrl.searchParams.delete('category_id');
            } else {
                currentUrl.searchParams.set('category_id', categoryId);
            }
            currentUrl.searchParams.delete('page');
            window.location = currentUrl;
        });
    });

    // ================== (TÙY CHỌN) LỌC THEO RẠP CỤ THỂ ==================
    // Nếu bạn có nút chọn rạp riêng thì dùng đoạn này
    document.querySelectorAll('.theaterBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const theaterId = this.dataset.theaterId;

            if (theaterId && theaterId !== 'all') {
                currentUrl.searchParams.set('theater_id', theaterId);
            } else {
                currentUrl.searchParams.delete('theater_id');
            }
            currentUrl.searchParams.delete('page');
            window.location = currentUrl;
        });
    });

    // ================== LƯU VỊ TRÍ CUỘN (giữ trải nghiệm mượt) ==================
    let isManualScroll = false;
    window.addEventListener('beforeunload', () => {
        if (!isManualScroll) {
            sessionStorage.setItem('scrollPos_' + window.location.pathname + window.location.search, window.scrollY);
        }
    });

    // Khôi phục vị trí cuộn khi quay lại
    const savedScroll = sessionStorage.getItem('scrollPos_' + window.location.pathname + window.location.search);
    if (savedScroll) {
        window.scrollTo(0, parseInt(savedScroll));
        sessionStorage.removeItem('scrollPos_' + window.location.pathname + window.location.search);
    }
});

// Xem thêm / Thu gọn mô tả phim
function toggleDescription() {
    const el = document.getElementById('descriptionText');
    const toggle = document.querySelector('.description-toggle');
    if (el && toggle) {
        el.classList.toggle('expanded');
        toggle.textContent = el.classList.contains('expanded') ? 'Thu gọn' : '...Xem thêm';
    }
}