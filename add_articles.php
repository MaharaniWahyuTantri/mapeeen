<?php
session_start();
require 'functions/func_users.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author = mysqli_real_escape_string($conn, $_POST['author']); // Ambil nama author dari input form

    $sql = "INSERT INTO articles (title, content, author) VALUES ('$title', '$content', '$author')";
    if (mysqli_query($conn, $sql)) {
        header("Location: articles.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
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
        <div class="sidebar" data-color="red" data-image="assets/img/sidebar-5.jpg">
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
                            <h2>Add New Article</h2>
                            <form method="post" action="add_articles.php">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" required>
                                </div>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea class="form-control" rows="5" name="content" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Author</label>
                                    <?php if (isset($_SESSION['username'])) : ?>
                                        <input type="text" class="form-control" name="author" value="<?= $_SESSION['username'] ?>">
                                    <?php else : ?>
                                        <input type="text" class="form-control" name="author" value="">
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
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
</body>
</html>
