<?php
//----------------------Page----------------------
            if (!isset($_GET['page'])) {
                include "dashboard.php";
            }elseif(($_GET['page'])=='account'){
                include "../page/account.php";
            }elseif(($_GET['page'])=='user'){
                include "../page/user.php";
            }elseif(($_GET['page'])=='homestay'){
                include "../page/homestay.php";
            }elseif(($_GET['page'])=='rooms'){
                include "../page/rooms.php";
            }elseif(($_GET['page'])=='booking'){
                include "../page/booking.php";
            }elseif(($_GET['page'])=='payment'){
                include "../page/payment.php";
            }elseif(($_GET['page'])=='reviews'){
                include "../page/reviews.php";
            }elseif(($_GET['page'])=='statistic'){
                include "../page/statistic.php";
            }elseif(($_GET['page'])=='support'){
                include "../page/support.php";
// ---------------------Tool_add---------------------
            }elseif(($_GET['page'])=='add_user'){
                include "../Modules/Create/add_user.php";
            }elseif(($_GET['page'])=='add_homestay'){
                include "../Modules/Create/add_homestay.php";
            }elseif(($_GET['page'])=='add_rooms'){
                include "../Modules/Create/add_rooms.php";
            }elseif(($_GET['page'])=='add_booking'){
                include "../Modules/Create/add_booking.php";
            }elseif(($_GET['page'])=='add_payment'){
                include "../Modules/Create/add_payment.php";
// ---------------------Tool_update---------------------
            }elseif(($_GET['page'])=='update_user'){
                include "../Modules/Update/update_user.php";
            }elseif(($_GET['page'])=='update_homestay'){
                include "../Modules/Update/update_homestay.php";
            }elseif(($_GET['page'])=='update_rooms'){
                include "../Modules/Update/update_rooms.php";
            }elseif(($_GET['page'])=='update_booking'){
                include "../Modules/Update/update_booking.php";
            }elseif(($_GET['page'])=='update_payment'){
                include "../Modules/Update/update_payment.php";
            }elseif(($_GET['page'])=='update_reviews'){
                include "../Modules/Update/update_reviews.php";

// ---------------------Tool_read---------------------
            }elseif(($_GET['page'])=='detail_user'){
                include "../Modules/Read/detail_user.php";
            }elseif(($_GET['page'])=='detail_homestay'){
                include "../Modules/Read/detail_homestay.php";
            }elseif(($_GET['page'])=='detail_rooms'){
                include "../Modules/Read/detail_rooms.php";
            }elseif(($_GET['page'])=='detail_booking'){
                include "../Modules/Read/detail_booking.php";
            }elseif(($_GET['page'])=='detail_payment'){
                include "../Modules/Read/detail_payment.php";
            }elseif(($_GET['page'])=='detail_reviews'){
                include "../Modules/Read/detail_reviews.php";
            }elseif(($_GET['page'])=='detail_feedback'){
                include "../Modules/Read/detail_feedback.php"; 

// ---------------------Tool_delete---------------------
            }elseif(($_GET['page'])=='delete'){
                include "../Modules/Delete/delete.php";
            }else {
                include $_GET['page'] . '.php';
            }
?>