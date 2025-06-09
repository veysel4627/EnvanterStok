<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $fiyat = isset($_POST['fiyat']) ? floatval($_POST['fiyat']) : 0;
    $birim = isset($_POST['birim']) ? intval($_POST['birim']) : 0;
    $uretim = isset($_POST['uretim']) ? intval($_POST['uretim']) : 0;

    // Güncelleme sorgusu
    $sql = "UPDATE uretim SET fiyat = $fiyat, birim = $birim, uretim = $uretim WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: uretim_bandi.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
    }
    $conn->close();
}
?>