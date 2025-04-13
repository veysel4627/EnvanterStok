<?php
include('db.php');

// POST verilerini al
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $islem_id = intval($_POST['id']);
    $durum = intval($_POST['durum']); // Yeni durum (1: Tamamlandı, 0: Tamamlanmadı)

    // İşlem bilgilerini al
    $query = "SELECT islem.durum, islem.giren_id, islem.islem_turu, islem.miktar, giren.stok 
              FROM islem 
              JOIN giren ON islem.giren_id = giren.id 
              WHERE islem.id = $islem_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $mevcut_durum = $row['durum'];
        $giren_id = $row['giren_id'];
        $islem_turu = $row['islem_turu']; // 0: Satın Alma, 1: Satılma
        $miktar = $row['miktar'];
        $stok = $row['stok'];

        // Eğer işlem zaten tamamlandıysa güncellemeye izin verme
        if ($mevcut_durum == 1) {
            header("Location: islemler.php?error=islem_tamamlandi");
            exit;
        }

        // Eğer işlem tamamlandı olarak güncelleniyorsa stok güncellemesi yap
        if ($durum == 1) {
            if ($islem_turu == 0) {
                // Satın alma işlemi: Stok miktarını artır
                $yeni_stok = $stok + $miktar;
            } elseif ($islem_turu == 1) {
                // Satılma işlemi: Stok miktarını azalt
                $yeni_stok = $stok - $miktar;

                // Stok miktarı negatif olamaz
                if ($yeni_stok < 0) {
                    header("Location: islemler.php?error=stok_negatif");
                    exit;
                }
            }

            // Stok miktarını güncelle
            $update_stok_query = "UPDATE giren SET stok = $yeni_stok WHERE id = $giren_id";
            if (!mysqli_query($conn, $update_stok_query)) {
                header("Location: islemler.php?error=stok_guncellenemedi");
                exit;
            }
        }

        // İşlemin durumunu güncelle
        $update_durum_query = "UPDATE islem SET durum = $durum WHERE id = $islem_id";
        if (mysqli_query($conn, $update_durum_query)) {
            header("Location: islemler.php?success=1");
            exit;
        } else {
            header("Location: islemler.php?error=durum_guncellenemedi");
            exit;
        }
    } else {
        header("Location: islemler.php?error=islem_bulunamadi");
        exit;
    }
}
?>
