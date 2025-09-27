function navigateToUrl(url) {
    window.location.href = url;
}

function showInternalForm(formId, containerClass = '.form-container') {
    const forms = document.querySelectorAll(containerClass);
    forms.forEach(form => {
        form.style.display = 'none';
    });

    const selectedForm = document.getElementById(formId);
    if (selectedForm) {
        selectedForm.style.display = 'block';
    }
}

/**
@param {string} pageName
@param {string} defaultFormId
@param {string} formContainerClass
**/
function handlePopState(pageName, defaultFormId, formContainerClass = '.form-container') {
    window.addEventListener('popstate', function(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page');
        const action = urlParams.get('action');

        if (page !== pageName) {
            return;
        }

        const forms = document.querySelectorAll(formContainerClass);
        if (forms.length === 0) {
            return; 
        }
        
        forms.forEach(form => {
            form.style.display = 'none';
        });

        let formToShowId = defaultFormId;

        if (action && action.startsWith('add_')) {
            formToShowId = 'add-form'; 
        } else if (action && action.startsWith('edit_')) {
            formToShowId = 'edit-form'; 
        } else if (action && action.startsWith('detail_')) {
            formToShowId = 'detail-form'; 
        } else if (action && action.startsWith('search_')) {
            const content = urlParams.get('content') || urlParams.get('recontent');
            if (content) {
                 formToShowId = 'search-results';
            }
        } 
        
        if (pageName === 'feedback' && action === 'reply_feedback') {
            formToShowId = 'reply-form';
        }
        if (pageName === 'reviews' && action === 'search_review') {
             formToShowId = 'search-results'; 
        }


        const formToShow = document.getElementById(formToShowId);
        if (formToShow) {
            formToShow.style.display = 'block';
        } else {
             const defaultForm = document.getElementById(defaultFormId);
             if (defaultForm) {
                 defaultForm.style.display = 'block';
             }
        }
    });
}



// ---------- Account ----------
function showFormAccount(formId, email = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'account-form') {
        showInternalForm(formId);
    } else if (formId === 'add-form') {
        navigateToUrl(`home.php?page=account&action=add_account&id=${email}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=account&action=search_account&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=account&action=search_account&recontent=${research}`);
    } else if (formId === 'edit-form' && email) {
        navigateToUrl(`home.php?page=account&action=edit_account&id=${email}`);
    } else if (formId === 'detail-form' && email) {
        navigateToUrl(`home.php?page=account&action=detail_account&id=${email}`);
    }
}

function deleteAccount(email) {
    if (confirm("Bạn có chắc chắn muốn xóa tài khoản này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_account&id=${email}`);
    }
}

// ---------- User ----------
function showFormUser(formId, customer_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'user-form') {
        showInternalForm(formId);
    } else if (formId === 'add-form') {
        navigateToUrl(`home.php?page=user&action=add_user&id=${customer_id}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=user&action=search_user&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=user&action=search_user&recontent=${research}`);
    } else if (formId === 'edit-form' && customer_id) {
        navigateToUrl(`home.php?page=user&action=edit_user&id=${customer_id}`);
    } else if (formId === 'detail-form' && customer_id) {
        navigateToUrl(`home.php?page=user&action=detail_user&id=${customer_id}`);
    }
}

