<?php
include('header.php');
include('db.php');

// Düzenlenecek üretim bandının ID'sini al
$uretim_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Üretim bandı bilgilerini al
$uretim_query = "SELECT * FROM uretim WHERE id = $uretim_id";
$uretim_result = mysqli_query($conn, $uretim_query);
$uretim = mysqli_fetch_assoc($uretim_result);

// Eğer geçerli bir üretim bandı yoksa hata mesajı göster
if (!$uretim) {
    echo "<div class='alert alert-danger'>Geçersiz Üretim Bandı!</div>";
    exit;
}

// Çıkış ürünlerini al
$cikan_query = "SELECT id, ad FROM cikan";
$cikan_result = mysqli_query($conn, $cikan_query);

// Giriş ürünlerini al (cikan_id NULL olanlar veya bu üretim bandına bağlı olanlar)
$giren_query = "SELECT id, ad, cikan_id FROM giren WHERE cikan_id IS NULL OR cikan_id = {$uretim['cikan_id']}";
$giren_result = mysqli_query($conn, $giren_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cikan_id = intval($_POST['cikan_id']);
    $birim = $_POST['birim'];
    $fiyat = floatval($_POST['fiyat']);
    $giren_ids = isset($_POST['giren_ids']) ? $_POST['giren_ids'] : [];

    // Üretim tablosunu güncelle
    $update_uretim_query = "UPDATE uretim SET cikan_id = $cikan_id, birim = '$birim', fiyat = $fiyat WHERE id = $uretim_id";
    if (mysqli_query($conn, $update_uretim_query)) {
        // Giriş ürünlerini güncelle
        foreach ($giren_ids as $giren_id) {
            $giren_id = intval($giren_id);
            $update_giren_query = "UPDATE giren SET cikan_id = $cikan_id WHERE id = $giren_id";
            mysqli_query($conn, $update_giren_query);
        }

        echo "<div class='alert alert-success'>Üretim bandı başarıyla güncellendi!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata: " . mysqli_error($conn) . "</div>";
    }
}
?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Üretim Bandını Düzenle</h1>
    </div>
    <form method="POST" action="">
        <div class="form-group">
            <label for="cikan_id">Çıkış Ürünü</label>
            <select name="cikan_id" id="cikan_id" class="form-control" required>
                <?php while ($cikan = mysqli_fetch_assoc($cikan_result)): ?>
                    <option value="<?php echo $cikan['id']; ?>" <?php echo ($cikan['id'] == $uretim['cikan_id']) ? 'selected' : ''; ?>>
                        <?php echo $cikan['ad']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="birim">Birim</label>
            <input type="text" name="birim" id="birim" class="form-control" value="<?php echo $uretim['birim']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fiyat">Fiyat</label>
            <input type="number" step="0.01" name="fiyat" id="fiyat" class="form-control" value="<?php echo $uretim['fiyat']; ?>" required>
        </div>
        <div class="form-group">
            <label>Giriş Ürünleri</label>
            <?php while ($giren = mysqli_fetch_assoc($giren_result)): ?>
                <div class="form-check">
                    <input type="checkbox" name="giren_ids[]" value="<?php echo $giren['id']; ?>" class="form-check-input"
                        <?php echo ($giren['cikan_id'] == $uretim['cikan_id']) ? 'checked' : ''; ?>>
                    <label class="form-check-label"><?php echo $giren['ad']; ?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
</main>