<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = $conn->real_escape_string($_POST['ad']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;
    $birim = isset($_POST['birim']) ? intval($_POST['birim']) : 0;

    // Yeni ürün ekleme sorgusu
    $sql = "INSERT INTO cikan (ad, aciklama, stok, birim) VALUES ('$ad', '$aciklama', $stok, $birim)";
    if ($conn->query($sql) === TRUE) {
        // Başarıyla eklendiğinde yönlendir
        header("Location: cikan_urunler.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>