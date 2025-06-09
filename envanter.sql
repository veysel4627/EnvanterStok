-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 09 Haz 2025, 13:26:20
-- Sunucu sürümü: 8.0.17
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `envanter`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cikan`
--

CREATE TABLE `cikan` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` text COLLATE utf8_turkish_ci,
  `birim` int(11) NOT NULL,
  `eklenme` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `cikan`
--

INSERT INTO `cikan` (`id`, `ad`, `aciklama`, `birim`, `eklenme`, `guncelleme`, `stok`) VALUES
(1, 'Bebek Bezi', 'Ultra Mükemmel Bebek bezi', 2, '2024-12-12 12:07:37', '2024-12-12 12:07:37', 40),
(3, 'deneme', '0', 0, '2025-04-10 14:49:14', '2025-04-10 14:49:14', 0),
(4, 'deneme123', 'qeqw', 1, '2025-05-29 15:59:54', '2025-05-29 15:59:54', 321),
(5, 'deneme999', 'adscaseaw', 2, '2025-06-09 12:50:59', '2025-06-09 12:50:59', 50);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dagitici`
--

CREATE TABLE `dagitici` (
  `id` int(11) NOT NULL,
  `ad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` text COLLATE utf8_turkish_ci NOT NULL,
  `iletisim` text COLLATE utf8_turkish_ci NOT NULL,
  `adres` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `dagitici`
--

INSERT INTO `dagitici` (`id`, `ad`, `aciklama`, `iletisim`, `adres`) VALUES
(1, 'Kendi', 'Alıcı/Satıcı ürünün ulaşımını kendisi sağlayacak', '111', '111113'),
(2, 'Marmara Dağıtım', 'Marmara bölgesi dağıtım şirketi', '3123123111', 'adcaawqeasd');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `giren`
--

CREATE TABLE `giren` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` text COLLATE utf8_turkish_ci,
  `cikan_id` int(11) DEFAULT NULL,
  `tedarikci_id` int(11) DEFAULT NULL,
  `adet` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `birim` int(99) NOT NULL,
  `fiyat` decimal(10,2) NOT NULL,
  `eklenme` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `giren`
--

