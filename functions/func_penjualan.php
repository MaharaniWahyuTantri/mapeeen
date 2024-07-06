<?php 
require 'config.php';

// insert data
function insert($data){
    global $conn;
    $obat = $data['obat'];
    $jumlah = htmlspecialchars($data['jumlah']);
    
    $sql = "INSERT INTO `penjualan` (`id_obat`, `tanggal`, `jumlah_obat`) VALUES (?, CURRENT_TIMESTAMP, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $obat, $jumlah);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

// delete data
function delete($id){
    global $conn;
    
    $sql = "DELETE FROM penjualan WHERE id_penjualan = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

// update data
function update($data){
    global $conn;
    $id = $data['id'];
    $tanggal = htmlspecialchars($data['tanggal']);
    $obat = htmlspecialchars($data['obat']);
    $jumlah = htmlspecialchars($data['jumlah']);
    
    $sql = "UPDATE penjualan SET id_obat = ?, tanggal = ?, jumlah_obat = ? WHERE id_penjualan = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isii", $obat, $tanggal, $jumlah, $id);
    mysqli_stmt_execute($stmt);
    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        die("Error: " . mysqli_error($conn));
    }
}

// search data
function search($keyword){
    global $conn;
    $keyword = "%" . $keyword . "%";
    
    $sql = "SELECT * FROM penjualan WHERE
            tanggal LIKE ? OR
            id_obat LIKE ? OR
            jumlah_obat LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $keyword, $keyword, $keyword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
?>
