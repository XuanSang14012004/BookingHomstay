<?php
if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        if (isset($_GET['status1'])) {
            $status1 = $_GET['status1'];

        }if (isset($_GET['status2'])) {
            $status2 = $_GET['status2'];
        }
            // ------------------------------page admin--------------------------
        if($page == 'admin_home'){
            include("admin/admin.php");

        }if($page == 'account_admin'){
                include("admin/account_admin.php");

        }elseif($page == 'manage_homestay'){
            include("admin/homestay.php");

        }else if($page == 'manage_booking'){
            include("admin/booking.php");

        }elseif($page == 'manage_payment'){
            include("admin/payment.php");

        }elseif($page == 'baocao'){
            include("admin/baocao.php");

        }elseif($page == 'manage_comment'){
            include("admin/review.php");

        }elseif($page == 'manage_support'){
            include("admin/support.php");
            // ------------------------------page user--------------------------

        }elseif($page == 'user_home'){
            include("admin/user.php");

        }if($page == 'account_user'){
                include("admin/account_user.php");

        }elseif($page == 'info_homestay'){
            include("admin/info_homestay.php");

        }else if($page == 'booking'){
            include("admin/booking.php");

        }elseif($page == 'thanhtoan'){
            include("admin/payment.php");

        }elseif($page == 'danhgia'){
            include("admin/comment.php");

        }
?>