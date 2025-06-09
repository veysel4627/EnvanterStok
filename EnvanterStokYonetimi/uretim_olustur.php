<?php
include('header.php');
include('db.php');

// Çıkış ürünlerini al
$cikan_query = "SELECT id, ad, birim FROM cikan";
$cikan_result = mysqli_query($conn, $cikan_query);

// Giriş ürünlerini al (cikan_id NULL olanlar)
$giren_query = "SELECT id, ad FROM giren WHERE cikan_id IS NULL";
$giren_result = mysqli_query($conn, $giren_query);

function birimText($birim) {
    switch($birim) {
        case 0: return "m²";
        case 1: return "Kilo";
        case 2: return "Koli";
        case 3: return "m³";
        default: return "-";
    }
}

$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cikan_id = intval($_POST['cikan_id']);
    $birim = intval($_POST['birim']);
    $fiyat = floatval($_POST['fiyat']);
    $uretim = intval($_POST['uretim']);
    $giren_ids = isset($_POST['giren_ids']) ? $_POST['giren_ids'] : [];

    // Üretim tablosuna ekle
    $uretim_query = "INSERT INTO uretim (cikan_id, birim, fiyat, uretim) VALUES ($cikan_id, $birim, $fiyat, $uretim)";
    if (mysqli_query($conn, $uretim_query)) {
        $uretim_id = mysqli_insert_id($conn);

        // Giriş ürünlerini üretim bandına bağla
        foreach ($giren_ids as $giren_id) {
            $giren_id = intval($giren_id);
            $update_giren_query = "UPDATE giren SET cikan_id = $cikan_id WHERE id = $giren_id";
            mysqli_query($conn, $update_giren_query);
        }

        $success = "Üretim bandı başarıyla oluşturuldu!";
    } else {
        $error = "Hata: " . mysqli_error($conn);
    }
}
?>

<main role="main" class="main-content">
    <div class="container py-4">
        <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 mb-0 text-center w-100">Yeni Üretim Bandı Oluştur</h1>
        </div>
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="" class="card shadow-sm p-4" style="max-width:600px;margin:auto;">
            <div class="form-group mb-3">
                <label for="cikan_id">Çıkış Ürünü</label>
                <select name="cikan_id" id="cikan_id" class="form-control" required onchange="setBirimFromSelected()">
                    <option value="">Seçiniz...</option>
                    <?php
                    $cikan_result2 = mysqli_query($conn, "SELECT id, ad, birim FROM cikan");
                    while ($cikan = mysqli_fetch_assoc($cikan_result2)): ?>
                        <option value="<?= $cikan['id'] ?>" data-birim="<?= $cikan['birim'] ?>">
                            <?= htmlspecialchars($cikan['ad']) ?> (<?= birimText($cikan['birim']) ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="birim">Birim</label>
                <input type="text" name="birim_text" id="birim_text" class="form-control" value="-" readonly>
                <input type="hidden" name="birim" id="birim" value="">
            </div>
            <div class="form-group mb-3">
                <label for="fiyat">Fiyat</label>
                <input type="number" step="0.01" name="fiyat" id="fiyat" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="uretim">Haftalık Üretim (Adet)</label>
                <input type="number" name="uretim" id="uretim" class="form-control" min="0" required>
            </div>
            <div class="form-group mb-3">
                <label>Giriş Ürünleri</label>
                <div class="row">
                    <?php
                    $giren_result2 = mysqli_query($conn, "SELECT id, ad FROM giren WHERE cikan_id IS NULL");
                    if (mysqli_num_rows($giren_result2) > 0):
                        while ($giren = mysqli_fetch_assoc($giren_result2)): ?>
                            <div class="col-12 col-md-6">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="giren_ids[]" value="<?= $giren['id'] ?>" class="form-check-input" id="giren<?= $giren['id'] ?>">
                                    <label class="form-check-label" for="giren<?= $giren['id'] ?>"><?= htmlspecialchars($giren['ad']) ?></label>
                                </div>
                            </div>
                        <?php endwhile;
                    else: ?>
                        <div class="col-12 text-muted">Eklenebilecek giriş ürünü yok.</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Oluştur</button>
            </div>
        </form>
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