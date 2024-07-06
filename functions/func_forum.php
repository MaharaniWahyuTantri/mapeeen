<?php
require 'config.php'; // Memasukkan file koneksi database

// Function to fetch forum messages
function fetch_forum_messages() {
    global $conn;
    
    $sql = "SELECT * FROM forum_messages ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    
    $messages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    
    return $messages;
}

// Function to add a message to the forum
function add_forum_message($username, $message) {
    global $conn;
    
    $sql = "INSERT INTO forum_messages (username, message) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $message);
    
    $success = mysqli_stmt_execute($stmt);
    
    if ($success) {
        $response = [
            'success' => true,
            'message' => 'Message added successfully.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to add message.'
        ];
    }
    
    mysqli_stmt_close($stmt);
    
    return $response;
}

// Function to add a reply to a message
function add_forum_reply($message_id, $username, $reply_message) {
    global $conn;
    
    $sql = "INSERT INTO forum_replies (message_id, username, reply_message) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $message_id, $username, $reply_message);
    
    $success = mysqli_stmt_execute($stmt);
    
    if ($success) {
        $response = [
            'success' => true,
            'message' => 'Reply added successfully.'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Failed to add reply.'
        ];
    }
    
    mysqli_stmt_close($stmt);
    
    return $response;
}

// Handle actions
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'add_message') {
        if (isset($_POST['username']) && isset($_POST['message'])) {
            $username = $_POST['username'];
            $message = $_POST['message'];
            
            // Call function to add message
            $result = add_forum_message($username, $message);
            
            // Redirect back to forum.php after adding message
            if ($result['success']) {
                header('Location: ../forum.php');
                exit;
            } else {
                echo 'Failed to add message. Please try again.';
                exit;
            }
        } else {
            echo 'Username and message are required.';
            exit;
        }
    } elseif ($_GET['action'] == 'reply_message') {
        if (isset($_POST['message_id']) && isset($_POST['username']) && isset($_POST['reply_message'])) {
            $message_id = $_POST['message_id'];
            $username = $_POST['username'];
            $reply_message = $_POST['reply_message'];
            
            // Call function to add reply
            $result = add_forum_reply($message_id, $username, $reply_message);
            
            // Redirect back to forum.php after adding reply
            if ($result['success']) {
                header('Location: ../forum.php');
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
}
?>
