<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $ad = $conn->real_escape_string($_POST['ad']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $stok = intval($_POST['stok']);
    $birim = intval($_POST['birim']);
    $fiyat = floatval($_POST['fiyat']);

    // Güncelleme sorgusu
    $update_query = "UPDATE giren SET ad = '$ad', aciklama = '$aciklama', stok = $stok, birim = $birim, fiyat = $fiyat WHERE id = $id";
    if ($conn->query($update_query) === TRUE) {
        echo "<div class='alert alert-success'>Ürün başarıyla güncellendi!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
    }

    $conn->close();
    header("Location: giren_urunler.php");
    exit;
}
?>
