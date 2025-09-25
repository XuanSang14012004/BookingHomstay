
// ---------- Account ----------
function showFormAccount(formId, email = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'account-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'add-form') {
        window.location.href = `home.php?page=account&action=add_account&id=${email}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=account&action=search_account&content=${search}`;
    } else if (formId === 'edit-form' && email) {
        window.location.href = `home.php?page=account&action=edit_account&id=${email}`;
    } else if (formId === 'detail-form' && email) {
        window.location.href = `home.php?page=account&action=detail_account&id=${email}`;
    }
}

function deleteAccount(email) {
    if (confirm("Bạn có chắc chắn muốn xóa tài khoản này không?")) {
        window.location.href = `home.php?page=delete&action=delete_account&id=${email}`;
    }
}

// ---------- User ----------
function showFormUser(formId, makhachhang = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'user-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'add-form') {
        window.location.href = `home.php?page=user&action=add_user&id=${makhachhang}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=user&action=search_user&content=${search}`;
    } else if (formId === 'edit-form' && makhachhang) {
        window.location.href = `home.php?page=user&action=edit_user&id=${makhachhang}`;
    } else if (formId === 'detail-form' && makhachhang) {
        window.location.href = `home.php?page=user&action=detail_user&id=${makhachhang}`;
    }
}

function deleteUser(makhachhang) {
    if (confirm("Bạn có chắc chắn muốn xóa khách hàng này không?")) {
        window.location.href = `home.php?page=delete&action=delete_user&id=${makhachhang}`;
    }
}

// ---------- Homestay ----------
function showFormHomestay(formId, mahomestay = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'Homestay-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'add-form') {
        window.location.href = `home.php?page=homestay&action=add_homestay&id=${mahomestay}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=homestay&action=search_homestay&content=${search}`;
    } else if (formId === 'edit-form' && mahomestay) {
        window.location.href = `home.php?page=homestay&action=edit_homestay&id=${mahomestay}`;
    } else if (formId === 'detail-form' && mahomestay) {
        window.location.href = `home.php?page=homestay&action=detail_homestay&id=${mahomestay}`;
    }
}

function deleteHomestay(mahomestay) {
    if (confirm("Bạn có chắc chắn muốn xóa Homestay này không?")) {
        window.location.href = `home.php?page=delete&action=delete_homestay&id=${mahomestay}`;
    }
}

// ---------- Rooms ----------
function showFormRoom(formId, maphong = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'room-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'add-form') {
        window.location.href = `home.php?page=rooms&action=add_room&id=${maphong}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=rooms&action=search_room&content=${search}`;
    } else if (formId === 'edit-form' && maphong) {
        window.location.href = `home.php?page=rooms&action=edit_room&id=${maphong}`;
    } else if (formId === 'detail-form' && maphong) {
        window.location.href = `home.php?page=rooms&action=detail_room&id=${maphong}`;
    }
}

function deleteRoom(maphong) {
    if (confirm("Bạn có chắc chắn muốn xóa thông tin phòng này không?")) {
        window.location.href = `home.php?page=delete&action=delete_room&id=${maphong}`;
    }
}

// ---------- Booking ----------
function showFormBooking(formId, madatphong = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'booking-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'add-form') {
        window.location.href = `home.php?page=booking&action=add_booking&id=${madatphong}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=booking&action=search_booking&content=${search}`;
    } else if (formId === 'edit-form' && madatphong) {
        window.location.href = `home.php?page=booking&action=edit_booking&id=${madatphong}`;
    } else if (formId === 'detail-form' && madatphong) {
        window.location.href = `home.php?page=booking&action=detail_booking&id=${madatphong}`;
    }
}

function deleteBooking(madatphong) {
    if (confirm("Bạn có chắc chắn muốn xóa đơn đặt phòng này không?")) {
        window.location.href = `home.php?page=delete&action=delete_booking&id=${madatphong}`;
    }
}
// ---------- Payment ----------
function showFormPay(formId, mathanhtoan = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'payment-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'add-form') {
        window.location.href = `home.php?page=payment&action=add_payment&id=${mathanhtoan}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=payment&action=search_payment&content=${search}`;
    } else if (formId === 'edit-form' && mathanhtoan) {
        window.location.href = `home.php?page=payment&action=edit_payment&id=${mathanhtoan}`;
    } else if (formId === 'detail-form' && mathanhtoan) {
        window.location.href = `home.php?page=payment&action=detail_payment&id=${mathanhtoan}`;
    }
}

