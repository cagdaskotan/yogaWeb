-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 17 Haz 2025, 06:39:06
-- Sunucu sürümü: 9.1.0
-- PHP Sürümü: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yoga`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about`
--

DROP TABLE IF EXISTS `about`;
CREATE TABLE IF NOT EXISTS `about` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `article` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `about`
--

INSERT INTO `about` (`id`, `title`, `article`) VALUES
(1, 'Ruken BEREKET ve Şehirde Yoga', '<p><img src=\"../media/gallery/1747750233.jpeg\"></p><p>Yoga nedir anlamam kendi yolumu bulmam zaman aldı. Bu yolda öğretiyle çelişen birçok deneyimin içinden geçtim. Bu geçişte kendi yogamı ararken ŞehirDe Yoga Konseptim oluştu. Benim gibi onlarca deneyimin içinde kaybolmuş ruhlara gerçek ve samimi bir yerden, öğretinin özüne sağdık kalarak aynı zamanda modern bilimin ışığından faydalanarak güçlü bir aktarıcı olmaya niyet ettim. Bir nebzede olsa ışık oluyorsa bu aktarıcılık kim bilir belki de yaşam amacım (dharma) gerçekleşmiş oluyordur. Dharmanızı fark etmek kendinizle bağ kurmaktan geçer. ŞehirDe Yoga’nın Dharmanızı bulmanıza ışık olması dileğiyle, benim yolum benim yogam, senin yolun senin yogan...</p>');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about_educations`
--

DROP TABLE IF EXISTS `about_educations`;
CREATE TABLE IF NOT EXISTS `about_educations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `about_educations`
--

