<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Yeni Ürün Ekle</h1>
    </div>
    <form action="yeni_urun_ekle_islem.php" method="POST">
        <div class="form-group">
            <label for="ad">Ürün Adı</label>
            <input type="text" class="form-control" id="ad" name="ad" required>
        </div>
        <div class="form-group">
            <label for="aciklama">Açıklama</label>
            <textarea class="form-control" id="aciklama" name="aciklama" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="adet">Adet</label>
            <input type="number" class="form-control" id="adet" name="adet" required>
        </div>
        <div class="form-group">
            <label for="fiyat">Fiyat</label>
            <input type="text" class="form-control" id="fiyat" name="fiyat" required>
        </div>
        <div class="form-group">
            <label for="cikan_id">Çıkan Ürün</label>
            <select class="form-control" id="cikan_id" name="cikan_id" required>
                <option value="">Seçiniz...</option>
                <?php
                include('db.php');
                // Çıkan ürünlerin listesini almak için SQL sorgusu
                $sql = "SELECT id, ad FROM cikan";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id"] . "'>" . $row["ad"] . "</option>";
                    }
                }
                $conn->close();
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ekle</button>
    </form>
</main>

