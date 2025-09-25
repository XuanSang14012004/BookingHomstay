<?php
session_start();
require_once('../../Config/connect.php');
if (
   isset($_SESSION['fullname']) && isset($_SESSION['email']) && isset($_SESSION['password']) && isset($_SESSION['role']) ) { ?>
    
<?php } else {
    header("Location: Pages/Login/login.php");
    exit();
}
?>
<?php
$page = $_GET['page'] ?? 'home';
$id = $_GET['id'] ??'';
ob_start();
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
    <?php include "sidebar.php"; ?>
    <section id="content">
        <?php include "navbar.php"; ?>
        <main>
            <?php include "redirect.php" ?>
            <script src="../../Js/test.js"></script>    
        </main>
    </section>
    <script src="../../Js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../Js/chart.js"></script>
    
</body>

</html>
<?php ob_end_flush()?>