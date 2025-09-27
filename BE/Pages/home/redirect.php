<?php
//----------------------Page----------------------
            if (!isset($_GET['page'])) {
                include "dashboard.php";
            }elseif(($_GET['page'])=='profile'){
                include "../page/profile.php";
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
            }elseif(($_GET['page'])=='feedback'){
                include "../page/feedback.php";
            }elseif(($_GET['page'])=='delete'){
                include "../modules/delete_function.php";
            }else {
                include $_GET['page'] . '.php';
            }
        
        
?>