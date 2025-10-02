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
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const form = urlParams.get('form');

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
    if(form === 'signup'){
        if(status === 'exist'){
            showMessage('Email của bạn đã tồn tài. Vui lòng nhập Email khác!');
        } else if (status === 'success') {
            showMessage('Đăng kí tài khoản thành công!');
        }else if (status === 'error') {
            showMessage('Đăng kí tài khoản thất bài!');
        }
    }

    if(form === 'signin'){
        if (status === 'error') {
            showMessage('Đăng nhập thất bài. Tài khoản hoặc mật khẩu của bạn không chính xác!');
        } else if(status === 'missrole'){
            showMessage('Đăng nhập thất bài. Tài khoản mà bạn nhập chưa được xếp nhóm phân quyền!');
        }
    }
});