<?php
include('header.php');
include('db.php');

// giren_id parametresini al
$giren_id = isset($_GET['giren_id']) ? intval($_GET['giren_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $giren_id = intval($_POST['giren_id']);
    $islem_turu = intval($_POST['islem_turu']); // İşlem türü int olarak alınır (0 veya 1)
    $miktar = intval($_POST['miktar']);
    $kullanici_id = 1; // Örnek kullanıcı ID'si, oturumdan alınabilir

    // İşlem ekleme sorgusu
    $query = "INSERT INTO islem (giren_id, islem_turu, miktar, islem_tarihi, kullanici_id, durum) 
              VALUES ($giren_id, $islem_turu, $miktar, NOW(), $kullanici_id, 0)";
    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>İşlem başarıyla oluşturuldu!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hata: " . mysqli_error($conn) . "</div>";
    }
}
?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Yeni İşlem Oluştur</h1>
    </div>
    <form method="POST" action="">
        <div class="form-group">
            <label for="giren_id">Ürün</label>
            <select name="giren_id" id="giren_id" class="form-control" required>
                <?php
                // Ürünleri listele
                $query = "SELECT id, ad FROM giren";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['id'] == $giren_id) ? 'selected' : '';
                    echo "<option value='{$row['id']}' $selected>{$row['ad']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="islem_turu">İşlem Türü</label>
            <select name="islem_turu" id="islem_turu" class="form-control" required>
                <option value="0" <?php echo (isset($islem_turu) && $islem_turu == 0) ? 'selected' : ''; ?>>Satın Alma</option>
                <option value="1" <?php echo (isset($islem_turu) && $islem_turu == 1) ? 'selected' : ''; ?>>Satılma</option>
            </select>
        </div>
        <div class="form-group">
            <label for="miktar">Miktar</label>
            <input type="number" name="miktar" id="miktar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Oluştur</button>
    </form>
</main>