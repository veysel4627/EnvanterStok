<?php
include('header.php');
include('db.php');

$id = $_GET['id']; // Çıkış ürünü ID'sini al

// Giriş ürünlerini sorgula
$query = "SELECT * FROM giren WHERE cikan_id = $id";
$result = mysqli_query($conn, $query);
?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ürün Detayları</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Giriş Ürün Adı</th>
                    <th>Stok Miktarı</th>
                    <th>Birimi</th>
                    <th>Kaç Haftalık Kaldı</th>
                    <th>Sipariş Ver</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $stok = $row['stok']; // Giriş ürünlerinin stok miktarı
                    $adet = $row['adet']; // Adet sütunu

                    // Bölme işlemi (adet sıfırsa hata olmaması için kontrol eklenir)
                    $haftalik_kalan = ($adet != 0) ? $stok / $adet : 'Kalmadı';

                    echo "<tr>
                        <td>{$row['ad']}</td>
                        <td>{$stok}</td>
                        <td>{$row['birim']}</td>
                        <td>{$haftalik_kalan}</td>
                        <td>
                            <a href='islem_olustur.php?giren_id={$row['id']}' class='btn btn-primary btn-sm'>Sipariş Ver</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>