INSERT INTO `about_educations` (`id`, `title`, `description`) VALUES
(4, 'Akdeniz Üniversitesi Eğitim Fakültesi', 'Pedagojik Formasyon'),
(3, 'Kocaeli Üniversitesi Spor Bilimleri Fakültesi', 'Rekreasyon'),
(5, 'Türkiye Çağdaş Drama Derneği', 'Yaratıcı Drama Eğitmenliği'),
(6, 'Türkiye V.G. Fitness ve B.G. Federasyonu', 'Fitness Antrenörlüğü'),
(7, 'Türkiye Cimnastik Federasyonu', 'Pilates Eğitmenliği I. & II. Kademe'),
(8, 'Türkiye His Federasyonu', 'Yoga Eğitmenliği I. & II. Kademe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `about_gallery`
--

DROP TABLE IF EXISTS `about_gallery`;
CREATE TABLE IF NOT EXISTS `about_gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `about_gallery`
--

INSERT INTO `about_gallery` (`id`, `image`) VALUES
(5, 'media/about/1747745695_4475_3.jpeg'),
(3, 'media/about/1747745674_5879_1.jpeg'),
(4, 'media/about/1747745674_6895_2.jpeg'),
(6, 'media/about/1747745695_3478_4.jpeg'),
(7, 'media/about/1747745695_1685_5.jpeg'),
(8, 'media/about/1747745695_5991_6.jpeg'),
(9, 'media/about/1747745695_4174_7.jpeg'),
(11, 'media/about/1747807592_7637_8.jpeg'),
(12, 'media/about/1747807592_1138_9.jpeg'),
(13, 'media/about/1747807592_3137_10.jpeg'),
(14, 'media/about/1747807592_9623_11.jpeg'),
(15, 'media/about/1747807592_1067_12.jpeg'),
(16, 'media/about/1747807592_1921_13.jpeg'),
(17, 'media/about/1747807592_4633_14.jpeg'),
(18, 'media/about/1747807592_8639_15.jpeg'),
(19, 'media/about/1747807592_9809_16.jpeg'),
(20, 'media/about/1747807592_2645_17.jpeg'),
(21, 'media/about/1747807592_3255_18.jpeg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(2, 'Kişisel Bakım', '2025-05-06 06:19:24'),
(3, 'Giyim', '2025-05-06 06:19:35'),
(4, 'Ekipman', '2025-05-06 06:19:42');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `classes`
--

INSERT INTO `classes` (`id`, `class`) VALUES
(2, 'Pilates'),
(5, 'Gentle Yoga'),
(6, 'Restorative Yoga'),
(7, 'Yin Yoga'),
(8, 'Hatha');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `x_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `map_embed_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `contact`
--

INSERT INTO `contact` (`id`, `address`, `phone`, `email`, `facebook_url`, `instagram_url`, `youtube_url`, `x_url`, `map_embed_code`) VALUES
(1, '8901 Atatürk Mahallesi, Konyaaltı/Antalya', '+90 543 791 85 61', 'info@sehirdeyoga.com', '', 'https://www.instagram.com/sehirde_yoga/', 'https://www.youtube.com/', 'https://x.com', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51073.119303173204!2d30.602666811394474!3d36.864744307172735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14c391fc83b10f79%3A0x7ccfbacbbb40633e!2sYoga%20%26%20Pilates%20STUDIOM!5e0!3m2!1str!2str!4v1747811258943!5m2!1str!2str\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `education`
--

INSERT INTO `education` (`id`, `title`, `is_active`, `is_delete`) VALUES
(17, 'test yoga', 1, 1),
(16, 'test', 1, 1),
(14, 'Hamile Yogası', 0, 0),
(15, 'Çocuk Yogası', 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `education_articles`
--

DROP TABLE IF EXISTS `education_articles`;
CREATE TABLE IF NOT EXISTS `education_articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `education_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `article` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `education_id` (`education_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `education_articles`
--

INSERT INTO `education_articles` (`id`, `education_id`, `subject_id`, `article`, `is_active`) VALUES
(36, 15, 3, '<p><img src=\"../media/gallery/1747376834.jpg\"></p><p>Günümüz dünyasında çocuklar da tıpkı yetişkinler gibi yoğun bir tempoya maruz kalıyor. Okul stresi, dijital ekranlar, sosyal uyaranlar ve yüksek beklentiler... Tüm bunlar küçük bedenlerde büyük baskılara neden olabiliyor. İşte bu noktada <strong>çocuk yogası</strong>, yalnızca fiziksel bir egzersiz değil; aynı zamanda çocuğun iç dünyasına yapacağı sakin ve bilinçli bir yolculuktur.</p><p><br></p><h3>Çocuk Yogası Nedir?</h3><p>Çocuk yogası, yetişkin yogasının prensiplerini temel alarak çocuklara özel olarak uyarlanmış eğlenceli, yaratıcı ve öğretici bir yoga pratiğidir. Duruşlar (asanalar), nefes çalışmaları ve kısa meditasyon egzersizleri; hikayeler, oyunlar ve şarkılar eşliğinde aktarılır. Böylece çocuklar hem bedensel farkındalık kazanır, hem de zihinsel olarak rahatlamayı öğrenir.</p><p><br></p><h3>Faydaları Nelerdir?</h3><p><strong>1. Bedensel Gelişim:</strong></p><p> Yoga, çocukların esneklik, denge, koordinasyon ve duruş gibi motor becerilerini geliştirir. Bedenlerini tanımayı ve doğru kullanmayı öğrenirler.</p><p><strong>2. Zihinsel Denge:</strong></p><p> Nefes farkındalığı ve meditasyon teknikleri sayesinde çocuklar stresle baş etmeyi öğrenir, odaklanma ve dikkat süreleri artar.</p><p><strong>3. Özgüven ve İfade Gücü:</strong></p><p> Yoga pratiği sırasında çocuklar kendi sınırlarını keşfeder ve başarı duygusunu deneyimler. Grup çalışmalarında ise ifade etme, paylaşma ve empati kurma becerileri gelişir.</p><p><strong>4. Duygusal Sağlık:</strong></p><p>Yoga, çocuklara duygularını fark etmeyi ve yönetmeyi öğretir. Kızgınlık, kaygı veya hüzün gibi duygularla başa çıkmada güçlü bir araç sunar.</p><h3><br></h3><h3>Yoga, Oyun ve Hayal Gücüyle Buluştuğunda</h3><p>Çocuk yogasında pozlar bazen bir kediye, bazen bir ağaca ya da uçan bir kuşa dönüşür. Bu yaratıcı anlatım dili, çocukların ilgisini çekerken hayal güçlerini de besler. Yoga seansı; aynı zamanda bir hikaye, bir yolculuk veya bir küçük keşif olabilir.</p><p><br></p><h3>Kimler İçin Uygundur?</h3><p>Çocuk yogası, genellikle 3-12 yaş arası çocuklar için uygundur. Ancak doğru yönlendirmelerle daha küçük yaş grupları için de güvenli ve eğlenceli bir şekilde uygulanabilir.</p><p> Grup dersleri, bireysel seanslar ya da okul etkinlikleriyle kolayca entegre edilebilir.</p><h3><br></h3><h3>Neden Erken Yaşta Başlamalı?</h3><p>Yoga ile tanışan çocuklar, erken yaşta bedenleriyle barışır, duygularını tanır ve zihinsel dengeyi deneyimler. Bu farkındalık, hayatları boyunca onlara eşlik edecek güçlü bir temeldir. Çünkü yoga sadece bir egzersiz değil, bir yaşam becerisidir.</p><p><br></p><h2>✨ Sonuç</h2><p>Çocuk yogası; güçlü, esnek, sağlıklı ve mutlu bireyler yetiştirmenin yumuşak ama etkili bir yoludur. Çocuklara “hızlı olmak” yerine “farkında olmayı”, “yarışmak” yerine “dengeyi” öğretir.</p><p> Daha huzurlu bir gelecek için, çocuklarımıza önce kendi iç dünyalarında huzuru bulmayı öğretmeliyiz.</p>', 0),
(35, 14, 2, '<p><img src=\"../media/gallery/1747144603.jpg\"></p><p>Hamile yogası, anne adaylarının bedenlerini doğuma hazırlarken aynı zamanda zihinlerini de rahatlatmalarına yardımcı olan özel bir yoga pratiğidir. Doğru yapıldığında hem fiziksel konfor sağlar hem de annede içsel bir denge oluşturur.</p><p>İşte hamile yogasına dair bazı önemli püf noktaları:</p><ol><li>Nazik ve yavaş hareket etmek önemlidir. Amaç esnemek, zorlamak değil.</li><li>Derin ve bilinçli nefes egzersizleri, hem anneyi hem de bebeği sakinleştirir.</li><li>Sırt üstü yatılan pozisyonlardan kaçınılmalıdır (özellikle ikinci ve üçüncü trimesterde).</li><li>Pelvis ve bel bölgesini rahatlatan pozlara ağırlık verilebilir.</li><li>Bol ve rahat kıyafetler tercih edilmeli, ortam iyi havalandırılmalıdır.</li><li>Profesyonel eğitmen eşliğinde ya da doktor onayıyla yapılmalıdır.</li></ol><p><br></p><p>Hamile yogası, doğum sürecine hazırlanmanın en doğal yollarından biridir. Hem bedeni güçlendirir hem de anne ile bebek arasındaki bağı derinleştirir.</p>', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `education_subjects`
--

DROP TABLE IF EXISTS `education_subjects`;
CREATE TABLE IF NOT EXISTS `education_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `education_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `education_subjects`
--

INSERT INTO `education_subjects` (`id`, `education_id`, `title`, `is_active`, `is_delete`, `slug`) VALUES
(2, 14, 'Hamile Yogasının Püf Noktaları', 1, 0, 'hamile-yogasinin-puf-noktalari'),
(3, 15, 'Çocuk Yogasının Önemi', 1, 0, 'cocuk-yogasinin-onemi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `events`
--

INSERT INTO `events` (`id`, `title`, `start_date`, `end_date`, `is_active`, `slug`) VALUES
(6, 'İlkbaharın Son Yogası', '2025-05-27', '2025-05-29', 1, 'ilkbaharin-son-yogasi'),
(8, 'Yaza Merhaba Etkinliği', '2025-06-01', '2025-06-03', 1, 'yaza-merhaba-etkinligi'),
(15, 'Yakında', '2025-07-09', '0000-00-00', 1, 'yakinda');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `events_articles`
--

DROP TABLE IF EXISTS `events_articles`;
CREATE TABLE IF NOT EXISTS `events_articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `article` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `events_articles`
--

INSERT INTO `events_articles` (`id`, `event_id`, `article`) VALUES
(15, 8, '<p><img src=\"../media/gallery/1747663844.jpg\"></p><p><em>Bedenini Hareketle, Ruhunu Nefesle Uyandır.</em></p><p><em>Yeni mevsime zihinsel dinginlik ve bedensel canlılıkla adım atmaya ne dersiniz?</em></p><p><em>Sizi, yazın taze enerjisini karşılayacağımız özel bir yoga buluşmasına davet ediyoruz. “Yaza Merhaba Yoga Etkinliği”, doğayla iç içe, huzur dolu bir atmosferde; bedenimizi esnetip, nefesimizi derinleştirerek yaza güçlü ve dengeli bir başlangıç yapmamızı sağlayacak.</em></p><p><strong>Saat:</strong> 09:00 – 10:30</p><p><strong>Yer:</strong> Karaalioğlu Parkı, Antalya</p><p>Bu etkinlik, tüm seviyelere açıktır. Yoga pratiğine yeni başlayanlar için rehberlik sağlanacak, deneyimliler içinse derinleşme fırsatı sunulacaktır.</p><p>Yanınıza sadece matınızı, suyunuzu ve açık bir kalp alın.</p><p> Doğanın enerjisiyle buluşmaya, yazı birlikte karşılamaya davetlisiniz.</p>'),
(16, 6, '<p><img src=\"../media/gallery/1747684580.jpg\"></p><p><em>Doğayla Uyumlan, Bedeninle Yenilen.</em></p><p>İlkbaharın tazeliğini hissettiğimiz, doğanın en canlı renklerini sunduğu bu özel dönemi birlikte tamamlamak ister misiniz?</p><p>Sizi, yılın bu eşsiz zamanına veda ederken doğayla bütünleşeceğimiz, bedenimizi ve ruhumuzu arındıracağımız <strong>“İlkbaharın Son Yogası”</strong> etkinliğine davet ediyoruz. Açık havada, kuş sesleri eşliğinde, doğanın kalbinde gerçekleştireceğimiz yoga buluşmamızda; nefes, denge ve içsel huzura odaklanacağız.</p><p><br></p><p>Kimler katılabilir?</p><p> Yeni başlayanlar, deneyimliler, sadece doğayı hissetmek isteyen herkes...</p><p>Yanınıza sadece bir mat, hafif bir kıyafet ve açık bir kalp alın yeter.</p><p> Bu buluşma, mevsimlerin geçişini birlikte hissedip, yeni bir döneme taptaze bir zihinle adım atmak için harika bir fırsat.</p><p><strong>Sonbahara güçlü bir merhaba demeden önce, ilkbaharla sakin bir vedalaşma...</strong></p><p> Sen de bu özel deneyimin bir parçası ol!</p><p><br></p><p><strong>Yer: </strong>Karaalioğlu Parkı, Antalya</p><p><strong>Saat: </strong>16:00 - 17:30</p>');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `instructors`
--

DROP TABLE IF EXISTS `instructors`;
CREATE TABLE IF NOT EXISTS `instructors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'default.jpg',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `instructors`
--

INSERT INTO `instructors` (`id`, `name`, `surname`, `image`) VALUES
(2, 'Çağdaş', 'Kotan', 'media/instructors/default.jpg'),
(5, 'Ali', 'Bayırlı', 'media/instructors/68284760eac9a_egitmen2.png'),
(4, 'Hilal', 'Bulut', 'media/instructors/682ad63e86638_egitmen1.jpg'),
(14, 'Sezer', 'Badur', 'media/instructors/68284769e53a0_egitmen3.jpg'),
(16, 'Jason', 'Momoa', 'media/instructors/68284c0f85c25_egitmen4.jpg'),
(17, 'Chris', 'Hemsworth', 'media/instructors/68284dda98c13_egitmen5.jpg'),
(18, 'İlker', 'Özkan', 'media/instructors/6828d6c1bd24d_egitmen6.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_delete` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `lessons`
--

INSERT INTO `lessons` (`id`, `title`, `is_active`, `is_delete`) VALUES
(19, 'test2', 1, 1),
(18, 'test', 1, 1),
(17, 'Advanced Yoga', 1, 0),
(16, 'Yeni Başlayanlar', 1, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lessons_articles`
--

DROP TABLE IF EXISTS `lessons_articles`;
CREATE TABLE IF NOT EXISTS `lessons_articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `article` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `lesson_id` (`lesson_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `lessons_articles`
--

INSERT INTO `lessons_articles` (`id`, `lesson_id`, `subject_id`, `article`, `is_active`) VALUES
(10, 16, 6, '<p>Yoga, binlerce yıllık geçmişe sahip, kökeni Hindistan’a dayanan bir beden-zihin disiplinidir. Sanskritçe\'de \"birlik\" veya \"bütünleşme\" anlamına gelen <em>yuj</em> kelimesinden türetilen yoga, bireyin bedeni, zihni ve ruhu arasında uyum kurmayı hedefler. Modern dünyada ise yoga, hem fiziksel sağlığı güçlendiren hem de zihinsel dinginlik sağlayan bütünsel bir yaşam pratiği olarak kabul görmektedir.</p><p>Yoga pratiği; fiziksel duruşlar (<em>asanalar</em>), nefes teknikleri (<em>pranayama</em>) ve meditasyon gibi unsurları bir araya getirerek bedenin esnekliğini artırır, kasları güçlendirir, duruşu düzeltir ve stresi azaltır. Aynı zamanda bireyin kendini daha iyi tanımasına, odaklanmasına ve içsel huzura ulaşmasına yardımcı olur.</p><p><br></p><p>Yoganın en güzel yanlarından biri, her yaş grubuna ve her beden tipine uygun olmasıdır. Esneklik ya da deneyim gerektirmez; kişi kendi sınırlarına saygı duyarak ilerler. Düzenli yoga yapan bireyler, sadece fiziksel faydaları değil, aynı zamanda duygusal ve zihinsel olarak da daha dengeli bir yaşam sürmenin ayrıcalığını yaşarlar.</p>', 0),
(13, 16, 7, '<p><img src=\"../media/gallery/1747138187.jpg\"></p><p>Yoga; beden, zihin ve nefesin uyumunu sağlayan kadim bir disiplindir. Yeni başlayanlar için yoga, fiziksel esnekliği artırmanın ötesinde, günlük stresi azaltmak ve zihinsel dinginlik kazanmak için harika bir yöntemdir. Bu derste, aşağıdaki konulara odaklanacağız:</p><ul><li><strong>Doğru nefes teknikleri (Pranayama):</strong> Nefes kontrolüyle bedenini ve zihnini sakinleştirmeyi öğreneceksin.</li><li><strong>Temel duruşlar (Asana):</strong> Dağ duruşu, aşağı bakan köpek ve çocuk duruşu gibi pozisyonlarla kaslarını fark etmeye başlayacaksın.</li><li><strong>Rahatlama (Savasana):</strong> Dersin sonunda kısa bir gevşeme bölümüyle zihinsel arınma deneyimleyeceksin.</li></ul><p><br></p><p>Yeni başlayanlar için bu yolculukta önemli olan mükemmel olmak değil, kendini keşfetmektir. Matını ser ve bedeninin sana ne söylediğini dinlemeye başla.</p>', 0),
(14, 17, 8, '<p><img src=\"../media/gallery/1747134256.jpg\"></p><p>İleri seviye yoga dersleri, pratiğini derinleştirmek ve beden-zihin farkındalığını bir üst boyuta taşımak isteyen katılımcılar için tasarlanmıştır. Bu derslerde artık sadece pozlara girmek değil, pozların içindeki dengeyi, nefesi ve zihinsel duruşu da keşfetmek ön plandadır.</p><p>Katılımcılar, gelişmiş asanalarla bedenlerini daha güçlü ve esnek hale getirirken; aynı zamanda meditasyon, pranayama (nefes kontrolü) ve zihinsel odaklanma teknikleriyle içsel yolculuklarına da devam ederler. İleri seviye pratik, kişinin sınırlarını bilinçli bir şekilde keşfetmesini, kendiyle daha derin bir bağ kurmasını sağlar.</p><p>Bu dersler:</p><ul><li>Vücut farkındalığını artırır</li><li>Zihin ve nefes kontrolünü güçlendirir</li><li>Gelişmiş denge ve güç pozlarına odaklanır</li><li>Meditasyon süresini ve derinliğini artırır</li><li>Sabır, istikrar ve içsel disiplin kazandırır</li></ul><p><br></p><p>İleri seviye yoga, bir yarış değil; derinleşme yolculuğudur. Her poz, bir meydan okuma değil; bir farkındalık davetidir.</p>', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lessons_subjects`
--

DROP TABLE IF EXISTS `lessons_subjects`;
CREATE TABLE IF NOT EXISTS `lessons_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lesson_id` int NOT NULL,
  `title` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_delete` tinyint(1) DEFAULT '0',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `lessons_subjects`
--

INSERT INTO `lessons_subjects` (`id`, `lesson_id`, `title`, `is_active`, `is_delete`, `slug`) VALUES
(7, 16, 'Yoga 101', 1, 1, 'yoga-101'),
(6, 16, 'Yoga Nedir?', 1, 0, 'yoga-nedir'),
(8, 17, 'İleri Seviye Yoga Dersi', 1, 0, 'ileri-seviye-yoga-dersi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `image` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `price`, `description`, `image`, `is_active`, `slug`) VALUES
(13, 'Yoga Shirt 2', 3, 550.00, '', 'media/products/1747398827_tshirt2.jpg', 1, 'yoga-shirt-2'),
(12, 'Yoga Shirt', 3, 550.00, '', 'media/products/1747398836_tshirt1.jpg', 1, 'yoga-shirt'),
(8, 'Yoga Belt 3', 4, 400.00, '', 'media/products/1747398867_belt3.jpg', 1, 'yoga-belt-3'),
(9, 'Yoga Belt 4', 4, 450.00, '', 'media/products/1747398860_belt4.jpg', 1, 'yoga-belt-4'),
(10, 'Yoga Mat', 4, 200.00, '', 'media/products/1747398853_mat1.jpg', 1, 'yoga-mat'),
(11, 'Yoga Mat 2', 4, 200.00, '', 'media/products/1747398845_mat2.jpg', 1, 'yoga-mat-2'),
(14, 'Yoga Shirt 3', 3, 590.00, 'Mavi yoga tişörtü', 'media/products/1747398818_tshirt3.jpg', 1, 'yoga-shirt-3'),
(29, 'Yoga Shirt 4', 3, 600.00, 'Baskılı kırmızı yoga tişörtü', 'media/products/1747637540_tshirt4.jpeg', 1, 'yoga-shirt-4');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `instructor_id` int NOT NULL,
  `schedule_day` tinyint NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `instructor_id` (`instructor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `schedule`
--

INSERT INTO `schedule` (`id`, `class_id`, `instructor_id`, `schedule_day`, `start_time`, `end_time`, `is_active`) VALUES
(1, 2, 2, 2, '10:25:00', '12:30:00', 1),
(2, 7, 5, 3, '15:30:00', '17:30:00', 1),
(4, 6, 4, 1, '10:10:00', '12:10:00', 1),
(5, 7, 5, 6, '21:20:00', '22:20:00', 1),
(6, 8, 16, 2, '14:30:00', '15:30:00', 1),
(7, 2, 4, 1, '11:11:00', '12:12:00', 1),
(8, 2, 2, 5, '08:00:00', '13:05:00', 1),
(9, 8, 18, 3, '15:00:00', '16:00:00', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'assets/images/personal.png',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gsm` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_admin` tinyint DEFAULT '0',
  `is_active` tinyint DEFAULT '0',
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `theme` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'light',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `avatar`, `title`, `gsm`, `is_admin`, `is_active`, `created`, `updated`, `deleted`, `theme`) VALUES
(2, 'Admin', 'User', 'admin@sehirdeyoga.com', '$2a$10$HDseI2Pak5tNo2MX7nthCOgfTp4R8hzvpGzBXkZrpK/VcI.8jGNrO', 'assets/images/brand1.jpg', 'Site Admin', NULL, 1, 1, '2025-05-05 11:09:46', NULL, NULL, 'light');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
