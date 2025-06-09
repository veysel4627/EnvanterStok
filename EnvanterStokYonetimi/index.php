<?php include("header.php"); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <h1 class="display-5 mb-3 text-primary">Envanter Yönetim Sistemine Hoş Geldiniz</h1>
                    <p class="lead mb-4">
                        Bu panel üzerinden üretim, stok, tedarikçi, dağıtıcı ve işlemlerinizi kolayca yönetebilirsiniz.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <a href="cikan_urunler.php" class="btn btn-outline-primary btn-lg px-4">Çıkış Ürünleri</a>
                        <a href="uretim_bandi.php" class="btn btn-outline-warning btn-lg px-4">Üretim Bantları</a>
                        <a href="islemler.php" class="btn btn-outline-info btn-lg px-4">İşlemler</a>
                        <a href="tedarikci.php" class="btn btn-outline-secondary btn-lg px-4">Tedarikçiler</a>
                        <a href="dagitici.php" class="btn btn-outline-dark btn-lg px-4">Dağıtıcılar</a>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Uyarılar - Kritik Stokta Olan Ürünler</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ürün Adı</th>
                                <th>Açıklama</th>
                                <th>Stok</th>
                                <th>Birim</th>
                                <th>Kalan Hafta</th>
                                <th>Fiyat</th>
                                <th>Sipariş Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('db.php');
                            // Kritik stokta olan ürünleri bul
                            $sql = "SELECT giren.id, giren.ad, giren.aciklama, giren.stok, giren.adet, giren.birim, giren.fiyat, giren.cikan_id
                                    FROM giren";
                            $result = $conn->query($sql);

                            function birimText($birim) {
                                switch($birim) {
                                    case 0: return "m²";
                                    case 1: return "Kilo";
                                    case 2: return "Koli";
                                    case 3: return "m³";
                                    default: return "-";
                                }
                            }

                            $kritik_var = false;
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Üretim bandı sayısı
                                    $uretim_bandi_sayisi = 1;
                                    if ($row["cikan_id"]) {
                                        $uretim_bandi_sorgu = $conn->query("SELECT COUNT(*) as sayi FROM uretim WHERE cikan_id = " . intval($row["cikan_id"]));
                                        if ($uretim_bandi_sorgu) {
                                            $uretim_bandi_row = $uretim_bandi_sorgu->fetch_assoc();
                                            $uretim_bandi_sayisi = max(1, intval($uretim_bandi_row['sayi']));
                                        }
                                    }
                                    $kalan_hafta = ($row["adet"] > 0 && $uretim_bandi_sayisi > 0)
                                        ? round($row["stok"] / ($row["adet"] * $uretim_bandi_sayisi), 1)
                                        : '-';

                                    if (is_numeric($kalan_hafta) && $kalan_hafta < 4) {
                                        $kritik_var = true;
                                        echo "<tr>";
                                        echo "<td><input type='text' class='form-control-plaintext' readonly value='" . htmlspecialchars($row["ad"]) . "'></td>";
                                        echo "<td><input type='text' class='form-control-plaintext' readonly value='" . htmlspecialchars($row["aciklama"]) . "'></td>";
                                        echo "<td><input type='text' class='form-control-plaintext' readonly value='" . $row["stok"] . "'></td>";
                                        echo "<td><input type='text' class='form-control-plaintext' readonly value='" . birimText($row["birim"]) . "'></td>";
                                        echo "<td class='fw-bold text-danger'><input type='text' class='form-control-plaintext fw-bold text-danger' readonly value='" . $kalan_hafta . "'></td>";
                                        echo "<td><input type='text' class='form-control-plaintext' readonly value='" . $row["fiyat"] . "'></td>";
                                        echo "<td><a href='islem_olustur.php?giren_id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Sipariş Ver</a></td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            if (!$kritik_var) {
                                echo "<tr><td colspan='7' class='text-center text-success'>Kritik stokta ürün yok.</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>