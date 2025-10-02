<!-- NAVBAR -->
<nav>
    <i class='bx bx-menu'> Menu</i>
    <form action="">
        <div class="form-input">
            <input type="search" placeholder="Search">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
    <a href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">8</span>
    </a>
    <a href="home.php?page=profile" class="profile">
        <div class="info-left">
            <img src="../../Images/user.jpg" alt="">
        </div> 
        <div class="info-right">
            <p><?php echo $_SESSION['fullname']; ?></p>
            <p  class="name"><?php if($_SESSION['role'] ==='user'){
                        echo 'Khách hàng';
                    }else if($_SESSION['role'] === 'owner'){
                        echo 'Chủ homestay';
                    }else if($_SESSION['role'] === 'admin'){
                        echo 'Quản trị viên';
                    } ?></p>
        </div>
    </a>
</nav>
