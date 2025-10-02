<!----SIDEBAR ---->
<section id="sidebar">
    <a class="brand">
        <!-- <i class='bx bx-folder' ></i> -->
        <span class="text">ADMIN PANEL</span>
    </a>
    <ul class="side-menu top">
        <li class="<?= ($page == 'home') ? 'active' : '' ?>">
            <a href="home.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="<?= ($page == 'account') ? 'active' : '' ?>">
            <a href="home.php?page=account">
                <i class='bx bxs-user-account'></i>
                <span class="text">Quản lí tài khoản</span>
            </a>
        </li>
        <li class="<?= ($page == 'user') ? 'active' : '' ?>">
            <a href="home.php?page=user">
                <i class='bx bx-user'></i>
                <span class="text">Quản lí khách hàng</span>
            </a>
        </li>
        <li class="<?= ($page == 'homestay') ? 'active' : '' ?>">
            <a href="home.php?page=homestay">
                <i class='bx bx-home'></i>
                <span class="text">Quản lí Homestay</span>
            </a>
        </li>
        <li class="<?= ($page == 'rooms') ? 'active' : '' ?>">
            <a href="home.php?page=rooms">
                <i class='bx bx-hotel'></i>
                <span class="text">Quản lí phòng</span>
            </a>
        </li>
        <li class="<?= ($page == 'booking') ? 'active' : '' ?>">
            <a href="home.php?page=booking">
                <i class='bx bx-list-check'></i>
                <span class="text">Quản lí đặt phòng</span>
            </a>
        </li>
        <li class="<?= ($page == 'payment') ? 'active' : '' ?>">
            <a href="home.php?page=payment">
                <i class='bx bx-dollar-circle'></i>
                <span class="text">Quản lí thanh toán</span>
            </a>
        </li>
        <li class="<?= ($page == 'reviews') ? 'active' : '' ?>">
            <a href="home.php?page=reviews">
                <i class='bx bx-table'></i>
                <span class="text">Quản lí đánh giá</span>
            </a>
        </li>
        <li class="<?= ($page == 'feedback') ? 'active' : '' ?>">
            <a href="home.php?page=feedback">
                <i class='bx bx-conversation'></i>
                <span class="text">Phản hồi khách hàng</span>
            </a>
        </li>
        <li class="<?= ($page == 'statistic') ? 'active' : '' ?>">
            <a href="home.php?page=statistic">
                <i class='bx bx-bar-chart-alt-2'></i>
                <span class="text">Thống kê & Báo cáo</span>
            </a>
        </li>
        <li>
            <a href="../../../Login/logout.php" class="logout">
                <i class='bx bx-log-out'></i>
                <span>Đăng xuất</span>
            </a>
        </li>
    </ul>
</section>
<!----SIDEBAR ---->