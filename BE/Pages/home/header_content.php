
<div class="head-title">
    <div class="left">
        <h1>Management</h1>
        <ul class="breadcrumb">
            <li>
                <a href="home.php">Admin Panel</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <?php 
                    if (isset($_GET["page"]) && $_GET["page"] != "") {
                        $page = $_GET['page'];

                        if ($page == 'account') { ?>
                            <a class="active" href="home.php?page=account">Quản lí tài khoản</a>
                        <?php } else if ($page == 'user') { ?>
                            <a class="active" href="home.php?page=user">Quản lí khách hàng</a>
                        <?php } else if ($page == 'homestay') { ?>
                            <a class="active" href="home.php?page=homestay">Quản lí homestay</a>
                        <?php } else if ($page == 'rooms') { ?>
                            <a class="active" href="home.php?page=rooms">Quản lí phòng</a>
                        <?php } else if ($page == 'booking') { ?>
                            <a class="active" href="home.php?page=booking">Quản lí đơn đặt phòng</a>
                        <?php } else if ($page == 'payment') { ?>
                            <a class="active" href="home.php?page=payment">Quản lí giao dịch</a>
                        <?php } else if ($page == 'reviews') { ?>
                            <a class="active" href="home.php?page=reviews">Quản lí đánh giá</a>
                        <?php } else if ($page == 'feedback') { ?>
                            <a class="active" href="home.php?page=feedback">Phản hồi khách hàng</a>
                        <?php } else if ($page == 'statistic') { ?>
                            <a class="active" href="home.php?page=statistic">Thống kê & Báo cáo</a>
                        <?php }
                    }
                    ?>
            </li>
        </ul>
    </div>
    <a href="../modules/export.php" class="btn-download">
        <i class='bx bxs-cloud-download'></i>
        <span class="text">Download PDF</span>
    </a>
</div>