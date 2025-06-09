<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 mb-0 text-center w-100">Yeni Çıkan Ürün Ekle</h1>
    </div>
    <form action="yeni_cikan_urun_ekle_islem.php" method="POST" class="card shadow-sm p-4" style="max-width:600px;margin:auto;">
        <div class="form-group mb-3">
            <label for="ad">Ürün Adı</label>
            <input type="text" class="form-control" id="ad" name="ad" placeholder="Ürün adını yazınız..." value="" required>
        </div>
        <div class="form-group mb-3">
            <label for="aciklama">Açıklama</label>
            <textarea class="form-control" id="aciklama" name="aciklama" rows="3" placeholder="Ürünün açıklamasını giriniz..." required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="stok">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="0" min="0" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="birim">Birim</label>
                <select class="form-control" id="birim" name="birim" required>
                    <option value="0">m²</option>
                    <option value="1">Kilo</option>
                    <option value="2">Koli</option>
                    <option value="3">m³</option>
                </select>
            </div>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Ekle</button>
        </div>
    </form>
</main>