function deleteUser(customer_id) {
    if (confirm("Bạn có chắc chắn muốn xóa khách hàng này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_user&id=${customer_id}`);
    }
}

// ---------- Homestay ----------
function showFormHomestay(formId, homestay_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';
    
    if (formId === 'Homestay-form') { 
        showInternalForm(formId);
    } else if (formId === 'add-form') {
        navigateToUrl(`home.php?page=homestay&action=add_homestay&id=${homestay_id}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=homestay&action=search_homestay&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=homestay&action=search_homestay&recontent=${research}`);
    } else if (formId === 'edit-form' && homestay_id) {
        navigateToUrl(`home.php?page=homestay&action=edit_homestay&id=${homestay_id}`);
    } else if (formId === 'detail-form' && homestay_id) {
        navigateToUrl(`home.php?page=homestay&action=detail_homestay&id=${homestay_id}`);
    }
}

function deleteHomestay(homestay_id) {
    if (confirm("Bạn có chắc chắn muốn xóa Homestay này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_homestay&id=${homestay_id}`);
    }
}

// ---------- Rooms ----------
function showFormRoom(formId, room_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'room-form') {
        showInternalForm(formId);
    } else if (formId === 'add-form') {
        navigateToUrl(`home.php?page=rooms&action=add_room&id=${room_id}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=rooms&action=search_room&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=rooms&action=search_room&recontent=${research}`);
    } else if (formId === 'edit-form' && room_id) {
        navigateToUrl(`home.php?page=rooms&action=edit_room&id=${room_id}`);
    } else if (formId === 'detail-form' && room_id) {
        navigateToUrl(`home.php?page=rooms&action=detail_room&id=${room_id}`);
    }
}

function deleteRoom(room_id) {
    if (confirm("Bạn có chắc chắn muốn xóa thông tin phòng này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_room&id=${room_id}`);
    }
}

// ---------- Booking ----------
function showFormBooking(formId, booking_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'booking-form') {
        showInternalForm(formId);
    } else if (formId === 'add-form') {
        navigateToUrl(`home.php?page=booking&action=add_booking&id=${booking_id}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=booking&action=search_booking&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=booking&action=search_booking&recontent=${research}`);
    } else if (formId === 'edit-form' && booking_id) {
        navigateToUrl(`home.php?page=booking&action=edit_booking&id=${booking_id}`);
    } else if (formId === 'detail-form' && booking_id) {
        navigateToUrl(`home.php?page=booking&action=detail_booking&id=${booking_id}`);
    }
}

function deleteBooking(booking_id) {
    if (confirm("Bạn có chắc chắn muốn xóa đơn đặt phòng này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_booking&id=${booking_id}`);
    }
}

// ---------- Payment ----------
function showFormPay(formId, payment_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'payment-form') {
        showInternalForm(formId);
    } else if (formId === 'add-form') {
        navigateToUrl(`home.php?page=payment&action=add_payment&id=${payment_id}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=payment&action=search_payment&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=payment&action=search_payment&recontent=${research}`);
    } else if (formId === 'edit-form' && payment_id) {
        navigateToUrl(`home.php?page=payment&action=edit_payment&id=${payment_id}`);
    } else if (formId === 'detail-form' && payment_id) {
        navigateToUrl(`home.php?page=payment&action=detail_payment&id=${payment_id}`);
    }
}

function deletePay(payment_id) {
    if (confirm("Bạn có chắc chắn muốn xóa hóa đơn này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_payment&id=${payment_id}`);
    }
}

// ---------- Reviews ----------
function showFormReview(formId, review_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'review-form') {
        showInternalForm(formId);
    } else if (formId === 'edit-form' && review_id) {
        navigateToUrl(`home.php?page=reviews&action=edit_review&id=${review_id}`);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=reviews&action=search_review&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=reviews&action=search_review&recontent=${research}`);
    } else if (formId === 'detail-form' && review_id) {
        navigateToUrl(`home.php?page=reviews&action=detail_review&id=${review_id}`);
    }
}

function deleteReview(review_id) {
    if (confirm("Bạn có chắc chắn muốn xóa đánh giá này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_review&id=${review_id}`);
    }
}

// ---------- Feedback ----------
function showFormFeedback(formId, feedback_id = null) {
    const check_search = document.getElementById("search");
    const check_research = document.getElementById("research");
    const search = check_search ? check_search.value : '';
    const research = check_research ? check_research.value : '';

    if (formId === 'feedback-form') {
        showInternalForm(formId);
    }else if (formId === 'search-form') {
        navigateToUrl(`home.php?page=feedback&action=search_feedback&content=${search}`);
    }else if (formId === 'research-form') {
        navigateToUrl(`home.php?page=feedback&action=search_feedback&recontent=${research}`);
    } else if (formId === 'reply-form' && feedback_id) {
        navigateToUrl(`home.php?page=feedback&action=reply_feedback&id=${feedback_id}`);
    } else if (formId === 'detail-form' && feedback_id) {
        navigateToUrl(`home.php?page=feedback&action=detail_feedback&id=${feedback_id}`);
    }
}

function deleteFeed(feedback_id) {
    if (confirm("Bạn có chắc chắn muốn xóa phản hồi này không?")) {
        navigateToUrl(`home.php?page=delete&action=delete_feedback&id=${feedback_id}`);
    }
}

handlePopState('account', 'account-form'); 
handlePopState('user', 'user-form'); 
handlePopState('homestay', 'Homestay-form'); 
handlePopState('rooms', 'room-form'); 
handlePopState('booking', 'booking-form'); 
handlePopState('payment', 'payment-form'); 
handlePopState('reviews', 'review-form'); 
handlePopState('feedback', 'feedback-form'); 



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
    if (page === 'account' && status === 'exists') {
        showMessage('Email đã tồn tại. Vui lòng sử dụng email khác.');
    }

    // Customer
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
    if (page === 'homestay' && status === 'exists') {
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