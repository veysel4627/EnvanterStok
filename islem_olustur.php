<?php
include('header.php');
include('db.php');

// giren_id parametresini al
$giren_id = isset($_GET['giren_id']) ? intval($_GET['giren_id']) : 0;

function birimText($birim) {
    switch($birim) {
        case 0: return "m²";
        case 1: return "Kilo";
        case 2: return "Koli";
        case 3: return "m³";
        default: return "-";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $giren_id = intval($_POST['giren_id']);
    $islem_turu = intval($_POST['islem_turu']); // İşlem türü int olarak alınır (0, 1, 2)
    $miktar = intval($_POST['miktar']);
    $birim = intval($_POST['birim']); // Birim seçimi
    $dagitici_id = intval($_POST['dagitici_id']); // Dağıtıcı seçimi
    $kullanici_id = 1; // Örnek kullanıcı ID'si, oturumdan alınabilir

    // İşlem ekleme sorgusu
    $query = "INSERT INTO islem (giren_id, islem_turu, miktar, birim, dagitici_id, islem_tarihi, kullanici_id, durum) 
              VALUES ($giren_id, $islem_turu, $miktar, $birim, $dagitici_id, NOW(), $kullanici_id, 0)";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>İşlem başarıyla oluşturuldu!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata: " . mysqli_error($conn) . "</div>";
    }
}
?>

<main role="main" class="main-content">
    <div class="container py-4">
        <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 mb-0 text-center w-100">Yeni İşlem Oluştur</h1>
        </div>
        <form method="POST" action="" class="card shadow-sm p-4" style="max-width:600px;margin:auto;">
            <div class="form-group mb-3">
                <label for="giren_id">Ürün</label>
                <select name="giren_id" id="giren_id" class="form-control" required>
                    <?php
                    $query = "SELECT id, ad, birim FROM giren";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($row['id'] == $giren_id) ? 'selected' : '';
                        echo "<option value='{$row['id']}' data-birim='{$row['birim']}' $selected>{$row['ad']} (" . birimText($row['birim']) . ")</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="islem_turu">İşlem Türü</label>
                <select name="islem_turu" id="islem_turu" class="form-control" required>
                    <option value="0" <?php echo (isset($islem_turu) && $islem_turu == 0) ? 'selected' : ''; ?>>Satın Alma</option>
                    <option value="1" <?php echo (isset($islem_turu) && $islem_turu == 1) ? 'selected' : ''; ?>>Satılma</option>
                    <option value="2" <?php echo (isset($islem_turu) && $islem_turu == 2) ? 'selected' : ''; ?>>Taşıma</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="miktar">Miktar</label>
                <input type="number" name="miktar" id="miktar" class="form-control" min="1" required>
            </div>
            <div class="form-group mb-3">
                <label for="birim">Birim</label>
                <input type="text" id="birim_text" class="form-control" value="-" readonly>
                <input type="hidden" name="birim" id="birim" value="">
            </div>
            <div class="form-group mb-4">
                <label for="dagitici_id">Dağıtıcı</label>
                <select name="dagitici_id" id="dagitici_id" class="form-control" required>
                    <option value="">Seçiniz...</option>
                    <?php
                    $query = "SELECT id, ad FROM dagitici";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['ad']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Oluştur</button>
            </div>
        </form>
    </div>
</main>
<script>
document.getElementById('giren_id').addEventListener('change', function() {
    var selected = this.options[this.selectedIndex];
    var birim = selected.getAttribute('data-birim');
    var birimText = "-";
    switch (birim) {
        case "0": birimText = "m²"; break;
        case "1": birimText = "Kilo"; break;
        case "2": birimText = "Koli"; break;
        case "3": birimText = "m³"; break;
    }
    document.getElementById('birim_text').value = birimText;
    document.getElementById('birim').value = birim;
});
// Sayfa yüklenince ilk ürünün birimini göster
window.addEventListener('DOMContentLoaded', function() {
    var select = document.getElementById('giren_id');
    if (select) select.dispatchEvent(new Event('change'));
});
</script>