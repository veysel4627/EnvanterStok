<?php include('header.php'); ?>

<main role="main" class="main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Çıkış ürünleri</h1>
        
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Ürün Adı</th>
                    <th>Açıklama</th>
                    <th>Stok miktarı</th>
                    <th>Birimi</th>
                    <th>Eklenme Tarihi</th>
                    <th>Güncellenme Tarihi</th>


                </tr>
            </thead>
            <tbody>
                <?php
                include('db.php');

                // Çıkış ürünlerini sorgula
                $query = "SELECT * FROM cikan";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $urun_id = $row['id'];
                    $stok_miktari = $row['stok_miktari']; // Çıkış ürünlerinin stok miktarı

                    echo "<tr>
                        <td>{$row['ad']}</td>
                        <td>{$row['aciklama']}</td>
                        <td>{$row['stok']}</td>
                        <td>{$row['birim']}</td>
                        <td>{$row['eklenme']}</td>
                        <td>{$row['guncellenme']}</td>
                        
                        <td><a href='urun_detay.php?id={$urun_id}' class='btn btn-info btn-sm'>Bu Ürüne Git</a></td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
