<?php
session_start();
require_once('../../Config/connect.php');
if (
    isset($_SESSION['email']) && isset($_SESSION['password'])
    && isset($_SESSION['role'])
) { ?>
<?php } else {
    header("Location: Pages/Login/login.php");
    exit();
}
?>
<?php
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Css/style_admin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../Css/test.css">
    <title>ADMIN DASHBOARD</title>
</head>

<body>
    <!-- SIDEBAR -->
    <?php include "sidebar.php"; ?>
    <section id="content">
        <!-- NAVBAR -->
        <?php include "navbar.php"; ?>
        <main>
            <?php
            if (!isset($_GET['page'])) {
                include "dashboard.php";
            } else {
                include $_GET['page'] . '.php';
            }
            ?>
        </main>
    </section>
    <script src="../../Js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../Js/chart.js"></script>
    <script src="../../Js/test.js"></script>
</body>

</html>