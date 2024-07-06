<?php
session_start();
require 'functions/func_users.php';

// Fetch articles from database
$sql = "SELECT * FROM articles ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>FMJ Farma Admin</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

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

    <!-- Custom CSS for article accordion -->
    <style>
        .clickable {
            cursor: pointer;
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-heading .panel-title {
            font-weight: bold;
        }

        .panel-heading .arrow-icon {
            transition: transform 0.3s ease;
        }

        .hidden-content {
            display: none;
            padding: 10px;
        }

        .panel-body.open {
            display: block;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">
                        KNOWLEDGE ARTICLES
                    </a>
                </div>

                <ul class="nav">
                    <li>
                        <a href="dashboard.php">
                            <i class="pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a href="forum.php">
                            <i class="pe-7s-chat"></i>
                            <p>Forum</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="articles.php">
                            <i class="pe-7s-news-paper"></i>
                            <p>Artikel</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <!-- Navbar content -->
            <nav class="navbar navbar-default navbar-fixed">
                <div class="container-fluid">
                    <!-- Navbar header -->
                </div>
            </nav>

            <!-- Content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Artikel Terkait Obat</h2>
                            <a href="add_articles.php" class="btn btn-primary">Add New Article</a>
                            <hr>
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading clickable">
                                        <h3 class="panel-title"><?= htmlspecialchars($row['title']) ?></h3>
                                        <i class="fa fa-angle-down arrow-icon"></i>
                                    </div>
                                    <div class="panel-body hidden-content">
                                        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                                        <p>Author: <?= htmlspecialchars($row['author']) ?></p>
                                        <p>Date: <?= htmlspecialchars($row['created_at']) ?></p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <!-- Footer content -->
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript files -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript for article accordion -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const panels = document.querySelectorAll(".panel");

            panels.forEach(panel => {
                const title = panel.querySelector(".panel-heading");
                const content = panel.querySelector(".panel-body");

                title.addEventListener("click", function () {
                    content.classList.toggle("open");
                    title.querySelector(".arrow-icon").classList.toggle("rotate");
                });
            });
        });
    </script>
</body>

</html>
