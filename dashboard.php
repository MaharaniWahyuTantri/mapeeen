<?php
session_start();
if (!isset($_SESSION['level'])) {
    header("Location: login.php");
    exit;
}

require 'functions/func_users.php';

// hitung jumlah record
$sql = "SELECT count(*) AS jumlah FROM users";
$res = mysqli_query($conn, $sql);
$jumlah = mysqli_fetch_assoc($res);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>KM Farma</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS -->
    <link id="theme-css" href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications -->
    <link href="assets/css/animate.min.css" rel="stylesheet" />

    <!-- Light Bootstrap Table core CSS -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />

    <!-- CSS for Demo Purpose, don't include it in your project -->
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!-- Fonts and icons -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

    <?php
    // Cek preferensi skema warna dari session atau database
    $themeColor = isset($_SESSION['theme_color']) ? $_SESSION['theme_color'] : 'blue'; // Default theme color

    // Sesuaikan link CSS berdasarkan pilihan tema warna
    $themeCSS = "assets/css/bootstrap.min.css"; // Default CSS

    if ($themeColor == 'red') {
        $themeCSS = "assets/css/red-bootstrap.min.css";
    } elseif ($themeColor == 'green') {
        $themeCSS = "assets/css/green-bootstrap.min.css";
    }
    ?>
    <link id="theme-css" href="<?= $themeCSS ?>" rel="stylesheet" />

    <style> 
    .dropdown-menu{
        margin-left: 130px;
    }
    </style>

</head>

<body>

    <div class="wrapper">
        <div class="sidebar" data-color="red">

            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        <?php
                        if ($_SESSION['level'] == 'admin') {
                            echo "admin apotek";
                        } else if ($_SESSION['level'] == 'apoteker') {
                            echo "apoteker apotek";
                        } else if ($_SESSION['level'] == 'pegawai') {
                            echo "pegawai apotek";
                        }
                        ?>
                    </a>
                </div>

                <ul class="nav">
                    <?php if ($_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pegawai') { ?>
                        <li class="active">
                            <a href="dashboard.php">
                                <i class="pe-7s-graph"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['level'] == 'admin') { ?>
                        <li>
                            <a href="users.php">
                                <i class="pe-7s-user"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pegawai') { ?>
                        <li>
                            <a href="obat.php">
                                <i class="pe-7s-note2"></i>
                                <p>Data Obat</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['level'] == 'pegawai' || $_SESSION['level'] == 'admin') { ?>
                        <li>
                            <a href="penjualan.php">
                                <i class="pe-7s-note2"></i>
                                <p>Data Penjualan</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['level'] == 'pegawai') { ?>
                        <li>
                            <a href="laporan.php">
                                <i class="pe-7s-news-paper"></i>
                                <p>Laporan</p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'admin') { ?>
                        <li>
                            <a href="request_obat.php">
                                <i class="pe-7s-note2"></i>
                                <p>Request Obat</p>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="forum.php">
                            <i class="pe-7s-chat"></i>
                            <p>Forum</p>
                        </a>
                    </li>
                    <li>
                        <a href="articles.php">
                            <i class="pe-7s-news-paper"></i>
                            <p>Articles</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default navbar-fixed">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Dashboard</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-left">
                            <li>
                                <a href="">
                                    <i class="fa fa-search"></i>
                                    <p class="hidden-lg hidden-md">Search</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="logout.php">
                                    <p>Log out</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg"></li>
                        </ul>
                        
                        <!-- Contoh dropdown untuk memilih tema -->
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="themeDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                Theme Color
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="themeDropdown">
                                <li><a href="#" onclick="changeThemeColor('blue')">Blue</a></li>
                                <li><a href="#" onclick="changeThemeColor('red')">Red</a></li>
                                <li><a href="#" onclick="changeThemeColor('green')">Green</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="background-color: #8C0D1C;">
                                <div class="header">
                                    <h6 style="color:#fff;">Stok Obat</h6>
                                    <h1 style="color: #fff;padding: 10px;">
                                        <?php $sql = "SELECT SUM(stok) AS stok FROM `obat`";
                                        $res = mysqli_query($conn, $sql);
                                        $data_stok = mysqli_fetch_assoc($res);
                                        echo $data_stok['stok'];
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card" style="background-color:#D81522;">
                                <div class="header">
                                    <h6 style="color: #fff;">Obat Terjual</h6>
                                    <h1 style="color: #fff;padding: 10px;">
                                        <?php $sql = "SELECT SUM(jumlah_obat) AS jumlah FROM `penjualan`";
                                        $res = mysqli_query($conn, $sql);
                                        $jum_h = mysqli_fetch_assoc($res);
                                        echo $jum_h['jumlah'];
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card" style="background-color: #8C0D1C;">
                                <div class="header">
                                    <h6 style="color: #fff;">Obat Expired</h6>
                                    <h1 style="color: #fff;padding: 10px;">
                                        <?php
                                        $tgl = date("Y-m-d");
                                        $sql = " SELECT COUNT(id) AS id FROM `obat` WHERE expired <= '$tgl'";
                                        $res = mysqli_query($conn, $sql);
                                        $data_stok = mysqli_fetch_assoc($res);
                                        echo $data_stok['id'];
                                        ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'pegawai') { ?>
                            <div class="col-md-3">
                                <div class="card" style="background-color: #D81522;">
                                    <div class="header">
                                        <h6 style="color: #fff;">Users</h6>
                                        <h1 style="color: #fff;padding: 10px;"><?= $jumlah['jumlah'] ?></h1>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div> <!-- end of content -->

            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </footer>

        </div>
    </div>

</body>

<!-- Core JS Files -->
<script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>

<script>
    // Contoh fungsi untuk mengubah tema warna
    function changeThemeColor(color) {
        // Simpan preferensi ke session atau database di sini
        $.ajax({
            url: 'save_theme_preference.php',
            type: 'POST',
            data: { theme_color: color },
            success: function(response) {
                // Berhasil disimpan, lakukan pengaturan tema
                var themeCSS = 'assets/css/' + color + '-bootstrap.min.css';
                $('#theme-css').attr('href', themeCSS);
            },
            error: function(xhr, status, error) {
                console.error('Failed to save theme preference: ' + error);
            }
        });
    }
</script>

</html>