function deletePay(mathanhtoan) {
    if (confirm("Bạn có chắc chắn muốn xóa hóa đơn này không?")) {
        window.location.href = `home.php?page=delete&action=delete_payment&id=${mathanhtoan}`;
    }
}

// ---------- Reviews ----------
function showFormReview(formId, madanhgia = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'review-form') {
        document.getElementById(formId).style.display = 'block';
    } else if (formId === 'edit-form' && madanhgia) {
        window.location.href = `home.php?page=reviews&action=edit_review&id=${madanhgia}`;
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=reviews&action=search_review&content=${search}`;
    } else if (formId === 'detail-form' && madanhgia) {
        window.location.href = `home.php?page=reviews&action=detail_review&id=${madanhgia}`;
    }
}

function deleteReview(madanhgia) {
    if (confirm("Bạn có chắc chắn muốn xóa đánh giá này không?")) {
        window.location.href = `home.php?page=delete&action=delete_review&id=${madanhgia}`;
    }
}

// ---------- Feedback ----------
function showFormFeed(formId, maphanhoi = null) {
    const forms = document.querySelectorAll('.form-container');
    const check_search = document.getElementById("search");
    const search = check_search.value;
    forms.forEach(form => {
        form.style.display = 'none';
    });

    // Xử lý logic hiển thị
    if (formId === 'feedback-form') {
        document.getElementById(formId).style.display = 'block';
    }else if (formId === 'search-form') {
        window.location.href = `home.php?page=account&action=search_feedback&content=${search}`;
    } else if (formId === 'edit-form' && maphanhoi) {
        window.location.href = `home.php?page=feedback&action=edit_feedback&id=${maphanhoi}`;
    } else if (formId === 'detail-form' && maphanhoi) {
        window.location.href = `home.php?page=feedback&action=detail_feedback&id=${maphanhoi}`;
    }
}

function deleteFeed(maphanhoi) {
    if (confirm("Bạn có chắc chắn muốn xóa phản hồi này không?")) {
        window.location.href = `home.php?page=delete&action=delete_feedback&id=${maphanhoi}`;
    }
}










//-----Hiển thị thông báo sau khi thực hiện thay đổi trên DB----- 
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const page = urlParams.get('page');

    // Hàm hiển thị thông báo không chặn luồng
    function showMessage(msg) {
        let box = document.createElement('div');
        box.className = 'custom-alert';
        box.textContent = msg;
        box.style.position = 'fixed';
        box.style.top = '10px';
        box.style.left = '50%';
        box.style.transform = 'translateX(-50%)';
        box.style.background = '#222';
        box.style.color = '#fff';
        box.style.padding = '18px 32px';
        box.style.borderRadius = '8px';
        box.style.fontSize = '18px';
        box.style.zIndex = '9999';
        box.style.boxShadow = '0 4px 16px rgba(0,0,0,0.2)';
        document.body.appendChild(box);
        setTimeout(() => {
            box.remove();
        }, 2000);
    }

    // Account
    if (page === 'account') {
        if (status === 'add_success') {
            showMessage('Thêm tài khoản thành công!');
        } else if (status === 'add_error') {
            showMessage('Thêm tài khoản thất bại. Vui lòng kiểm tra lại thông tin đã nhập.');
        }
        if (status === 'delete_success') {
            showMessage('Xóa tài khoản thành công!');
        } else if (status === 'delete_error') {
            showMessage('Xóa tài khoản thất bại! Kiểm tra lại thao tác xóa.');
        }
        if (status === 'update_success') {
            showMessage('Cập nhật tài khoản thành công!');
        } else if (status === 'update_error') {
            showMessage('Cập nhật tài khoản thất bại! Vui lòng kiểm tra lại thông tin đã nhập.');
        }
    }
    if (page === 'add_account' && status === 'exists') {
        showMessage('Email đã tồn tại. Vui lòng sử dụng email khác.');
    }

    // User
    if (page === 'user') {
        if (status === 'add_success') {
            showMessage('Thêm khách hàng thành công!');
        } else if (status === 'add_error') {
            showMessage('Thêm khách hàng thất bại. Vui lòng kiểm tra lại thông tin đã nhập.');
        }
        if (status === 'delete_success') {
            showMessage('Xóa khách hàng thành công!');
        } else if (status === 'delete_error') {
            showMessage('Xóa khách hàng thất bại! Kiểm tra lại thao tác xóa.');
        }
        if (status === 'update_success') {
            showMessage('Cập nhật thông tin khách hàng thành công!');
        } else if (status === 'update_error') {
            showMessage('Cập nhật thông tin khách hàng thất bại! Vui lòng kiểm tra lại thông tin đã nhập.');
        }
    }
    if (page === 'add_user' && status === 'exists') {
        showMessage('Mã khách hàng đã tồn tại. Vui lòng sử dụng mã khác.');
    }

    // Homestay
    if (page === 'homestay') {
        if (status === 'add_success') {
            showMessage('Thêm homestay thành công!');
        } else if (status === 'add_error') {
            showMessage('Thêm homestay thất bại. Vui lòng kiểm tra lại thông tin đã nhập.');
        } else if (status === 'error_upload') {
            showMessage('Thêm homestay thất bại. Hình ảnh chưa được chọn hoặc không đúng định dạng.');
        }
        if (status === 'delete_success') {
            showMessage('Xóa homestay thành công!');
        } else if (status === 'delete_error') {
            showMessage('Xóa homestay thất bại! Kiểm tra lại thao tác xóa.');
        }
        if (status === 'update_success') {
            showMessage('Cập nhật homestay thành công!');
        } else if (status === 'update_error') {
            showMessage('Cập nhật homestay thất bại! Vui lòng kiểm tra lại thông tin đã nhập.');
        }
    }
    if (page === 'add_homestay' && status === 'exists') {
        showMessage('Mã homestay đã tồn tại. Vui lòng sử dụng mã khác.');
    }

    // Rooms
    if (page === 'rooms') {
        if (status === 'add_success') {
            showMessage('Thêm phòng thành công!');
        } else if (status === 'add_error') {
            showMessage('Thêm phòng thất bại. Vui lòng kiểm tra lại thông tin đã nhập.');
        } else if (status === 'error_upload') {
            showMessage('Thêm phòng thất bại. Hình ảnh chưa được chọn hoặc không đúng định dạng.');
        }
        if (status === 'delete_success') {
            showMessage('Xóa phòng thành công!');
        } else if (status === 'delete_error') {
            showMessage('Xóa phòng thất bại! Kiểm tra lại thao tác xóa.');
        }
        if (status === 'update_success') {
            showMessage('Cập nhật phòng thành công!');
        } else if (status === 'update_error') {
            showMessage('Cập nhật phòng thất bại! Vui lòng kiểm tra lại thông tin đã nhập.');
        }
    }
    if (page === 'add_rooms' && status === 'exists') {
        showMessage('Mã phòng đã tồn tại. Vui lòng sử dụng mã khác.');
    }

    // Booking
    if (page === 'booking') {
        if (status === 'add_success') {
            showMessage('Thêm đơn đặt phòng thành công!');
        } else if (status === 'add_error') {
            showMessage('Thêm đơn đặt phòng thất bại. Vui lòng kiểm tra lại thông tin đã nhập.');
        }
        if (status === 'delete_success') {
            showMessage('Xóa đơn đặt phòng thành công!');
        } else if (status === 'delete_error') {
            showMessage('Xóa đơn đặt phòng thất bại! Kiểm tra lại thao tác xóa.');
        }
        if (status === 'update_success') {
            showMessage('Cập nhật đơn đặt phòng thành công!');
        } else if (status === 'update_error') {
            showMessage('Cập nhật đơn đặt phòng thất bại! Vui lòng kiểm tra lại thông tin đã nhập.');
        }
    }
    if (page === 'add_booking' && status === 'exists') {
        showMessage('Mã đơn đặt phòng đã tồn tại. Vui lòng sử dụng mã khác.');
    }

    // Payment
    if (page === 'payment') {
        if (status === 'add_success') {
            showMessage('Thêm thanh toán thành công!');
        } else if (status === 'add_error') {
            showMessage('Thêm thanh toán thất bại. Vui lòng kiểm tra lại thông tin đã nhập.');
        }
        if (status === 'delete_success') {
            showMessage('Xóa thanh toán thành công!');
        } else if (status === 'delete_error') {
            showMessage('Xóa thanh toán thất bại! Kiểm tra lại thao tác xóa.');
        }
        if (status === 'update_success') {
            showMessage('Cập nhật thanh toán thành công!');
        } else if (status === 'update_error') {
            showMessage('Cập nhật thanh toán thất bại! Vui lòng kiểm tra lại thông tin đã nhập.');
        }
    }
    if (page === 'add_payment' && status === 'exists') {
        showMessage('Mã thanh toán đã tồn tại. Vui lòng sử dụng mã khác.');
    }
});