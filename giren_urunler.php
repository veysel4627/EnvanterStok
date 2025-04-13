<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Giren Ürünler</h1>
        <a href="yeni_urun_ekle.php" class="btn btn-primary">Yeni Ürün Ekle</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Açıklama</th>
                    <th>Adet</th>
                    <th>Fiyat</th>
                    <th>Çıkan Ürün</th>
                    <th>Eklenme Tarihi</th>
                    <th>Güncellenme Tarihi</th>
                    <th>Güncelle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('db.php');

                // SQL sorgusu
                $sql = "SELECT giren.id, giren.ad, giren.aciklama, giren.adet, giren.fiyat, cikan.ad AS cikan_urun, giren.eklenme, giren.guncelleme 
                        FROM giren 
                        LEFT JOIN cikan ON giren.cikan_id = cikan.id";
                $result = $conn->query($sql);

                if ($result === FALSE) {
                    echo "SQL hatası: " . $conn->error;
                } else {
                    if ($result->num_rows > 0) {
                        // Veri çıktısı
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<form action='giren_urunler_guncelle.php' method='POST'>";
                            echo "<td>" . $row["ad"] . "</td>";
                            echo "<td>" . $row["aciklama"] . "</td>";
                            echo "<td>" . $row["adet"] . "</td>";
                            echo "<td><input type='text' name='fiyat' value='" . $row["fiyat"] . "' class='form-control'></td>";
                            echo "<td>" . $row["cikan_urun"] . "</td>";
                            echo "<td>" . $row["eklenme"] . "</td>";
                            echo "<td>" . $row["guncelleme"] . "</td>";
                            echo "<td>";
                            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                            echo "<button type='submit' class='btn btn-primary btn-sm'>Güncelle</button>";
                            echo "</td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Kayıt bulunamadı</td></tr>";
                    }
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</main>
