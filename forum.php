<?php
session_start();
require 'functions/func_forum.php';

// Fetch forum messages
$messages = fetch_forum_messages();

function display_replies($message_id) {
    global $conn;
    
    $sql = "SELECT * FROM forum_replies WHERE message_id = ? ORDER BY created_at ASC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $message_id);
    mysqli_stmt_execute($stmt);
    
    $replies = [];
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $replies[] = $row;
    }
    
    mysqli_stmt_close($stmt);
    
    if (!empty($replies)) {
        foreach ($replies as $reply) {
            echo '<div class="message reply">';
            echo '<p><strong>' . htmlspecialchars($reply['username']) . ' (Reply):</strong> ' . htmlspecialchars($reply['reply_message']) . '</p>';
            echo '<small>' . htmlspecialchars($reply['created_at']) . '</small>';
            echo '</div>';
        }
    } else {
        echo '<p>No replies yet.</p>';
    }
}

// Handle reply submission
if (isset($_POST['action']) && $_POST['action'] == 'reply_message') {
    if (isset($_POST['message_id'], $_POST['username'], $_POST['reply_message'])) {
        $message_id = $_POST['message_id'];
        $username = $_POST['username'];
        $reply_message = $_POST['reply_message'];
        
        // Call function to add reply
        $result = add_forum_reply($message_id, $username, $reply_message);
        
        // Redirect back to forum.php after adding reply
        if ($result['success']) {
            header('Location: forum.php');
            exit;
        } else {
            echo 'Failed to add reply. Please try again.';
            exit;
        }
    } else {
        echo 'Message ID, username, and reply message are required.';
        exit;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Discussion Forum</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet" />
    <link href="assets/css/demo.css" rel="stylesheet" />
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    
    <style>
        .reply-form {
            display: none; 
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
                <?php if($_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pegawai') { ?>
                    <li>
                        <a href="dashboard.php">
                            <i class="pe-7s-graph"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if($_SESSION['level'] == 'admin') { ?>
                    <li>
                        <a href="users.php">
                            <i class="pe-7s-user"></i>
                            <p>Users</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if($_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'admin' || $_SESSION['level'] == 'pegawai') { ?>
                    <li>
                        <a href="obat.php">
                            <i class="pe-7s-note2"></i>
                            <p>Data Obat</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if($_SESSION['level'] == 'pegawai' || $_SESSION['level'] == 'admin') { ?>
                    <li>
                        <a href="penjualan.php">
                            <i class="pe-7s-note2"></i>
                            <p>Data Penjualan</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if($_SESSION['level'] == 'pegawai') { ?>
                    <li>
                        <a href="laporan.php">
                            <i class="pe-7s-news-paper"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                <?php } ?>
                <?php if($_SESSION['level'] == 'apoteker' || $_SESSION['level'] == 'admin') { ?>
                    <li>
                        <a href="request_obat.php">
                            <i class="pe-7s-note2"></i>
                            <p>Request Obat</p>
                        </a>
                    </li>
                <?php } ?>
                <li  class="active">
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
                        <a class="navbar-brand" href="#">Discussion Forum</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#">
                                    <p>Log out</p>
                                </a>
                            </li>
                            <!-- Add more navbar items here as needed -->
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Discussion Forum</h4>
                                    <p class="category">Send and view messages</p>
                                </div>
                                <div class="content">
                                    <form method="POST" action="functions/func_forum.php?action=add_message">
                                        <div class="form-group">
                                            <label for="username">Your Username</label>
                                            <input type="text" class="form-control" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message</label>
                                            <textarea class="form-control" name="message" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </form>
                                    <hr>
                                    <div class="messages">
                                        <?php foreach ($messages as $message) { ?>
                                            <div class="message">
                                                <p><strong><?php echo htmlspecialchars($message['username']); ?>:</strong> <?php echo htmlspecialchars($message['message']); ?></p>
                                                <small><?php echo htmlspecialchars($message['created_at']); ?></small>
                                                
                                                <!-- Button to toggle reply form -->
                                                <button class="btn btn-default btn-sm" onclick="toggleReplyForm(<?php echo $message['id']; ?>)">Add Reply</button>
                                                
                                                <!-- Reply form for each message -->
                                                <form id="replyForm_<?php echo $message['id']; ?>" class="reply-form" style="margin-top: 10px;" method="POST" action="forum.php">
                                                    <input type="hidden" name="action" value="reply_message">
                                                    <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                                    <div class="form-group">
                                                        <label for="username">Your Username</label>
                                                        <input type="text" class="form-control" name="username" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reply_message">Reply</label>
                                                        <textarea class="form-control" name="reply_message" rows="2" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary btn-sm">Reply</button>
                                                </form>
                                                
                                                <!-- Display replies -->
                                                <?php display_replies($message['id']); ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul>
                            <li><a href="#">Home</a></li>
                        </ul>
                    </nav>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>
    <script>
        // JavaScript function to toggle reply form visibility
        function toggleReplyForm(messageId) {
            var formId = 'replyForm_' + messageId;
            var replyForm = document.getElementById(formId);
            if (replyForm.style.display === 'none') {
                replyForm.style.display = 'block';
            } else {
                replyForm.style.display = 'none';
            }
        }
    </script>
</body>
</html>
