<?php 
 if($page===1){

}elseif(($_GET['page'])=='rooms'){
include "../page/rooms.php";

}elseif(($_GET['page'])=='payment'){
include "../page/payment.php";
            }elseif(($_GET['page'])=='feedback'){
include "../page/feedback.php";
            }
?>


<li class="<?= ($page == 'feedback') ? 'active' : '' ?>">
            <a href="home.php?page=feedback">
                <i class='bx bx-conversation'></i>
                <span class="text">Phản hồi khách hàng</span>
            </a>
        </li>



                <li class="<?= ($page == 'rooms') ? 'active' : '' ?>">
            <a href="home.php?page=rooms">
                <i class='bx bx-hotel'></i>
                <span class="text">Quản lí phòng</span>
            </a>
        </li>