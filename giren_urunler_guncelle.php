<?php
include('db.php');

$id = $_POST['id'];
$fiyat = $_POST['fiyat'];

// SQL sorgusu
$sql = "UPDATE giren SET fiyat='$fiyat' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Kayıt başarıyla güncellendi";
} else {
    echo "Hata: " . $sql . "<br>" . $conn->error;
}

$conn->close();

// Giren Ürünler sayfasına geri dön
header("Location: giren_urunler.php");
exit;
?>
