<?php
include('header.php');
include('db.php');

// Üretim bandı ID'si
$uretim_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Üretim bandı bilgisi
$uretim_query = "SELECT * FROM uretim WHERE id = $uretim_id";
$uretim_result = mysqli_query($conn, $uretim_query);
$uretim = mysqli_fetch_assoc($uretim_result);

function birimText($birim) {
    switch($birim) {
        case 0: return "m²";
        case 1: return "Kilo";
        case 2: return "Koli";
        case 3: return "m³";
        default: return "-";
    }
}

// Çıkış ürünleri
$cikan_query = "SELECT id, ad, birim FROM cikan";
$cikan_result = mysqli_query($conn, $cikan_query);

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uretim_guncelle'])) {
    $cikan_id = intval($_POST['cikan_id']);
    $birim = intval($_POST['birim']);
    $fiyat = floatval($_POST['fiyat']);
    $uretim_adet = intval($_POST['uretim']);
    $update_uretim_query = "UPDATE uretim SET cikan_id = $cikan_id, birim = $birim, fiyat = $fiyat, uretim = $uretim_adet WHERE id = $uretim_id";
    if (mysqli_query($conn, $update_uretim_query)) {
        echo "<div class='alert alert-success'>Üretim bandı başarıyla güncellendi!</div>";
        // Güncel veriyi tekrar çek
        $uretim_result = mysqli_query($conn, $uretim_query);
        $uretim = mysqli_fetch_assoc($uretim_result);
    } else {
        echo "<div class='alert alert-danger'>Hata: " . mysqli_error($conn) . "</div>";
    }
}

// Çıkış ürünü ile ilişkili giren ürünler
$giren_query = "SELECT * FROM giren WHERE cikan_id = {$uretim['cikan_id']}";
$giren_result = mysqli_query($conn, $giren_query);

// Giren ürün güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['giren_guncelle'])) {
    $giren_id = intval($_POST['giren_id']);
    $ad = $conn->real_escape_string($_POST['ad']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    $stok = intval($_POST['stok']);
    $adet = intval($_POST['adet']);
    $birim = intval($_POST['birim']);
    $fiyat = floatval($_POST['fiyat']);
    $update_giren_query = "UPDATE giren SET ad = '$ad', aciklama = '$aciklama', stok = $stok, adet = $adet, birim = $birim, fiyat = $fiyat WHERE id = $giren_id";
    if ($conn->query($update_giren_query) === TRUE) {
        echo "<div class='alert alert-success'>Giren ürün başarıyla güncellendi!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata: " . $conn->error . "</div>";
    }
    // Güncel veriyi tekrar çek
    $giren_result = mysqli_query($conn, $giren_query);
}
?>

