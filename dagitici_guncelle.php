<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $ad = $conn->real_escape_string($_POST['ad']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $iletisim = $conn->real_escape_string($_POST['iletisim']);
    $adres = $conn->real_escape_string($_POST['adres']);

    $sql = "UPDATE dagitici SET ad = '$ad', aciklama = '$aciklama', iletisim = '$iletisim', adres = '$adres' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dagitici.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
    }

    $conn->close();
}
?>