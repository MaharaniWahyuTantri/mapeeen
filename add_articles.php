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

    <title>Add New Article</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Your custom styles -->
    <link href="assets/css/style.css" rel="stylesheet" />

</head>
<body>

    <div class="wrapper">
        <div class="sidebar">
            <!-- Sidebar content -->
            <ul>
                <!-- Sidebar items -->
            </ul>
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
