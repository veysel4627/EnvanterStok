<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['durum'])) {
    $islem_id = intval($_POST['id']);
    $yeni_durum = intval($_POST['durum']);

    // İşlem bilgilerini çek
    $islem_sorgu = $conn->query("SELECT * FROM islem WHERE id = $islem_id");
    if ($islem_sorgu && $islem_sorgu->num_rows > 0) {
        $islem = $islem_sorgu->fetch_assoc();

        // Sadece tamamlanmaya çekiliyorsa stok işlemi yap (ve sadece ilk kez tamamlanıyorsa)
        if ($islem['durum'] == 0 && $yeni_durum == 1) {
            $giren_id = intval($islem['giren_id']);
            $miktar = floatval($islem['miktar']);

            // Satılma ise stoktan düş
            if ($islem['islem_turu'] == 1) {
                $stok_sorgu = $conn->query("SELECT stok FROM giren WHERE id = $giren_id");
                if ($stok_sorgu && $stok_sorgu->num_rows > 0) {
                    $stok_row = $stok_sorgu->fetch_assoc();
                    $yeni_stok = $stok_row['stok'] - $miktar;
                    if ($yeni_stok < 0) {
                        header("Location: islemler.php?error=stok_negatif");
                        exit;
                    }
                    $conn->query("UPDATE giren SET stok = $yeni_stok WHERE id = $giren_id");
                }
            }
            // Satın alma ise stoğa ekle
            else if ($islem['islem_turu'] == 0) {
                $conn->query("UPDATE giren SET stok = stok + $miktar WHERE id = $giren_id");
            }
            // Taşıma ise stoğa dokunma
        }

        // Durumu güncelle (her durumda)
        if ($conn->query("UPDATE islem SET durum = $yeni_durum WHERE id = $islem_id")) {
            header("Location: islemler.php?success=1");
            exit;
        } else {
            header("Location: islemler.php?error=durum_guncelenemedi");
            exit;
        }
    } else {
        header("Location: islemler.php?error=islem_bulunamadi");
        exit;
    }
} else {
    header("Location: islemler.php?error=bilinmeyen");
    exit;
}
?>