INSERT INTO `giren` (`id`, `ad`, `aciklama`, `cikan_id`, `tedarikci_id`, `adet`, `stok`, `birim`, `fiyat`, `eklenme`) VALUES
(5, 'Bariyer', 'Bariyer 1', 1, 2, 10, 21312, 0, '15000.00', '2025-05-29 14:44:43'),
(6, 'Topsheet', 'Topsheet\r\n', 1, 2, 32, 0, 0, '20000.00', '2025-05-29 15:10:16'),
(7, 'Adl', 'Adl', 1, 2, 2312, 0, 0, '222222.00', '2025-05-29 15:40:50'),
(8, 'Backsheet', 'Backsheet\r\n', 1, 2, 231, 0, 0, '444321.00', '2025-05-29 15:41:25'),
(9, 'Tutkal', 'Tutkal', 1, 3, 312, 0, 0, '31123.00', '2025-05-29 15:42:18'),
(10, 'Front Ear', 'Front Ear\r\n', 1, 4, 213, 0, 0, '221213.00', '2025-05-29 15:45:20'),
(11, 'Önbant', 'Önbant\r\n', 1, 4, 12312, 0, 0, '321.00', '2025-05-29 15:45:35'),
(12, 'Mini Side Tape', 'Mini Side Tape\r\n', 1, 4, 3212, 0, 0, '23123.00', '2025-05-29 15:45:53'),
(13, 'Esnek Kulakçık', 'Esnek Kulakçık\r\n', 1, 4, 2131, 0, 0, '213123.00', '2025-05-29 15:46:18'),
(14, 'Lastik', 'Lastik\r\n', 1, 4, 221, 0, 0, '321312.00', '2025-05-29 15:46:41'),
(15, 'Losyon', 'Losyon\r\n', 1, 5, 21, 0, 0, '33223.00', '2025-05-29 15:47:16'),
(16, 'Pulp', 'Pulp\r\n', 1, 5, 21321, 0, 0, '3321.00', '2025-05-29 15:47:36'),
(17, 'Sap', 'Sap\r\n', 1, 5, 123, 0, 0, '321.00', '2025-05-29 15:47:52'),
(18, 'İndikatör', 'İndikatör\r\n', 1, 5, 13312, 0, 0, '12321.00', '2025-05-29 15:48:06'),
(19, 'Tissue', 'Tissue\r\n', 1, 5, 444, 0, 0, '1232131.00', '2025-05-29 15:48:23'),
(20, 'Ambalaj', 'Ambalaj\r\n', 1, 5, 1232, 0, 0, '2321211.00', '2025-05-29 15:48:42'),
(21, '34rw', 'fdgfss', 3, 2, 12, 0, 0, '31.00', '2025-05-30 06:49:19'),
(22, 'deneme', 'deneme', 3, 4, 2, 213, 2, '123123.00', '2025-06-09 12:34:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `islem`
--

CREATE TABLE `islem` (
  `id` int(11) NOT NULL,
  `giren_id` int(11) DEFAULT NULL,
  `islem_turu` int(11) NOT NULL,
  `miktar` int(11) NOT NULL,
  `birim` int(11) NOT NULL,
  `dagitici_id` int(11) DEFAULT NULL,
  `islem_tarihi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `olusturma_tarihi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `kullanici_id` int(11) DEFAULT '1',
  `durum` enum('0','1') CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `islem`
--

INSERT INTO `islem` (`id`, `giren_id`, `islem_turu`, `miktar`, `birim`, `dagitici_id`, `islem_tarihi`, `olusturma_tarihi`, `kullanici_id`, `durum`) VALUES
(10, 5, 0, 21312, 1, 1, '2025-05-29 16:41:51', '2025-05-29 16:41:51', 1, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `yetki` int(11) NOT NULL,
  `katilma` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guncellenme` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`id`, `ad_soyad`, `yetki`, `katilma`) VALUES
(1, 'Admin', 1, '2025-01-09 11:10:18');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tedarikci`
--

CREATE TABLE `tedarikci` (
  `id` int(11) NOT NULL,
  `ad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` text COLLATE utf8_turkish_ci NOT NULL,
  `iletisim` text COLLATE utf8_turkish_ci,
  `adres` text COLLATE utf8_turkish_ci,
  `eklenme` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `guncelleme` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `tedarikci`
--

INSERT INTO `tedarikci` (`id`, `ad`, `aciklama`, `iletisim`, `adres`, `eklenme`) VALUES
(2, 'Süper Hammadde', 'Bariyer, Topsheet, Adl , Backsheet', '11111111114', '23333331dsad12222223', '2025-05-29 14:57:32'),
(3, 'Yapışkan Tutkal', 'Tutkal', '1213213213', 'ewqqrecadatwe2q', '2025-05-29 15:36:14'),
(4, 'Esnek Lastikçi A.Ş', 'Front Ear, Önbant, Mini Side Tape, Esnek Kulakçık, Lastik', '321431555513123', 'davasdaervqadzv', '2025-05-29 15:38:43'),
(5, 'Yumuşak Malzemeci', 'Losyon, Pulp, Sap, İndikatör ,Tissue, Ambalaj\r\n\r\n\r\n\r\n\r\n\r\n', '314155551413', 'eavadveqwrfbba', '2025-05-29 15:40:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uretim`
--

CREATE TABLE `uretim` (
  `id` int(11) NOT NULL,
  `cikan_id` int(11) NOT NULL,
  `birim` int(11) NOT NULL,
  `fiyat` int(11) NOT NULL,
  `uretim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `uretim`
--

INSERT INTO `uretim` (`id`, `cikan_id`, `birim`, `fiyat`, `uretim`) VALUES
(1, 1, 0, 5000, 0);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `cikan`
--
ALTER TABLE `cikan`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `dagitici`
--
ALTER TABLE `dagitici`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `giren`
--
ALTER TABLE `giren`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cikan_id` (`cikan_id`),
  ADD KEY `tedarikci_id` (`tedarikci_id`);

--
-- Tablo için indeksler `islem`
--
ALTER TABLE `islem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `giren_id` (`giren_id`),
  ADD KEY `kullanici_id` (`kullanici_id`) USING BTREE,
  ADD KEY `dagitici_id` (`dagitici_id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `tedarikci`
--
ALTER TABLE `tedarikci`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `uretim`
--
ALTER TABLE `uretim`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cikan_id` (`cikan_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `cikan`
--
ALTER TABLE `cikan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `dagitici`
--
ALTER TABLE `dagitici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `giren`
--
ALTER TABLE `giren`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `islem`
--
ALTER TABLE `islem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `tedarikci`
--
ALTER TABLE `tedarikci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `uretim`
--
ALTER TABLE `uretim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `giren`
--
ALTER TABLE `giren`
  ADD CONSTRAINT `giren_ibfk_1` FOREIGN KEY (`cikan_id`) REFERENCES `cikan` (`id`),
  ADD CONSTRAINT `giren_tedarikci` FOREIGN KEY (`tedarikci_id`) REFERENCES `tedarikci` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Tablo kısıtlamaları `islem`
--
ALTER TABLE `islem`
  ADD CONSTRAINT `dagitici_id` FOREIGN KEY (`dagitici_id`) REFERENCES `dagitici` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_kullanici_id` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`id`),
  ADD CONSTRAINT `islem_ibfk_1` FOREIGN KEY (`giren_id`) REFERENCES `giren` (`id`);

--
-- Tablo kısıtlamaları `uretim`
--
ALTER TABLE `uretim`
  ADD CONSTRAINT `uretim_cikan_id` FOREIGN KEY (`cikan_id`) REFERENCES `cikan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
