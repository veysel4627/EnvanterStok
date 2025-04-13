<?php
include('db.php');

$ad = $_POST['ad'];
$aciklama = $_POST['aciklama'];
$adet = $_POST['adet'];
$fiyat = $_POST['fiyat'];
$cikan_id = $_POST['cikan_id'];

// SQL sorgusu
$sql = "INSERT INTO giren (ad, aciklama, adet, fiyat, cikan_id) VALUES ('$ad', '$aciklama', '$adet', '$fiyat', '$cikan_id')";

if ($conn->query($sql) === TRUE) {
    echo "Yeni ürün başarıyla eklendi";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Giren Ürünler sayfasına geri dön
header("Location: giren_urunler.php");
exit;
?>
