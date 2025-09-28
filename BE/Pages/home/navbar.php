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
            <p><?php echo $_SESSION['role']; ?></p>
        </div>
    </a>
</nav>
