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