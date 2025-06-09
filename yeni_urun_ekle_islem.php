<?php
include('db.php');

// Formdan gelen verileri al
$ad = $_POST['ad'];
$aciklama = $_POST['aciklama'];
$adet = isset($_POST['adet']) ? intval($_POST['adet']) : 0;
$stok = isset($_POST['stok']) ? intval($_POST['stok']) : 0;
$birim = isset($_POST['birim']) ? intval($_POST['birim']) : 0;
$fiyat = isset($_POST['fiyat']) ? floatval($_POST['fiyat']) : 0;
$cikan_id = isset($_POST['cikan_id']) ? intval($_POST['cikan_id']) : null;
$tedarikci_id = isset($_POST['tedarikci_id']) ? intval($_POST['tedarikci_id']) : null;

// SQL sorgusu
$sql = "INSERT INTO giren (ad, aciklama, adet, stok, birim, fiyat, cikan_id, tedarikci_id) 
        VALUES ('$ad', '$aciklama', $adet, $stok, $birim, $fiyat, " . 
        ($cikan_id !== null ? $cikan_id : "NULL") . ", " . 
        ($tedarikci_id !== null ? $tedarikci_id : "NULL") . ")";

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
