<?php include('db.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Envanter Yönetim</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light">Envanter Yönetim Sistemi</div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Ana Sayfa</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="cikan_urunler.php">Ürünler</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="uretim_bandi.php">Üretim</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="islemler.php">İşlemler</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="tedarikci.php">Tedarikçiler</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#!">Çalışanlar</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3" href="dagitici.php">Dağıtıcılar</a>
                    
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">

                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle">Menü</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link" href="#!">Anasayfa</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">Placeholder</a></li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kullanıcı</a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#!">Placeholder</a>
                                        <a class="dropdown-item" href="#!">Placeholder</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#!">Placeholder</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav> 

