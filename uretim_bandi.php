<?php
include('header.php');
include('db.php');

// Üretim tablosundaki tüm verileri al
$uretim_query = "SELECT u.id AS uretim_id, u.cikan_id, u.birim, u.fiyat, c.ad AS cikan_urun_adi 
                 FROM uretim u 
                 JOIN cikan c ON u.cikan_id = c.id";
$uretim_result = mysqli_query($conn, $uretim_query);
?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Üretim Listesi</h1>
        <a href="uretim_olustur.php" class="btn btn-success">Yeni Üretim Bandı Oluştur</a>
    </div>

    <!-- Üretim Tablosu -->
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Üretim ID</th>
                    <th>Çıkış Ürün Adı</th>
                    <th>Birim</th>
                    <th>Fiyat</th>
                    <th>Düzenle</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($uretim = mysqli_fetch_assoc($uretim_result)): ?>
                    <tr>
                        <td><?php echo $uretim['uretim_id']; ?></td>
                        <td><?php echo $uretim['cikan_urun_adi']; ?></td>
                        <td><?php echo $uretim['birim']; ?></td>
                        <td><?php echo $uretim['fiyat']; ?></td>
                        <td>
                            <a href="uretim_duzenle.php?id=<?php echo $uretim['uretim_id']; ?>" class="btn btn-primary btn-sm">Düzenle</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>