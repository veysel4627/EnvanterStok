<?php
include('header.php');
$cikan_id = isset($_GET['cikan_id']) ? intval($_GET['cikan_id']) : null;
?>
<main role="main" class="main-content">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
            <h1 class="h2 mb-0">Giren Ürünler</h1>
            <a href="yeni_urun_ekle.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Yeni Ürün Ekle
            </a>
        </div>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ürün Adı</th>
                                <th>Açıklama</th>
                                <th>Stok</th>
                                <th>Birim</th>
                                <th>Kalan Hafta</th>
                                <th>Fiyat</th>
                                <th>Çıkan Ürün</th>
                                <th>Tedarikçi</th>
                                <th>Eklenme Tarihi</th>
                                <th>Güncellenme Tarihi</th>
                                <th>Güncelle</th>
                                <th>Sipariş Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('db.php');
                            $where = "";
                            if ($cikan_id) {
                                $where = "WHERE giren.cikan_id = $cikan_id";
                            }
                            $sql = "SELECT giren.id, giren.ad, giren.aciklama, giren.stok, giren.adet, giren.birim, giren.fiyat, giren.cikan_id,
                                           cikan.ad AS cikan_urun, 
                                           tedarikci.ad AS tedarikci_ad, giren.eklenme, giren.guncelleme 
                                    FROM giren 
                                    LEFT JOIN cikan ON giren.cikan_id = cikan.id
                                    LEFT JOIN tedarikci ON giren.tedarikci_id = tedarikci.id
                                    $where";
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

                            if ($result === FALSE) {
                                echo "<tr><td colspan='11' class='text-danger'>SQL hatası: " . $conn->error . "</td></tr>";
                            } elseif ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Kalan hafta = stok / (adet * aynı çıkış ürününe bağlı üretim bandı sayısı)
                                    $uretim_bandi_sayisi = 1;
                                    if ($row["cikan_id"] ?? null) {
                                        $uretim_bandi_sorgu = $conn->query("SELECT COUNT(*) as sayi FROM uretim WHERE cikan_id = " . intval($row["cikan_id"]));
                                        if ($uretim_bandi_sorgu) {
                                            $uretim_bandi_row = $uretim_bandi_sorgu->fetch_assoc();
                                            $uretim_bandi_sayisi = max(1, intval($uretim_bandi_row['sayi']));
                                        }
                                    }
                                    $kalan_hafta = ($row["adet"] > 0 && $uretim_bandi_sayisi > 0)
                                        ? round($row["stok"] / ($row["adet"] * $uretim_bandi_sayisi), 1)
                                        : '-';

                                    $kalan_hafta_goster = $kalan_hafta;
                                    $kalan_hafta_class = "";
                                    if (is_numeric($kalan_hafta) && $kalan_hafta <= 4) {
                                        $kalan_hafta_class = "fw-bold text-danger";
                                    } elseif (is_numeric($kalan_hafta)) {
                                        $kalan_hafta_class = "fw-bold text-success";
                                    }

                                    echo "<tr>";
                                    echo "<form action='giren_urunler_guncelle.php' method='POST' class='d-flex'>";
                                    echo "<td><input type='text' name='ad' value='" . htmlspecialchars($row["ad"]) . "' class='form-control form-control-sm'></td>";
                                    echo "<td><input type='text' name='aciklama' value='" . htmlspecialchars($row["aciklama"]) . "' class='form-control form-control-sm'></td>";
                                    echo "<td><input type='number' name='stok' value='" . $row["stok"] . "' class='form-control form-control-sm' min='0'></td>";
                                    echo "<td>
                                        <select name='birim' class='form-control form-control-sm'>
                                            <option value='0' ".($row["birim"]==0?"selected":"").">m²</option>
                                            <option value='1' ".($row["birim"]==1?"selected":"").">Kilo</option>
                                            <option value='2' ".($row["birim"]==2?"selected":"").">Koli</option>
                                            <option value='3' ".($row["birim"]==3?"selected":"").">m³</option>
                                        </select>
                                    </td>";
                                    echo "<td class='$kalan_hafta_class'>" . $kalan_hafta_goster . "</td>";
                                    echo "<td><input type='text' name='fiyat' value='" . $row["fiyat"] . "' class='form-control form-control-sm'></td>";
                                    echo "<td class='text-nowrap'>" . ($row["cikan_urun"] ? htmlspecialchars($row["cikan_urun"]) : "<span class='text-muted'>-</span>") . "</td>";
                                    echo "<td class='text-nowrap'>" . ($row["tedarikci_ad"] ? htmlspecialchars($row["tedarikci_ad"]) : "<span class='text-muted'>-</span>") . "</td>";
                                    echo "<td class='text-nowrap small'>" . ($row["eklenme"] ? date('d.m.Y H:i', strtotime($row["eklenme"])) : "-") . "</td>";
                                    echo "<td class='text-nowrap small'>" . ($row["guncelleme"] ? date('d.m.Y H:i', strtotime($row["guncelleme"])) : "-") . "</td>";
                                    echo "<td>";
                                    echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                                    echo "<button type='submit' class='btn btn-primary btn-sm px-3'>Güncelle</button>";
                                    echo "</td>";
                                    echo "</form>";
                                    // SİPARİŞ VER BUTONU
                                    echo "<td><a href='islem_olustur.php?giren_id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Sipariş Ver</a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='11' class='text-center text-muted'>Kayıt bulunamadı</td></tr>";
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
