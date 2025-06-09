<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="container-fluid px-4">
        <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-4 border-bottom">
            <h1 class="h2 mb-0">Tedarikçiler</h1>
            <a href="tedarikci_ekle.php" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle"></i> Yeni Tedarikçi Ekle
            </a>
        </div>
        <div class="row g-4">
            <?php
            include('db.php');
            $sql = "SELECT * FROM tedarikci";
            $result = $conn->query($sql);

            if ($result === FALSE) {
                echo "<div class='col-12'><div class='alert alert-danger'>SQL hatası: " . $conn->error . "</div></div>";
            } else {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                            <form action="tedarikci_guncelle.php" method="POST" class="card shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">
                                        <input type="text" name="ad" value="<?= htmlspecialchars($row["ad"]) ?>" class="form-control form-control-sm mb-2" required>
                                    </h5>
                                    <div class="mb-2">
                                        <textarea name="aciklama" class="form-control form-control-sm" rows="2" required><?= htmlspecialchars($row["aciklama"]) ?></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label mb-1">İletişim</label>
                                        <input type="text" name="iletisim" value="<?= htmlspecialchars($row["iletisim"]) ?>" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label mb-1">Adres</label>
                                        <textarea name="adres" class="form-control form-control-sm" rows="2" required><?= htmlspecialchars($row["adres"]) ?></textarea>
                                    </div>
                                    <div class="mb-2 small text-muted">
                                        <span>Eklenme: <?= $row["eklenme"] ? date('d.m.Y H:i', strtotime($row["eklenme"])) : "-" ?></span><br>
                                        <span>Güncelleme: <?= $row["guncelleme"] ? date('d.m.Y H:i', strtotime($row["guncelleme"])) : "-" ?></span>
                                    </div>
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <div class="mt-auto d-flex">
                                        <button type="submit" class="btn btn-primary btn-sm flex-fill">Güncelle</button>
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
