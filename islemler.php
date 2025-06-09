<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="container py-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 mb-0">İşlemler</h1>
            <a href="islem_olustur.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Yeni İşlem Oluştur
            </a>
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
                    case 'stok_guncelenemedi':
                        echo "Hata: Stok güncellenemedi!";
                        break;
                    case 'durum_guncelenemedi':
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

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ürün Adı</th>
                                <th>İşlem Türü</th>
                                <th>Miktar</th>
                                <th>Birim</th>
                                <th>İşlem Tarihi</th>
                                <th>Oluşturan Kullanıcı</th>
                                <th>Dağıtıcı</th>
                                <th>Durum</th>
                                <th>Güncelle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('db.php');
                            function birimText($birim) {
                                switch($birim) {
                                    case 0: return "m²";
                                    case 1: return "Kilo";
                                    case 2: return "Koli";
                                    case 3: return "m³";
                                    default: return "-";
                                }
                            }
                            $sql = "SELECT islem.id, giren.ad AS urun_adi, islem.islem_turu, islem.miktar, islem.birim, islem.islem_tarihi, 
                                           kullanici.ad_soyad AS olusturan_kullanici, dagitici.ad AS dagitici_adi, islem.durum 
                                    FROM islem 
                                    JOIN giren ON islem.giren_id = giren.id 
                                    JOIN kullanici ON islem.kullanici_id = kullanici.id
                                    LEFT JOIN dagitici ON islem.dagitici_id = dagitici.id
                                    ORDER BY islem.islem_tarihi DESC";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<form action='islem_durum_degistir.php' method='POST' class='d-flex'>";
                                    echo "<td>" . htmlspecialchars($row["urun_adi"]) . "</td>";

                                    // İşlem türü
                                    $islem_turu = "Satın Alma";
                                    if ($row["islem_turu"] == 1) $islem_turu = "Satılma";
                                    if ($row["islem_turu"] == 2) $islem_turu = "Taşıma";
                                    echo "<td>" . $islem_turu . "</td>";

                                    echo "<td>" . $row["miktar"] . "</td>";
                                    echo "<td>" . birimText($row["birim"]) . "</td>";
                                    echo "<td>" . date('d.m.Y H:i', strtotime($row["islem_tarihi"])) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["olusturan_kullanici"]) . "</td>";
                                    echo "<td>" . ($row["dagitici_adi"] ? htmlspecialchars($row["dagitici_adi"]) : "<span class='text-muted'>Belirtilmedi</span>") . "</td>";

                                    echo "<td>";
                                    if ($row["durum"] == 1) {
                                        echo "<select name='durum' class='form-control form-control-sm' disabled>";
                                        echo "<option value='1' selected>Tamamlandı</option>";
                                        echo "</select>";
                                    } else {
                                        echo "<select name='durum' class='form-control form-control-sm'>";
                                        echo "<option value='1' " . ($row["durum"] == 1 ? "selected" : "") . ">Tamamlandı</option>";
                                        echo "<option value='0' " . ($row["durum"] == 0 ? "selected" : "") . ">Tamamlanmadı</option>";
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
                                echo "<tr><td colspan='9' class='text-center text-muted'>Kayıt bulunamadı</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
