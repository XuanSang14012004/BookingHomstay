document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút có class 'delete-btn'
    const deleteButtons = document.querySelectorAll('.delete-btn');

    // Lặp qua từng nút và thêm sự kiện lắng nghe
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Ngăn chặn hành động mặc định của nút (ví dụ: chuyển trang)
            event.preventDefault();

            // Hiển thị cửa sổ xác nhận
            const confirmation = confirm('Bạn có chắc chắn muốn xóa mục này không?');

            // Kiểm tra phản hồi của người dùng
            if (confirmation) {
                // Nếu người dùng chọn OK, thực hiện hành động xóa
                // Ở đây, bạn có thể thêm code để gửi yêu cầu xóa tới server
                console.log('Đã xác nhận xóa!');
                // Ví dụ: window.location.href = this.href; (nếu nút là thẻ <a>)
            } else {
                // Nếu người dùng chọn Cancel, không làm gì cả
                console.log('Đã hủy thao tác xóa.');
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các nút có class 'edit-btn'
    const detailButtons = document.querySelectorAll('.edit-btn');

    // Lặp qua từng nút và thêm sự kiện click
    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Lấy ID từ thuộc tính data-id của button
            const recordId = this.dataset.id;
            
            // Chuyển hướng đến trang chi tiết với ID trong URL
            window.location.href = `detail_report.php?id=${recordId}`;
        });
    });
});

