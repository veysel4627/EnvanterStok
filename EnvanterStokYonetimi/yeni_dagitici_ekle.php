<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 mb-0 text-center w-100">Yeni Dağıtıcı Ekle</h1>
    </div>
    <form action="yeni_dagitici_ekle_islem.php" method="POST" class="card shadow-sm p-4" style="max-width:600px;margin:auto;">
        <div class="form-group mb-3">
            <label for="ad">Dağıtıcı Adı</label>
            <input type="text" class="form-control" id="ad" name="ad" placeholder="Dağıtıcı adını yazınız..." required>
        </div>
        <div class="form-group mb-3">
            <label for="aciklama">Açıklama</label>
            <textarea class="form-control" id="aciklama" name="aciklama" rows="3" placeholder="Açıklama..." required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="iletisim">İletişim</label>
            <input type="text" class="form-control" id="iletisim" name="iletisim" placeholder="İletişim bilgisi..." required>
        </div>
        <div class="form-group mb-3">
            <label for="adres">Adres</label>
            <textarea class="form-control" id="adres" name="adres" rows="2" placeholder="Adres..." required></textarea>
        </div>
        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">Ekle</button>
        </div>
    </form>
</main>