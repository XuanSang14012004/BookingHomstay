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

// -----function redirect to add page -----//
document.addEventListener('DOMContentLoaded', function() {
    const addButtons = document.querySelectorAll('.add-btn');
    addButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pageToRedirect = this.getAttribute('add-page');
            if (pageToRedirect =='add_user'){
                window.location.href = `home.php?page=add_user`;
            }
            else if(pageToRedirect =='add_homestay'){
                window.location.href = `home.php?page=add_homestay`;
            }
            else if(pageToRedirect =='add_rooms'){
                window.location.href = `home.php?page=add_rooms`;
            
            }else if(pageToRedirect =='add_booking'){
                window.location.href = `home.php?page=add_booking`;
            
            }else if(pageToRedirect =='add_payment'){
                window.location.href = `home.php?page=add_payment`;
            }
        });
    });
});

//----- function redirect to update page -----//
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pageToRedirect = this.getAttribute('edit-page');
            const accountId = this.getAttribute('account-id'); 
            const userId = this.getAttribute('user-id'); 
            const homestayId = this.getAttribute('homestay-id');
            const roomId = this.getAttribute('room-id'); 
            const bookingId = this.getAttribute('booking-id'); 
            const paymentId = this.getAttribute('payment-id');
            const reviewId = this.getAttribute('review-id');  

            if (pageToRedirect =='update_account' && accountId) {
                window.location.href = `home.php?page=update_account&id=${accountId}`;
            }
            else if (pageToRedirect == 'update_user' && userId) {
                window.location.href = `redirect.php?page=update_user&id=${userId}`;
            }
            else if (pageToRedirect == 'update_homestay' && homestayId) {
                window.location.href = `home.php?page=update_homestay&id=${homestayId}`;
            }
            else if (pageToRedirect == 'update_rooms' && roomId) {
                window.location.href = `home.php?page=update_rooms&id=${roomId}`;
            }
            else if (pageToRedirect == 'update_booking' && bookingId) {
                window.location.href = `home.php?page=update_booking&id=${bookingId}`;  
            }
            else if (pageToRedirect == 'update_payment' && paymentId) {
                window.location.href = `home.php?page=update_payment&id=${paymentId}`;
            }
            else if (pageToRedirect == 'update_review' && reviewId) {
                window.location.href = `home.php?page=update_review&id=${reviewId}`;
            }
        });
    });
});

//----- function redirect to read page -----//
document.addEventListener('DOMContentLoaded', function() {
    const readButtons = document.querySelectorAll('.detail-btn');
    readButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pageToRedirect = this.getAttribute('read-page');
            const accountId = this.getAttribute('account-id'); 
            const userId = this.getAttribute('user-id'); 
            const homestayId = this.getAttribute('homestay-id');
            const roomId = this.getAttribute('room-id'); 
            const bookingId = this.getAttribute('booking-id'); 
            const paymentId = this.getAttribute('payment-id');
            const reviewId = this.getAttribute('review-id');
            const feedbackId = this.getAttribute('feedback-id');
            if (pageToRedirect =='detail_account'&& accountId){
                window.location.href = `home.php?page=detail_account&id=${accountId}`;
            }
            else if(pageToRedirect =='detail_user' && userId){
                window.location.href = `home.php?page=detail_homestay&id=${userId}`;
            }
            else if(pageToRedirect =='detail_homestay' && homestayId){
                window.location.href = `home.php?page=detail_homestay&id=${homestayId}`;
            }
            else if(pageToRedirect =='detail_rooms' && roomId){
                window.location.href = `home.php?page=detail_rooms&id=${roomId}`;
            
            }else if(pageToRedirect =='detail_booking' && bookingId){
                window.location.href = `home.php?page=detail_homestay&id=${bookingId}`;
            
            }else if(pageToRedirect =='detail_payment' && paymentId){
                window.location.href = `home.php?page=detail_payment&id=${paymentId}`;
            }
            else if(pageToRedirect =='detail_review' && reviewId){
                window.location.href = `home.php?page=detail_review&id=${reviewId}`;
            }
            else if(pageToRedirect =='detail_feedback' && feedbackId){
                window.location.href = `home.php?page=detail_feedback&id=${feedbackId}`;
            }
        });
    });
});







document.addEventListener('DOMContentLoaded', function() {
    // Lấy tham số 'status' từ URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    // Kiểm tra và hiển thị thông báo
    if (status === 'success_add') {
        const message = 'Thêm mới thành công!';
        displaySuccessMessage(message);
    }
});

// Hàm hiển thị thông báo
function displaySuccessMessage(message) {
    const messageBox = document.createElement('div');
    messageBox.className = 'alert-success';
    messageBox.textContent = message;

    // Tìm một vị trí để hiển thị, ví dụ: dưới thanh navbar
    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.insertBefore(messageBox, mainContent.firstChild);

        // Tự động ẩn thông báo sau 3 giây
        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 3000);
    }
}





document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success_add') {
        const message = 'Thêm mới thành công!';
        displaySuccessMessage(message);
    } else if (status === 'success_update') {
        const message = 'Cập nhật thành công!';
        displaySuccessMessage(message);
    }
});

// Hàm hiển thị thông báo (giữ nguyên)
function displaySuccessMessage(message) {
    const messageBox = document.createElement('div');
    messageBox.className = 'alert-success';
    messageBox.textContent = message;

    const mainContent = document.querySelector('main');
    if (mainContent) {
        mainContent.insertBefore(messageBox, mainContent.firstChild);

        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 3000);
    }
}