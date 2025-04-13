<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">İşlemler</h1>
        <a href="islem_olustur.php" class="btn btn-success">Yeni İşlem Oluştur</a>
    </div>

    <!-- Başarı veya hata mesajlarını göster -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="alert alert-success">İşlem başarıyla güncellendi!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php
            switch ($_GET['error']) {
                case 'stok_negatif':
                    echo "Hata: Stok miktarı negatif olamaz!";
                    break;
                case 'stok_guncellenemedi':
                    echo "Hata: Stok güncellenemedi!";
                    break;
                case 'durum_guncellenemedi':
                    echo "Hata: İşlem durumu güncellenemedi!";
                    break;
                case 'islem_bulunamadi':
                    echo "Hata: İşlem bulunamadı!";
                    break;
                default:
                    echo "Bilinmeyen bir hata oluştu.";
            }
            ?>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>İşlem Türü</th>
                    <th>Miktar</th>
                    <th>İşlem Tarihi</th>
                    <th>Oluşturan Kullanıcı</th>
                    <th>Durum</th>
                    <th>Güncelle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('db.php');

                // SQL sorgusu
                $sql = "SELECT islem.id, giren.ad AS urun_adi, islem.islem_turu, islem.miktar, islem.islem_tarihi, kullanici.ad_soyad AS olusturan_kullanici, islem.durum 
                        FROM islem 
                        JOIN giren ON islem.giren_id = giren.id 
                        JOIN kullanici ON islem.kullanici_id = kullanici.id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Veri çıktısı
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<form action='islem_durum_degistir.php' method='POST'>";
                        echo "<td>" . $row["urun_adi"] . "</td>";

                        // İşlem türünü kontrol et ve göster
                        $islem_turu = ($row["islem_turu"] == 0) ? "Satın Alma" : "Satılma";
                        echo "<td>" . $islem_turu . "</td>";

                        echo "<td>" . $row["miktar"] . "</td>";
                        echo "<td>" . $row["islem_tarihi"] . "</td>";
                        echo "<td>" . $row["olusturan_kullanici"] . "</td>";
                        echo "<td>";
                        if ($row["durum"] == 1) {
                            echo "<select name='durum' class='form-control' disabled>";
                            echo "<option value='1' selected>Tamamlandı</option>";
                            echo "</select>";
                        } else {
                            echo "<select name='durum' class='form-control'>";
                            echo "<option value='1'>Tamamlandı</option>";
                            echo "<option value='0' selected>Tamamlanmadı</option>";
                            echo "</select>";
                        }
                        echo "</td>";
                        echo "<td>";
                        if ($row["durum"] == 0) {
                            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                            echo "<button type='submit' class='btn btn-primary btn-sm'>Güncelle</button>";
                        } else {
                            echo "-";
                        }
                        echo "</td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Kayıt bulunamadı</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</main>