<main role="main" class="main-content">
    <div class="container py-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 mb-0">Üretim Bandını Düzenle</h1>
        </div>
        <!-- Üretim Bandı Güncelleme Formu (YATAY) -->
        <form method="POST" class="card shadow-sm p-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label for="cikan_id" class="form-label">Çıkış Ürünü</label>
                    <select name="cikan_id" id="cikan_id" class="form-control" required onchange="setBirimFromSelected()">
                        <?php
                        mysqli_data_seek($cikan_result, 0);
                        while ($cikan = mysqli_fetch_assoc($cikan_result)): ?>
                            <option value="<?= $cikan['id'] ?>" data-birim="<?= $cikan['birim'] ?>" <?= ($cikan['id'] == $uretim['cikan_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cikan['ad']) ?> (<?= birimText($cikan['birim']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-12 col-md-2">
                    <label for="birim" class="form-label">Birim</label>
                    <input type="text" name="birim_text" id="birim_text" class="form-control" value="<?= birimText($uretim['birim']) ?>" readonly>
                    <input type="hidden" name="birim" id="birim" value="<?= $uretim['birim'] ?>">
                </div>
                <div class="col-12 col-md-2">
                    <label for="fiyat" class="form-label">Fiyat</label>
                    <input type="number" step="0.01" name="fiyat" id="fiyat" class="form-control" value="<?= $uretim['fiyat'] ?>" required>
                </div>
                <div class="col-12 col-md-3">
                    <label for="uretim" class="form-label">Haftalık Üretim (Adet)</label>
                    <input type="number" name="uretim" id="uretim" class="form-control" min="0" value="<?= $uretim['uretim'] ?>" required>
                </div>
                <div class="col-12 col-md-2 text-end">
                    <button type="submit" name="uretim_guncelle" class="btn btn-primary px-4 mt-3 w-100">Güncelle</button>
                </div>
            </div>
        </form>

        <!-- Giren Ürünler Tablosu -->
        <div class="card shadow-sm p-4 mt-4">
            <h5 class="mb-3 text-primary fw-bold">Bağlı Giren Ürünler</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Adı</th>
                            <th>Açıklama</th>
                            <th>Stok</th>
                            <th>Birim</th>
                            <th>Adet</th>
                            <th>Kalan Hafta</th>
                            <th>Fiyat</th>
                            <th>Güncelle</th>
                            <th>Sipariş Ver</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Üretim bandı ile aynı çıkış ürününe sahip kaç üretim bandı var?
                        $uretim_bandi_sayisi = 1;
                        $uretim_bandi_sorgu = mysqli_query($conn, "SELECT COUNT(*) as sayi FROM uretim WHERE cikan_id = {$uretim['cikan_id']}");
                        if ($uretim_bandi_sorgu) {
                            $row = mysqli_fetch_assoc($uretim_bandi_sorgu);
                            $uretim_bandi_sayisi = max(1, intval($row['sayi']));
                        }

                        if ($giren_result && mysqli_num_rows($giren_result) > 0):
                            while ($giren = mysqli_fetch_assoc($giren_result)):
                                $kalan_hafta = ($giren['adet'] > 0 && $uretim_bandi_sayisi > 0)
                                    ? round($giren['stok'] / ($giren['adet'] * $uretim_bandi_sayisi), 1)
                                    : '-';
                                $kalan_hafta_class = (is_numeric($kalan_hafta) && $kalan_hafta < 4) ? "fw-bold text-danger" : "fw-bold text-success";
                        ?>
                        <tr>
                            <form method="POST" class="d-flex">
                                <td>
                                    <input type="text" name="ad" value="<?= htmlspecialchars($giren['ad']) ?>" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input type="text" name="aciklama" value="<?= htmlspecialchars($giren['aciklama']) ?>" class="form-control form-control-sm">
                                </td>
                                <td>
                                    <input type="number" name="stok" value="<?= $giren['stok'] ?>" class="form-control form-control-sm" min="0">
                                </td>
                                <td>
                                    <select name="birim" class="form-control form-control-sm">
                                        <option value="0" <?= $giren["birim"]==0 ? "selected" : "" ?>>m²</option>
                                        <option value="1" <?= $giren["birim"]==1 ? "selected" : "" ?>>Kilo</option>
                                        <option value="2" <?= $giren["birim"]==2 ? "selected" : "" ?>>Koli</option>
                                        <option value="3" <?= $giren["birim"]==3 ? "selected" : "" ?>>m³</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="adet" value="<?= $giren['adet'] ?>" class="form-control form-control-sm" min="0">
                                </td>
                                <td class="<?= $kalan_hafta_class ?>">
                                    <?= $kalan_hafta ?>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="fiyat" value="<?= $giren['fiyat'] ?>" class="form-control form-control-sm" min="0">
                                </td>
                                <td>
                                    <input type="hidden" name="giren_id" value="<?= $giren['id'] ?>">
                                    <button type="submit" name="giren_guncelle" class="btn btn-success btn-sm">Güncelle</button>
                                </td>
                            </form>
                            <td>
                                <a href="islem_olustur.php?giren_id=<?= $giren['id'] ?>" class="btn btn-warning btn-sm">Sipariş Ver</a>
                            </td>
                        </tr>
                        <?php endwhile;
                        else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Bağlı giren ürün yok.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script>
function setBirimFromSelected() {
    var select = document.getElementById('cikan_id');
    var birimInput = document.getElementById('birim_text');
    var birimHidden = document.getElementById('birim');
    var selected = select.options[select.selectedIndex];
    var birim = selected.getAttribute('data-birim');
    var birimText = "-";
    switch (birim) {
        case "0": birimText = "m²"; break;
        case "1": birimText = "Kilo"; break;
        case "2": birimText = "Koli"; break;
        case "3": birimText = "m³"; break;
    }
    birimInput.value = birimText;
    birimHidden.value = birim;
}
</script>