document.addEventListener('DOMContentLoaded', function() {
    const sidebar_state_key = 'sidebar_is_hidden';
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

    allSideMenu.forEach(item => {
        const li = item.parentElement;

        item.addEventListener('click', function () {
            allSideMenu.forEach(i => {
                i.parentElement.classList.remove('active');
            })
            li.classList.add('active');
        })
    });

    // TOGGLE SIDEBAR
    const menuBar = document.querySelector('#content nav .bx.bx-menu');
    const sidebar = document.getElementById('sidebar');

    function loadSidebarState() {
        const isHidden = localStorage.getItem(sidebar_state_key) === 'true'; 
        if (isHidden) {
            sidebar.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
        }
    }
    
    loadSidebarState();
    menuBar.addEventListener('click', function () {
        sidebar.classList.toggle('hide');
        
        const isHiddenAfterToggle = sidebar.classList.contains('hide');
        localStorage.setItem(sidebar_state_key, isHiddenAfterToggle);
    });

    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    const searchForm = document.querySelector('#content nav form');

    searchButton.addEventListener('click', function (e) {
        if(window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            if(searchForm.classList.contains('show')) {
                searchButtonIcon.classList.replace('bx-search', 'bx-x');
            } else {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
            }
        }
    });
});

function goBack() {
      window.history.back();
    }