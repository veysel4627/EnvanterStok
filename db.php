<?php
$servername = "localhost";
$username = "root"; // Veritabanı kullanıcı adınız
$password = "12345678"; // Veritabanı şifreniz
$dbname = "envanter"; // Veritabanı adınız

// Veritabanı bağlantısı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol etme
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
