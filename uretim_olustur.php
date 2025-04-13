<?php
include('header.php');
include('db.php');

// Çıkış ürünlerini al
$cikan_query = "SELECT id, ad FROM cikan";
$cikan_result = mysqli_query($conn, $cikan_query);

// Giriş ürünlerini al (cikan_id NULL olanlar)
$giren_query = "SELECT id, ad FROM giren WHERE cikan_id IS NULL";
$giren_result = mysqli_query($conn, $giren_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cikan_id = intval($_POST['cikan_id']);
    $birim = $_POST['birim'];
    $fiyat = floatval($_POST['fiyat']);
    $giren_ids = isset($_POST['giren_ids']) ? $_POST['giren_ids'] : [];

    // Üretim tablosuna ekle
    $uretim_query = "INSERT INTO uretim (cikan_id, birim, fiyat) VALUES ($cikan_id, '$birim', $fiyat)";
    if (mysqli_query($conn, $uretim_query)) {
        $uretim_id = mysqli_insert_id($conn);

        // Giriş ürünlerini üretim bandına bağla
        foreach ($giren_ids as $giren_id) {
            $giren_id = intval($giren_id);
            $update_giren_query = "UPDATE giren SET cikan_id = $cikan_id WHERE id = $giren_id";
            mysqli_query($conn, $update_giren_query);
        }

        echo "<div class='alert alert-success'>Üretim bandı başarıyla oluşturuldu!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata: " . mysqli_error($conn) . "</div>";
    }
}
?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Yeni Üretim Bandı Oluştur</h1>
    </div>
    <form method="POST" action="">
        <div class="form-group">
            <label for="cikan_id">Çıkış Ürünü</label>
            <select name="cikan_id" id="cikan_id" class="form-control" required>
                <?php while ($cikan = mysqli_fetch_assoc($cikan_result)): ?>
                    <option value="<?php echo $cikan['id']; ?>"><?php echo $cikan['ad']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="birim">Birim</label>
            <input type="text" name="birim" id="birim" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fiyat">Fiyat</label>
            <input type="number" step="0.01" name="fiyat" id="fiyat" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Giriş Ürünleri</label>
            <?php while ($giren = mysqli_fetch_assoc($giren_result)): ?>
                <div class="form-check">
                    <input type="checkbox" name="giren_ids[]" value="<?php echo $giren['id']; ?>" class="form-check-input">
                    <label class="form-check-label"><?php echo $giren['ad']; ?></label>
                </div>
            <?php endwhile; ?>
        </div>
        <button type="submit" class="btn btn-primary">Oluştur</button>
    </form>
</main>