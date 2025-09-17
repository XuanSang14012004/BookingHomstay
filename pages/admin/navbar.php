<!-- NAVBAR -->
<nav>
    <i class='bx bx-menu'> Menu</i>
    <form action="#">
        <div class="form-input">
            <input type="search" placeholder="Search">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
    <a href="#" class="notification">
        <i class='bx bxs-bell'></i>
        <span class="num">8</span>
    </a>
    <a href="#" class="profile">
        <img src="../../images/user.jpg" alt="">
        <ul class="side-menu-user">
            <li>
                <a href="profile.php">
                    <i class='bx bxs-user-detail'>
                        <span>Thông tin tài khoản</span>
                    </i>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-cog'>
                        <span>Cài đặt</span>
                    </i>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-help-circle'>
                        <span>Trợ giúp</span>
                    </i>

                </a>
            </li>
            <li>
                <a href="../Login/logout.php">
                    <i class='bx bx-log-out'>
                        <span>Đăng xuất</span>
                    </i>
                </a>
            </li>
        </ul>
    </a>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const profile = document.querySelector(".profile img");
            const menu = document.querySelector(".side-menu-user");

            profile.addEventListener("click", function(e) {
                e.preventDefault();
                menu.classList.toggle("active");
            });

            document.addEventListener("click", function(e) {
                if (!profile.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.remove("active");
                }
            });
        });
    </script>
</nav>
<!-- NAVBAR -->