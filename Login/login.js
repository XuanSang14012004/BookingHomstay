function showForm(formId) {
    const forms = document.querySelectorAll('.container');
    forms.forEach(form => {
        form.style.display = 'none';
    });

    const selectedForm = document.getElementById(formId);
    if (selectedForm) {
        selectedForm.style.display = 'block';
    }

    let newAction = 'signin';
    if (formId === 'signup-form') {
        newAction = 'signup';
    }
    const newUrl = `login.php?action=${newAction}`;
    window.history.pushState({ action: newAction }, '', newUrl);
}

window.addEventListener('popstate', function(event) {
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action') || 'signin';

    const forms = document.querySelectorAll('.container');
    forms.forEach(form => {
        form.style.display = 'none';
    });

    if (action === 'signup') {
        document.getElementById('signup-form').style.display = 'block';
    } else {
        document.getElementById('signin-form').style.display = 'block';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    const status = params.get('status');
    const action = params.get('action') || params.get('form') || 'signin';
    const role = params.get('role');

    if (action === 'signup') {
        document.getElementById('signup-form').style.display = 'block';
        document.getElementById('signin-form').style.display = 'none';
    } else {
        document.getElementById('signin-form').style.display = 'block';
        document.getElementById('signup-form').style.display = 'none';
    }

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
    function handleStatus(status) {
        if (!status) return null;
        switch (status) {
            case 'exist':
                return { msg: 'Email của bạn đã tồn tại. Vui lòng nhập Email khác!', redirect: 'login.php?action=signup' };
            case 'success':
            case 'signup_success':
                return { msg: 'Đăng ký tài khoản thành công!', redirect: 'login.php?action=signin' };
            case 'error':
                if (action === 'signup') {
                    return { msg: 'Đăng ký tài khoản thất bại!', redirect: 'login.php?action=signup' };
                } else {
                    return { msg: 'Đăng nhập thất bại. Tài khoản hoặc mật khẩu của bạn không chính xác!', redirect: 'login.php?action=signin' };
                }
            case 'no_account':
                return { msg: 'Tài khoản không tồn tại!', redirect: 'login.php?action=signin' };
            case 'wrong_password':
                return { msg: 'Mật khẩu không đúng!', redirect: 'login.php?action=signin' };
            case 'no_role':
                return { msg: 'Tài khoản chưa được phân quyền. Vui lòng liên hệ quản trị viên.', redirect: 'login.php?action=signin' };
            case 'invalid_role':
                return { msg: 'Vai trò tài khoản không hợp lệ. Vui lòng liên hệ quản trị viên.', redirect: 'login.php?action=signin' };
            case 'missrole': // cũ
                return { msg: 'Tài khoản chưa được phân quyền. Vui lòng liên hệ quản trị viên.', redirect: 'login.php?action=signin' };
            case 'signin_success':
                if (role === 'admin') return { msg: 'Đăng nhập thành công. Đang chuyển hướng...', redirect: '../BE/Pages/home/home.php' };
                if (role === 'user') return { msg: 'Đăng nhập thành công. Đang chuyển hướng...', redirect: '../FE/TrangChu/user_main.php' };
                return { msg: 'Đăng nhập thành công nhưng vai trò không xác định.', redirect: 'login.php?action=signin' };

            default:
                return null;
        }
    }

    const result = handleStatus(status);
    if (result) {
        showMessage(result.msg);
        if (result.redirect) {
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 2100);
        }
    }
});