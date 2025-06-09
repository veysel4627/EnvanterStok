<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
            <h1 class="h2 mb-0">Çıkan Ürünler</h1>
            <a href="yeni_cikan_urun_ekle.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle"></i> Yeni Çıkan Ürün Ekle
            </a>
        </div>
        <div class="row g-4">
            <?php
            include('db.php');
            $sql = "SELECT * FROM cikan";
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
                echo "<div class='col-12'><div class='alert alert-danger'>SQL hatası: " . $conn->error . "</div></div>";
            } else {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                            <form action="cikan_urunler_guncelle.php" method="POST" class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">
                                        <input type="text" name="ad" value="<?= htmlspecialchars($row["ad"]) ?>" class="form-control form-control-sm mb-2" required>
                                    </h5>
                                    <div class="mb-2">
                                        <textarea name="aciklama" class="form-control form-control-sm" rows="2" required><?= htmlspecialchars($row["aciklama"]) ?></textarea>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <label class="form-label mb-1">Stok</label>
                                            <input type="number" name="stok" value="<?= $row["stok"] ?>" class="form-control form-control-sm" min="0" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label mb-1">Birim</label>
                                            <select name="birim" class="form-control form-control-sm" required>
                                                <option value="0" <?= $row["birim"]==0 ? "selected" : "" ?>>m²</option>
                                                <option value="1" <?= $row["birim"]==1 ? "selected" : "" ?>>Kilo</option>
                                                <option value="2" <?= $row["birim"]==2 ? "selected" : "" ?>>Koli</option>
                                                <option value="3" <?= $row["birim"]==3 ? "selected" : "" ?>>m³</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2 small text-muted">
                                        <span>Eklenme: <?= $row["eklenme"] ? date('d.m.Y H:i', strtotime($row["eklenme"])) : "-" ?></span><br>
                                        <span>Güncelleme: <?= $row["guncelleme"] ? date('d.m.Y H:i', strtotime($row["guncelleme"])) : "-" ?></span>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <div class="mt-auto d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill">Güncelle</button>
                                        <a href="giren_urunler.php?cikan_id=<?= $row["id"] ?>" class="btn btn-outline-secondary btn-sm flex-fill">Alt Ürünler</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                } else {
                    echo "<div class='col-12'><div class='alert alert-info text-center'>Kayıt bulunamadı</div></div>";
                }
            }
            $conn->close();
            ?>
        </div>
    </div>
</main>