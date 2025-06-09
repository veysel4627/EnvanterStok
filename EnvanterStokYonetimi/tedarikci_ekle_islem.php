<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ad = $conn->real_escape_string($_POST['ad']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $iletisim = $conn->real_escape_string($_POST['iletisim']);
    $adres = $conn->real_escape_string($_POST['adres']);

    $sql = "INSERT INTO tedarikci (ad, aciklama, iletisim, adres) VALUES ('$ad', '$aciklama', '$iletisim', '$adres')";
    if ($conn->query($sql) === TRUE) {
        header("Location: tedarikci.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>