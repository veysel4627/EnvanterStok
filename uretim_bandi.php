<?php
include('header.php');
include('db.php');

// Üretim tablosundaki tüm verileri al
$uretim_query = "SELECT u.id AS uretim_id, u.cikan_id, u.birim, u.fiyat, u.uretim, c.ad AS cikan_urun_adi, c.stok, c.birim AS cikan_birim
                 FROM uretim u
                 JOIN cikan c ON u.cikan_id = c.id";
$uretim_result = mysqli_query($conn, $uretim_query);

function birimText($birim) {
    switch($birim) {
        case 0: return "m²";
        case 1: return "Kilo";
        case 2: return "Koli";
        case 3: return "m³";
        default: return "-";
    }
}
?>

<main role="main" class="main-content">
    <div class="container py-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2 mb-0">Üretim Bantları</h1>
            <a href="uretim_olustur.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Yeni Üretim Bandı Oluştur
            </a>
        </div>
        <div class="row g-4">
            <?php if ($uretim_result && mysqli_num_rows($uretim_result) > 0): ?>
                <?php while ($uretim = mysqli_fetch_assoc($uretim_result)): ?>
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <form action="uretim_bandi_guncelle.php" method="POST" class="card shadow-sm h-100 border-0 p-2">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-3 text-primary text-center fw-bold">
                                    <?= htmlspecialchars($uretim['cikan_urun_adi']) ?>
                                </h5>
                                <div class="mb-2">
                                    <label class="form-label mb-1">Fiyat</label>
                                    <input type="number" name="fiyat" value="<?= $uretim['fiyat'] ?>" class="form-control form-control-sm" min="0" step="0.01" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label mb-1">Stok</label>
                                    <input type="number" name="stok" value="<?= $uretim['stok'] ?>" class="form-control form-control-sm" min="0" readonly>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label mb-1">Birim</label>
                                    <select name="birim" class="form-control form-control-sm" required>
                                        <option value="0" <?= $uretim["birim"]==0 ? "selected" : "" ?>>m²</option>
                                        <option value="1" <?= $uretim["birim"]==1 ? "selected" : "" ?>>Kilo</option>
                                        <option value="2" <?= $uretim["birim"]==2 ? "selected" : "" ?>>Koli</option>
                                        <option value="3" <?= $uretim["birim"]==3 ? "selected" : "" ?>>m³</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label mb-1">Haftalık Üretim (Adet)</label>
                                    <input type="number" name="uretim" value="<?= $uretim['uretim'] ?>" class="form-control form-control-sm" min="0" required>
                                </div>
                                <input type="hidden" name="id" value="<?= $uretim['uretim_id'] ?>">
                                <div class="mt-auto d-flex gap-2">
                                    <a href="uretim_duzenle.php?id=<?= $uretim['uretim_id'] ?>" class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="bi bi-pencil"></i> İncele
                                    </a>
                                    <button type="submit" class="btn btn-success btn-sm flex-fill">
                                        <i class="bi bi-check-circle"></i> Güncelle
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">Kayıt bulunamadı</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>