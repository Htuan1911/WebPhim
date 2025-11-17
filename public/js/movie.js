document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');

    // Các input ẩn giữ giá trị filter
    const inputDate = document.getElementById('inputDate');
    const inputCategory = document.getElementById('inputCategory');
    const inputTheater = document.getElementById('inputTheater');

    // Khi bấm nút chọn ngày
    document.querySelectorAll('.dateBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            inputDate.value = this.dataset.date;
            // Giữ nguyên category và theater
            form.submit();
        });
    });

    // Khi bấm nút chọn danh mục
    document.querySelectorAll('.categoryBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            inputCategory.value = this.dataset.category;
            // Reset theater vì thay đổi category
            inputTheater.value = '';
            form.submit();
        });
    });

    // Khi bấm nút chọn rạp
    document.querySelectorAll('.theaterBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            inputTheater.value = this.dataset.theater;
            // Giữ nguyên date và category
            form.submit();
        });
    });
});