-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 23 Haz 2026, 19:57:59
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `demackrf_cosmetic`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`id`, `email`, `sifre`) VALUES
(1, 'admin@cosmetic.com', '$2y$10$GAIzIK9uC2yceAgEJjKCSegEtw1BtlYKVyYfcNeFiR1yTeS4a6b/a');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `adres` mediumtext DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sepet`
--

CREATE TABLE `sepet` (
  `sepet_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `urun_adi` varchar(255) NOT NULL,
  `urun_fiyat` decimal(10,2) NOT NULL,
  `miktar` int(11) NOT NULL DEFAULT 1,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `kullanici_id` int(11) NOT NULL,
  `urun_adi` varchar(255) NOT NULL,
  `urun_adet` int(11) NOT NULL,
  `toplam_fiyat` decimal(10,2) NOT NULL,
  `siparis_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `ad_soyad` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `adres` text NOT NULL,
  `odeme_yontemi` varchar(50) NOT NULL,
  `durum` varchar(50) NOT NULL DEFAULT 'Yeni',
  `siparis_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_adi` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `marka` varchar(100) DEFAULT NULL,
  `urun_fiyat` decimal(10,2) NOT NULL,
  `stok_adedi` int(11) NOT NULL,
  `aciklama` mediumtext DEFAULT NULL,
  `eklenme_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `resim_url` varchar(255) DEFAULT NULL,
  `yedek1` varchar(255) DEFAULT NULL,
  `yedek2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`urun_id`, `urun_adi`, `kategori`, `marka`, `urun_fiyat`, `stok_adedi`, `aciklama`, `eklenme_tarihi`, `resim_url`, `yedek1`, `yedek2`) VALUES
(1, 'Afterglow Liquid Blush', 'Allık', 'NARS', 1720.00, 300, 'NARS Afterglow Liquid Blush, cilde doğal görünümlü ışıltı ve canlılık kazandıran likit allıktır. Daha sağlıklı görünen bir cilt için cilt bakımı faydaları sunar. Çizgilerde birikme yapmaz, ipeksi formüle sahiptir ve uzun süre kalıcıdır. Hafif, ultra kremsi yapısı sayesinde bulaşma olmadan kolay bir uygulama sunar. Artırılabilir pigment yapısı yumuşak bir uygulamadan yoğun bir uygulamaya kadar geniş bir olanak sağlar. İçeriğinde bulunan E vitamini güçlü antioksidan özellikleri ile cildi çevresel saldırganlardan korumaya yardımcı olur ve destekler. Sodyum Hiyalüronat 8 saat süresince cilde nem sağlarken cilt bariyerini derinlemesine besler. Vegan Protein ile güçlendirilmiş yapısı cildin sağlıklı görünmesini sağlar.', '2024-12-16 19:43:07', 'https://www.sephora.com.tr/dw/image/v2/BCZG_PRD/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwae7a15ae/images/hi-res/SKU/SKU_4492/670255_swatch.jpg?sw=585&sh=585&sm=fit', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwa50e2c27/images/hi-res/alternates/PID_alternate1/PID_alternate1_3092/P10052424_1.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwae75012c/images/hi-res/alternates/PID_alternate3/PID_alternate3_2261/P10052424_3.jpg'),
(2, 'Light Reflecting Foundation', 'Fondöten', 'NARS', 2380.00, 147, 'Işığın cildinizdeki en iyi yansıması. Makyaj ve cilt bakımının yenilikçi karışımı ile kusurları anında kapatır, cildi pürüzsüzleştirir. Leke, siyah nokta ve kızarıklıkları gizler. Altı haftalık günlük kullanımdan sonra, makyaj temizlendikten sonra bile cildin netliğini gözle görülür şekilde arttırır. Anlık etki: +%93** daha eşit bir cilt tonu ortaya çıkarır.* Mavi ışığa (ekran ışığına) karşı cildi korumaya yardımcı olan gelişmiş cilt bakım bileşenleriyle güçlendirilmiştir. Nemi korumak için cildin bariyerini anında güçlendirir. Light Reflecting Complex, cilt yüzeyindeki parlaklığı hedef alarak ve dış etkenlere karşı cildi savunmaya yardımcı olarak ışığı prizma gibi yansıtır. %70 cilt bakım bileşenlerinden oluşan vegan formül ile cilt hemen aydınlanır. Zamanla cildin berraklığını ve parlaklığını arttırdığı klinik olarak kanıtlanmıştır. Ortadan yükseğe artırılabilir kapatıcılığa sahiptir. Ağırlıksızdır, hava kadar hafif hissettirir. Işığın yoğunluğuna göre cilt tonunu ayarlayan \"foto-dostu\" bir formül olan Photochromic Teknoloji’ye sahiptir. Cilt asla solgun görünmez. Hassas ciltler dahil tüm cilt tipleri için uygundur. 36 rengi mevcuttur.', '2024-12-16 20:06:56', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw9152df01/images/hi-res/SKU/SKU_3112/586470_swatch.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw334266cd/images/hi-res/alternates/PID_alternate4/PID_alternate4_1290/P10024551_4.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwee7e524c/images/hi-res/alternates/PID_alternate1/PID_alternate1_1997/P10024551_1.jpg'),
(3, 'Climax Extreme', 'Maskara', 'NARS', 1420.00, 140, 'Climax Extreme Maskara ile tanışın. Ekstra hacim. Ektra siyah. Olağanüstü performans. Climax, şimdiye kadarki en yüksek hacimle zirveye tek bir sürüşle ulaşıyor. Yeni Loaded Pigment Complex ve XXXL kıvrımlı fırça, kökten uca lateks benzeri siyah pigment ile anında yüksek hacim oluşturur. Maksimum hacim. Minimum çaba.', '2024-12-16 20:31:33', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw9211b374/images/hi-res/SKU/SKU_1722/531401_swatch.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw03fe0dda/images/hi-res/alternates/PID_alternate2/PID_alternate2_793/P10011394_2.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwe2ab2dbd/images/hi-res/alternates/PID_alternate3/PID_alternate3_700/P10011394_3.jpg'),
(4, 'Explicit Lipstick - Saten Bitişli Uzun Süre Kalıcı Ruj', 'Ruj', 'NARS', 1900.00, 209, 'Canlı, saf renk etkisi ile kremsi, dağılmaya karşı dayanıklı, üst düzey teknolojide saten bitişli Explicit Ruj ile uzun süreli konforu keşfedin. Yeni hassas uçlu ruj, dudakları belirginleştirme ve kontur için şekillendirilmiş bir zarafet sağlar. Luxe Comfort Complex ise dudakları ağırlık hissi olmadan, orta ila tam kapatıcılıkta renklendirmenizi sağlar.', '2024-12-16 20:37:21', 'https://www.sephora.com.tr/dw/image/v2/BCZG_PRD/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw4b395d4a/images/hi-res/SKU/SKU_5619/721802_swatch.jpg?sw=585&sh=585&sm=fit', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwb43607ff/images/hi-res/alternates/PID_alternate3/PID_alternate3_3001/P10059862_3.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw4f11f6e1/images/hi-res/alternates/PID_alternate1/PID_alternate1_3924/P10059862_1.jpg'),
(5, 'Dior Addict Lip Maximizer', 'Ruj', 'DIOR', 1690.00, 349, 'Dior, dolgunlaştırıcı parlatıcısı Dior Addict Lip Maximizer\'ı %90 doğal kaynaklı bileşenlerden oluşan bir dudak bakım formülüyle yeniden tasarladı.\r\n\r\nDior Addict Lip Maximizer parlaklığı, berrak, yoğun, ışıltılı ve holografik bitişli bir dizi parlak tonda mevcuttur. Çoklu kullanım, tek başına parlatıcı olarak veya dolgun görünümlü ve nemli dudaklar için ruj baz olarak kullanılabilir.', '2024-12-16 20:39:49', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw6577c7d8/images/hi-res/SKU/SKU_4106/652846_swatch.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwf237ea1d/images/hi-res/alternates/PID_alternate1/PID_alternate1_2767/P10048269_1.jpg', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwbacd4c12/images/hi-res/alternates/PID_alternate4/PID_alternate4_1864/P10048269_4.jpg'),
(6, 'Rouge Blush', 'Allık', 'DIOR', 2000.00, 500, 'İkinci bir cilt hissi veren ve mat, saten, ışıltılı ve holografik olmak üzere 4 makyaj efekti seçeneğiyle Dior\'dan Rougue Blush allık yanaklarınızı ve elmacık kemiklerinizi uzun süre kalıcı, sağlıklı bir ışıltı efekti ile güzelleştirecek.\r\n\r\n%90* doğal kökenli bileşenlerden oluşan bu ipeksi dokulu allık, cildin nemini korur. Sabahtan akşama kadar rahat bir kullanım sağlar.\r\n\r\nBaz olarak da kullanabileceğiniz Rouge Blush, en doğaldan en yoğununa kadar aklınızdan geçen makyaj bitişini oluşturmanızı sağlar.\r\n\r\n* Miktar ISO 16128-1 ve ISO 16128-2 standartlarına göre hesaplanmıştır. Su yüzdesi orana dâhildir. Geriye kalan maddeler formülün performansına, duyusal çekiciliğine ve stabilitesine katkıda bulunur.', '2024-12-16 20:41:26', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw58bff534/images/hi-res/SKU/SKU_4491/694216_swatch.jpg', NULL, NULL),
(7, '5 Couleurs Couture Eyeshadow Palette', 'Far Paleti', 'DIOR', 2650.00, 250, 'İkonik 5 Couleurs göz farı, ambalajı ve formülüyle yeniden tasarlandı. Her far, özel olarak tasarlanmış mücevheri andıran ayrı bir bölümde bulunur. Aloe vera ve çam yağı ile zenginleştirilerek, farın göz kapağı üzerine pürüzsüz ve yumuşak bir şekilde uygulanmasını sağlar. Göz farı renkleri canlı ve eşsizdir.', '2024-12-16 20:43:40', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw96d1f61e/images/hi-res/SKU/SKU_4088/689081_swatch.jpg', NULL, NULL),
(8, 'Dior Forever Natural Nude - Fondöten', 'Fondöten', 'DIOR', 2270.00, 450, 'Dior Forever fondöten, %96** doğal kaynaklı bileşenler ve konsantre çiçek cilt bakımı ile zenginleştirilmiş formülü sayesinde Natural Nude: 24h* nude cilt hissi ile mükemmellik ile doğal ten rengini yeniden keşfetti.\r\n\r\nDior Forever Natural Nude fondötenin taze ve hafif dokusu, maske etkisi olmadan doğal ve ışıltılı bir bitiş sağlayarak cildin sabahtan akşama kadar nefes almasını sağlar. Cilt 24 saat boyunca bile kusursuzdur.* Cilt nemlenir*** ve sanki dolgunlaşmış gibi parlar.\r\n24 saat** düzlükte cilt mükemmel şekilde eşit, aydınlık ve doğal görünür.\r\nYüksek konsantrasyonda su içeren taze ve hafif dokusu, cildin nefes almasını sağlar ve 24 saat boyunca nemlendirir.**\r\n\r\nAnında cilt bakımına ek olarak, çiçeksi cilt bakımıyla zenginleştirilmiş Dior Forever Natural Nude fondöten, günden güne daha güzel, daha güçlü bir cilt elde etmek için çalışır.\r\n%96 oranında doğal kökenli bileşenlerden oluşan** taze, hafif emülsiyon benzeri dokusu uygulama sırasında emilir ve cildin nefes almasını sağlar.\r\nÇiçekli cilt bakımına konsantre formülün özünde 3 faydalı çiçekten oluşan bir CİLT CANLANDIRICI KOMPLEKSİ bulunur: Her geçen gün daha güzel, daha güçlü görünen bir cilt için latin çiçeği, hercai menekşe ve ebegümeci çiçeklerinin özleri.\r\n\r\nDermatolojik olarak test edilmiştir, hassas ciltler dahil tüm cilt tipleri için uygundur.\r\n\r\n* 20 denekte enstrümantal test.\r\n** Tutar, ISO 16128-1 ve ISO 16128-2 standardına göre hesaplanmıştır. Su yüzdesi dahildir. Kalan bileşenler, formülün duyusal çekiciliğini ve bütünlüğünü zamanla optimize etmeye yardımcı olur.\r\n*** 10 denekte enstrümantal test.', '2024-12-16 20:46:24', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw1fce07dd/images/hi-res/SKU/SKU_2112/544478_swatch.jpg', NULL, NULL),
(9, 'Precisely, My Brow Wax - Kaş Sabitleyici', 'Kaş Sabitleyici', 'BENEFIT', 1500.00, 600, 'Ultra pigmentli kaş sabitleyici, My Brow Wax\'ı hızla keşfedin.\r\n\r\nKaşlarınızı yapılandırmak, düzeltmek ve renklendirmek için mükemmel kombinasyon. Ultra hafif dokuya sahip bu kaş sabitleyici, kaşlarınızı doğal bir etkiyle şekillendirir, renklendirir ve sabitler. Ultra hassas aplikatörü, mükemmel ve hassas uygulama sağlayan çift taraflı bir uca sahiptir.\r\n\r\n- 12 saat sürer(1)\r\n\r\n- Zengin, doğal renk\r\n\r\n- Transfer gerektirmez ve suya dayanıklıdır\r\n\r\n- Anında Sonuç\r\n\r\n- Hafif formül\r\n\r\n- 12 renkte mevcuttur\r\n\r\n(1) 25 katılımcı üzerinde enstrümantal test\r\n\r\n\r\n\r\nKesinlikle My Brow Wax\'ı seviyorlar:\r\n\r\n- %90\'ı kaşları çok iyi renklendirdiğini söylüyor(2)\r\n\r\n- %91\'i fırçanın kaşları iyi sabitlediğini söylüyor(2)\r\n\r\n- %90\'ı kaşların yerinde kaldığını söylüyor(2)\r\n\r\n- %90\'ı fırça aplikatörünün hassas uygulama sağladığını söylüyor(2)\r\n\r\n(2) 1 haftalık kullanımın ardından 112 katılımcının öz değerlendirmesi\r\n\r\nÖnemli bileşenler:\r\n\r\n- Kaşlarınızı besleyen yağ asitleri açısından zengin Shea Yağı, Jojoba Yağı ve Argan Yağı\r\n\r\n- Uzun süre aşınmaya izin veren karnauba mumu\r\n\r\nGüzellik İpucu:\r\n\r\nAyrıca kaşlarınızı kolaylıkla ve hassas bir şekilde tanımlamak ve şekillendirmek için Benefit\'in ultra hassas kaş kalemi Precisely My Brow Pencil\'ı da uygulayın!', '2024-12-16 20:50:59', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw07cf228b/images/hi-res/SKU/SKU_4996/716322_swatch.jpg', NULL, NULL),
(10, 'Gloss Bomb Stix - Nemlendirici Ruj', 'Ruj', 'FENTY BEAUTY', 1199.00, 700, 'Orta pigmentasyon ve yoğun parlaklık veren nemlendirici hibrit ruj ve parlatıcı.\r\n\r\nFenty Beauty şimdi yeni Gloss Bomb Stix ile son derece pigmentli bir görünüm için nemlendirici bir ruj ve ışıltılı bir parlatıcıyı birleştiriyor. Artık Gloss Bomb\'un patlayıcı parlaklığına renkli bir çubukla sahip olabilirsiniz. \r\n\r\nBu parlak rujun formülü dudakları nemlendiren, besleyen ve dolgunlaştıran yumuşak bileşenlerle doludur.   \r\n\r\nFaydaları:\r\n\r\n-Besleyici + yapışkan olmayan formül\r\n-Orta pigmentasyon + yoğun parlaklık\r\n-Nemi 8 saate kadar korur\r\n-Skualen, E Vitamini, Shea Yağı, Kivi Tohumu Yağı ile zenginleştirilmiştir.', '2024-12-16 20:53:41', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwd2620e4e/images/hi-res/SKU/SKU_5445/724485_swatch.jpg', NULL, NULL),
(11, 'The POREfessional Primer', 'Primer', 'BENEFIT', 1950.00, 250, 'The POREfessional pürüzsüzün de pürüzsüzü bir cilt için gözeneklerin & ince çizgilerin görünümünü anında kamufle eder. Bu ipeksi, hafif dokulu balmı ister tek başına, ister makyajın altına ya da üstüne kullanın. Yarı saydam formülü her ten rengiyle uyumludur. Yağ içermeyen formülü sayesinde her cilt tipine uygundur.', '2024-12-16 21:10:05', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw0decf617/images/hi-res/SKU/SKU_2/206888_swatch.jpg', NULL, NULL),
(12, 'Crystah WANDERful World', 'Allık', 'BENEFIT', 1860.00, 150, 'Bu ışılıltı tatlı pembe allık ile enerjiniz anında yükselecek! • Tere, neme ve bulaşmaya karşı dayanıklıdır. • İpeksi krem yumuşaklığı ile ağırlık hissi yaratmaz. • Komedojenik değildir. • Tatlı su incisi & sentetik safir ile aydınlık, ışığı yansıtan bir ışıltı verir. • Taze narenciye çiçekleri kokusunda. Benefit’in Çok Amaçlı Fırçası ile harika bir ikilidir! Ekstra belirginlik için Hoola bronzer ve makyajınızı hızlıca tamamlamak için BADgal! BANG! Maskara\'dan destek alın. Daha fazla macera için koleksiyonumuzda yer alan 12 tonu keşfedin!', '2024-12-16 21:15:10', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwc238df2b/images/hi-res/SKU/SKU_3450/585617_swatch.jpg', NULL, NULL),
(13, 'Fan Fest Hacim, Lifting ve Volume Etkili Maskara', 'Maskara', 'BENEFIT', 1400.00, 250, 'Fan Fest hacim, volume ve lifting etkili maskara ile kirpiklerinizi tek tek ayırarak belirginleştirin. Fan Fest\'in özel Full-Flex Fiber fırçası, kirpikleri kökten uca kaldıran ve köşeden köşeye ulaşan 40°\'lik bir açıya sahiptir. Kirpikleri kavrayan özel fırça, her kirpiğe eşit şekilde ürün gelmesini destekler. Ağırlık hissi yaratmayan formül sayesinde maskara kalıcılığını korur, topaklanma ve dökülme yapmaz. Formül içerisinde yer alan esnek lifler sayesinde kirpikler sertleşmeden belirginleşir.  \r\n\r\n-24 saat(1) boyunca yelpaze gibi tek tek ayrılmış kirpik görünümü \r\n-Dağılmaya dayanıklı \r\n-Ultra siyah renk \r\n-Su geçirmeyen, nem ve terlemeye dayanıklı formül \r\n-Oftalmolojik olarak test edilmiştir\r\n\r\nDeneyenler:\r\n-%92 bu maskara kirpiklerimde gerçekten yelpaze etkisi yarattı(2)\r\n-%97 kirpiklerimin daha belirgin olduğuna katılıyorum(2)\r\n-%92 kirpiklerimin daha ayrık göründüğüne katılıyorum(2)\r\n\r\nBakım yapan maskara formülü:\r\n-Provitamin B5 kirpiklerin sertleştirmeden, esnek yapısını destekler \r\n-Kızılcık özü içerdiği değerli yağ asitleriyle kirpikleri beslemeye yardımcı olur \r\n-Pirinç mumu kirpiklerin tek tek ayrılmış ve daha kalkık görünmesine destek olur \r\n\r\n(1) 27 kişi ile gerçekleştirilen enstrumental test sonucu\r\n(2) 119 katılımcı ile gerçekleştirilen 1 haftalık kişisel değerlendirme sonucu', '2024-12-16 21:17:50', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw426ac05e/images/hi-res/SKU/SKU_4553/696556_swatch.jpg', NULL, NULL),
(14, 'ROUGE COCO', 'Ruj', 'CHANEL', 1900.00, 500, 'ROUGE COCO, CHANEL\'in ikonik ruju, yeniden yaratıldı. Daha fazla duyusal deneyim ve gün boyu nem için yeni bir formül. Seride yer alan 24 renk için Mademoiselle Chanel\'in, ona Coco diye seslenen yakın arkadaşlarından ilham alındı. ROUGE COCO\'nun 24 renginde Arthur, Adrienne, Roussy, Dimitri ve daha fazlasını bulacaksınız.', '2024-12-16 21:20:48', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw94b073ef/images/hi-res/SKU/SKU_4/318735_swatch.jpg', NULL, NULL),
(15, 'LES 4 OMBRES', 'Far Paleti', 'CHANEL', 2450.00, 400, 'Yaratıcılığın hizmetinde, en iyi yenilikleri içeren dört far paleti. Optimize edilmiş formülü, rengi maksimuma çıkarmak için yumuşaklık ve uygulama kolaylığını birleştirir: gün boyunca sadık, aydınlık, homojen. Gölgeler çeşitli efektlerde mevcuttur: mat, saten, yanardöner veya metalik.\r\nBüyük aynalı, siyah lake, pratik ve göçebe bir kasa.\r\nSonuç: Dört göz farı sonsuza kadar modüle edilebilir ve doğal veya yoğun bir görünüm, badem veya dumanlı bir görünüm çizebilir.\r\nRenk ve makyaj efektleri sunan bir formül.\r\nDaha geniş bir etki ve yoğunluk yelpazesine izin veren, uzun süre kalıcı saf pigmentlerin olağanüstü konsantrasyonu.\r\nAşağıdakiler için bir jelleşme sistemi ve polimerler ve küresel tozların bir karışımı:\r\n- yumuşak, kremsi ve kaygan bir doku\r\n- birbiriyle mükemmel uyum sağlayan tonlar\r\n- homojen bir makyaj sonucu\r\nKolay uygulama ve anında yoğun kapsama için bir üretim süreci', '2024-12-16 21:22:11', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwdc405603/images/hi-res/SKU/SKU_3791/284946_swatch.jpg', NULL, NULL),
(16, 'LES BEIGES', 'Fondöten', 'CHANEL', 2300.00, 400, 'Cilde tüm gün doğada geçirilmiş gibi canlılık veren, aydınlık doğal görünümlü fondöten. İnce, ipeksi dokusu zahmetsizce uygulanır ve adeta ikinci cilt gibi bir doku oluşturur. Işık yansıtan pudra ve pigment karışımı cildin daha pürüzsüz görünmesini sağlar. Cilt eşitsizliklerinin görünümü azalır, eşit bir ten görünümü yaratır. Ayarlanabilir kapatıcılığa sahip ve uzun süre kalıcı formülü ile cilde 12 saat* boyunca aydınlık görünüm sağlar. Formülü cildin kirlilik gibi çevresel faktörlerden korur. Nemlendirici içerikler ile zenginleştirilmiş formülü cilde anında konfor hissi sağlar ve günden güne nemlendirir.\r\nLES BEIGES HEALTHY GLOW FOUNDATION AND LONGWEAR her kadının mükemmel rengini bulabilmesi için 35 tonda mevcuttur. 21 kadında klinik deneylerle test edilmiştir. ', '2024-12-16 21:24:00', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwb887753b/images/hi-res/SKU/SKU_1679/520519_swatch.jpg', NULL, NULL),
(17, 'JOUES CONTRASTE', 'Allık', 'CHANEL', 2150.00, 450, 'CHANEL\'in efsanevi makyajı. Cildi güçlendirmek, yüzü yapılandırmak veya iyi bir etki vermek için gerekli olan temel adımdır. Bir pudra dokusu, yumuşak, ipeksi. Gün boyunca rötuşları kolaylaştıran göçebe bir vaka. Sonuç: ten rengini artırmak için bir renk ve ışıltı. JOUES CONTRASTE teknolojisinden yararlanan, pişirilmiş allık. Bu CHANEL özel üretim süreci, özellikle yumuşak, ince ve ipeksi bir doku sağlamakta. Rahat bir uygulama için yağsızdır ve solmaz.', '2024-12-16 21:25:37', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwc442597c/images/hi-res/SKU/SKU_6/422276_swatch.jpg', NULL, NULL),
(18, 'ROUGE ALLURE', 'Ruj', 'CHANEL', 1900.00, 500, 'Açık ve ışıltılı bir ruj. Ultra ince bir doku, eriyen ve ikinci bir cilt, yoğun tonlardan oluşan bir palet. İddialı ve cesur bir tarz.\r\nSonuç: derin, ışıltılı ve saten bir makyaj. İlk uygulamadan itibaren mükemmel tutuş.\r\nRenklerin hizmetinde bir formül:\r\n- İlk uygulamadan itibaren yoğun renkler için yüksek konsantrasyonda ultra ince pigmentler\r\n- uzun süreli kullanım ve optimum renk koruması için yeşil çay, tatlı badem yağı ve yapışkan bir ester karışımı\r\n- Pürüzsüz, nemli ve korunmuş dudaklar için tatlı badem yağı, sappan ağacı ve yeşil çay.', '2024-12-16 21:27:18', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwabe79daa/images/hi-res/SKU/SKU_2/252999_swatch.jpg', NULL, NULL),
(19, 'YSL Loveshine', 'Ruj', 'YVES SAINT LAURENT', 1960.00, 400, 'Ne İşe Yarar: YSL Loveshine Ruj, bir rujun rengini, bir dudak yağının kayganlığını sunar. Dudakları nemlendirmek için 6 besleyici yağ içeren ruj-yağ karışımına sahiptir. Kremsi yapısı, yoğunlaştırılabilir formülü ile 24 saate kadar nemlendirme sağlar. \r\n\r\nFormül Türü: Ruj / Dudak Yağı \r\n\r\nFaydaları: Nemlendirici, Uzun Süre Kalıcı\r\n\r\n Öne Çıkan İçerikler:\r\n\r\n-%60 İmza Yağ Bazı: Pürüzsüz bir kayma ve nemlendirici bir his sağlar.\r\n\r\n-İncir Özü: Hassas/çatlamış dudaklar için formülü uyumlu hale getirmek amacıyla Fas, Marakeş\'teki Yves Saint Laurent\'in Ourika Topluluk Bahçesi\'nden elde edilir. \r\n\r\nİçerik Açıklamaları: Paraben ve mineral yağ içermez. \r\n\r\nAyrıca Bilmeniz Gerekenler: Bir rujun rengini, bir dudak yağının kayganlığıyla deneyimleyin. Artık altı besleyici yağ içeriği ve şık gümüş renkli görünümüyle bu ikonik formül, dudaklarınızda 24 saate kadar nemlendirme ve koruma sağlar. Dudaklarınızın üzerinde erir, temas halinde nemlendirir ve zamanla dudaklarınızın daha yumuşak ve daha nemli hissetmesini sağlar. Günlük doğal tonlardan leylak rengi ve pembe dokunuşlarına kadar uzanan geniş bir renk yelpazesinden seçim yapın. \r\n\r\nKlinik Sonuçlar: 120 kadın üzerinde yapılan bir tüketici testinde sonuçlar şunları göstermiştir:\r\n\r\n-24 saate kadar nemlendirme ve kuruluğa karşı koruma\r\n\r\n-Dudaklarda anında daha pürüzsüz ve nemli hissiyat\r\n\r\n-14 gün sonra dudaklarda daha yumuşak ve nemli hissiyat', '2024-12-16 22:03:17', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw1730ff2c/images/hi-res/SKU/SKU_5208/718468_swatch.jpg', NULL, NULL),
(20, 'Lash Clash - Hacim Veren Maskara', 'Maskara', 'YVES SAINT LAURENT', 2000.00, 400, 'Ne İşe Yarar: Yoğun renk ve sıra dışı hacim için büyük boy fırçası ve parfüm içermeyen, paraben içermeyen formülüyle gün boyu kalıcılık sağlayan couture bir maskara.\r\nİçerik Açıklamaları: Bu ürün vegan olup, paraben içermez ve %1\'den az sentetik koku içerir.\r\nAyrıca Bilmeniz Gerekenler: Bu hacim veren maskara, 24 saate kadar kalıcı, bulaşmaya dayanıklı yapısıyla pigmentli renk ve %200 daha fazla hacim sağlar. Büyük fırçası ve formülü, her bir kirpiğe tek tek ulaşarak bir ila beş uygulamada farklı hacim seviyeleri elde etmenizi sağlar. Şık bir ambalaja sahip olan Lash Clash, olmazsa olmaz bir lüks üründür.\r\nKlinik Sonuçlar: 100 kadın üzerinde yapılan bir öz değerlendirme testinde:\r\n-%96\'sı ürünün 24 saate kadar kalıcı olduğunu söyledi\r\n-%90\'ı fırçanın formülü kirpik diplerinden uçlarına eşit şekilde dağıttığını söyledi\r\n-%93\'ü fırçanın en kısa kirpikler dahil tüm kirpiklere ulaştığını söyledi Bu ürün Allure Best of Beauty ödülüne layık görülmüştür.', '2024-12-16 22:05:33', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwdef34695/images/hi-res/SKU/SKU_2967/580785_swatch.jpg', NULL, NULL),
(21, 'Couture Mini Clutch - Yüksek Pigmentli Göz Farı Paleti', 'Far Paleti', 'YVES SAINT LAURENT', 3600.00, 400, 'Ne İşe Yarar: Gün boyu kalıcı, yüksek pigmentli, yumuşak ve yağ bakımından zengin dört far içeren özel tasarım bir far paleti. \r\n\r\nÖne Çıkan İçerikler:\r\n\r\n-Kahve Çekirdeği, Tatlı Badem ve Dikenli İncir Yağları: Yumuşak bir doku ve kalıcı ancak nazik bir kalıcılık sağlar. \r\n\r\nİçerik Açıklamaları: Formaldehitler, formaldehit salıcı ajanlar, retinil palmitat, oksibenzon, kömür katranı, triklokarban, triklosan içermez ve %1\'den az sentetik koku içerir. \r\n\r\nAyrıca Bilmeniz Gerekenler: Zarif, kapitone bir paletle sunulan, iddialı ve sofistike görünümler için dört lüks renk tonuna sahip özel tasarım bir far paleti. Saten, mat, metalik ve ışıltılı bitişler, gün boyu kalıcı, pürüzsüz bir uygulama sağlar. Değerli yağlarla zenginleştirilmiş formülü ciltte yumuşak bir his bırakır ve yüksek pigmentasyonla kolayca uygulanır. Farlar, doğal, makyajsız bir görünüm, soft glam görünümler veya ikonik Yves Saint Laurent gözleriyle göz alıcı ve boyutlu bir ifade için kolayca dağıtılabilir. Formüldeki dikenli incir yağı, Fas\'ın Marakeş şehrindeki Yves Saint Laurent Ourika Topluluk Bahçesi\'nden elde edilmektedir.', '2024-12-16 22:07:47', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dwc21b70d8/images/hi-res/SKU/SKU_4136/671552_swatch.jpg', NULL, NULL),
(22, 'All Hours - Uzun Süre Kalıcı Aydınlık Mat Bitişli Fondöten', 'Fondöten', 'YVES SAINT LAURENT', 2750.00, 400, 'Ne İşe Yarar: 24 saate kadar tam kapatıcılık sağlayan, ciltte hafif bir his sağlayan ve kusursuz görünen bir cilt için ışıltılı mat bir bitiş sunan, cilde nefes aldıran, likit bir fondöten.\r\nKapatıcılık: Tam\r\nBitiş: Mat\r\nFormül: Likit\r\nCilt Tipi: Normal, Kuru, Karma ve Yağlı\r\nSPF: SPF 30\r\nÖne Çıkan İçerikler:\r\nHyaluronik Asit: Nemlendirme özellikleriyle bilinir.\r\nYasemin Yaprağı: Aydınlatıcı özellikleriyle bilinir.\r\nBitkisel Taurin: Besleyici özellikleriyle bilinir.\r\nAyrıca Bilmeniz Gerekenler: Bu yenilikçi formül, makyaj yokmuş gibi hissettiren tam kapatıcılık için pürüzsüz bir şekilde uygulanır. Bulaşmaya dayanıklı, suya dayanıklı ve ısıya dayanıklıdır. Hyaluronik asit ve yasemin yaprağı ile zenginleştirilmiş bu fondöten, günden güne cilt bakım faydaları sağlar. Sadece 2 hafta sonra cilt daha yumuşak, pürüzsüz ve nemli hisseder.\r\nKlinik Sonuçlar: Bir tüketici testi(1) esas alınarak:\r\n-%91\'i kapatıcılığın 24 saat sürdüğünü kabul ediyor.\r\n-%83\'ü ürünün ciltte 24 saat boyunca nefes alan bir his bıraktığını kabul ediyor.\r\n%82\'si rengin 24 saat boyunca aynı kaldığını kabul ediyor.\r\n-%85\'i cildin 24 saat boyunca rahat hissettiğini kabul ediyor.\r\n%85\'i cildin 24 saat boyunca sağlıklı göründüğünü kabul ediyor.\r\n-Sadece 2 haftalık günlük kullanımdan sonra cilt daha yumuşak, pürüzsüz, nemli hissediyor.(1)\r\n\r\n(1)Tüketici testi, 111 kadın.', '2024-12-16 22:10:27', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw007b82f1/images/hi-res/SKU/SKU_3328/616887_swatch.jpg', NULL, NULL),
(23, 'MAKE ME BLUSH', 'Allık', 'YVES SAINT LAURENT', 2100.00, 400, 'YSL Beauty\'den Make Me Blush - Allık özel tonları ile gerçek renklerinizi ortaya çıkarın. Arttırılabilir kapatıcılığı ve ağırlık yapmayan dokusu ile yanaklarınızı isteğinize göre hafif veya yoğun şekilde renklendirin. Kolayca dağılan likit formülü ile kolay uygulama sağlar ve yanaklarınızda 12 saat kalıcı çarpıcı renkler sunar.', '2024-12-16 22:12:27', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw75a5594a/images/hi-res/SKU/SKU_5546/739158_swatch.jpg', NULL, NULL),
(24, 'Almost Lipstick Black Honey', 'Ruj', 'CLINIQUE', 980.00, 108, 'Clinique\'in #1 Numaralı TikTok Fenomeni Black Honey.\r\n\r\nİkonik Ruj.\r\n\r\nKendine has eşsiz rengi ve besleyici dokusuyla dudaklara hafif parlak ve doğal bir renk kazandırır. Şeffaf bitişi ve balm yapısıyla aynaya ihtiyaç duymadan kolayca uygulanır.\r\n\r\nHerkese Yakışan Sihirli Renk.\r\n\r\nEtkileyici siyah rengine aldanma. Bu sihirli ruj tüm cilt tonlarına, dudak şekillerine ve her yaşa uyum gösterir.\r\n\r\nİnternetin en sevilen ruju.\r\n\r\nSürüldüğü anda herkesin dudaklarını harika gösteren şeffaf rengiyle pek çoğumuzun günlük makyajının vazgeçilmezi. Ama artık aynı zamanda bi TikTok fenomeni!\r\n\r\nBlack Honey’nin ikonik stilini yakalamak için tek yapman gereken, hayranları stoklarını bitirmeden önce ona sahip olman!', '2024-12-20 16:38:07', 'https://www.sephora.com.tr/on/demandware.static/-/Sites-masterCatalog_Sephora/default/dw268cffc7/images/hi-res/SKU/SKU_2/235847_swatch.jpg', NULL, NULL),
(27, 'Easy Bake Loose - Sabitleyici Pudra', 'Pudra', 'HUDA BEAUTY', 2169.00, 500, 'Aynı formül, yeni görünüm. Eski ya da yeni ambalajı alabilirsiniz, her ikisi de aynı ikonik tozu içerir. Huda Beauty\'nin amiral gemisi ürünü Easy Bake toz pudra, kusursuz görünümün sırrıdır. Huda için Easy Bake, 10 saate kadar kalıcı kusursuz makyajın en önemli adımıdır. Ultra rafine pigmentler sayesinde bu pudra hafif, ipeksi, komedojenik olmayan bir dokuya sahiptir ve cilde hafif bir ışıltı sağlar. Easy Bake\'in çok az bir miktarı, parlamayı kontrol etmek, depigmentasyon alanlarını düzeltmek ve ince çizgilere yerleşmeden veya solmadan yüz hatlarını vurgulamak için cilt üzerinde mat bir yüzeye sahip yarı saydam bir örtü bırakır! ETKİSİ: Easy Bake\'in hafif dokusu, makyajı parlamadan yerinde tutmak için her ürünle kusursuz bir şekilde uyum sağlar. Bu pudra, parlamayı giderir, doğal bir görünüm sağlar ve çok uzun süre dayanır.', '2025-05-14 20:37:21', 'https://media.sephora.eu/content/dam/digital/pim/published/H/HUDA%20BEAUTY/746552/359193-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(28, 'Diamond Bomb All-Over Diamond Veil - Aydınlatıcı', 'Aydınlatıcı', 'FENTY BEAUTY', 2229.00, 500, 'İnanılmaz elmas pudrası etkisiyle cildi aydınlatır. Diamond Bomb, yüzünüzü ve vücudunuzu Rihanna gibi, kristallerle kaplayan parlak 3D formülü sayesinde simlerin tüm gücünü ortaya çıkarır.\r\n\r\nFenty Beauty ile göz alıcı bir şekilde parlayın. Diamon Bomb ciltte anında eriyen, yumuşacık eşsiz bir jöle-toz formüle sahiptir. Bu aydınlatıcı, her türlü cildi kusursuzlaştırarak, mükemmel bir son dokunuş için parlaklık sunar.', '2025-05-14 20:42:24', 'https://media.sephora.eu/content/dam/digital/pim/published/F/FENTY%20BEAUTY/443947/26103-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(29, 'Cheeks Out Freestyle Cream Blush - Allık', 'Allık', 'FENTY BEAUTY', 1449.00, 500, 'Cheeks Out Freestyle Cream Blush, yaz makyajınızı yansıtmak için cildinizi anında göz alıcı bir tazelik ile süslüyor!\r\nHer cilt tonuna genç bir ışıltı sunmak için tasarlanmış çeşitli renk tonlarıyla kullanımı kolaydır.\r\n\r\nTüm cilt tonlarını çok daha çekici ve alımlı gösterebilmek için Rihanna tarafından tasarlanan 10 renk tonu; renk kartelası üzerinde çok canlı görünebilir ancak uygulandığında adeta eriyen, ciltle bütünleşen ve parmak uçlarıyla rahatça uygulanabilen bir yapıya sahiptir. ', '2025-05-14 20:46:17', 'https://media.sephora.eu/content/dam/digital/pim/published/F/FENTY%20BEAUTY/510657/190053-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(30, 'Killawatt Foil Freestyle Highlighter - Aydınlatıcı', 'Aydınlatıcı', 'FENTY BEAUTY', 2149.00, 500, 'Killawatt\'tan daha iyisini yapamayacağımızı mı sandın?\r\nKillawatt Foil sahneye giriyor ve orijinal olarak aynı kremsi dokuyu sunuyor.\r\nYeni ultra parlak metalik bir yapıya sahip.\r\nKillawatt Foil parlak renk yelpazesi sayesinde yüzünüze, gözlerinize, köprücük kemiğinize, ... Işık getirmek istediğiniz her yere mükemmel bir metalik dokunuş katın.\r\nKillawatt Foil, cildinizde anında eriyen ve zahmetsizce yayılan hafif, uzun ömürlü, hibrit krem ​​tozu formülü sayesinde cildinizi gün batımından sonra iyi aydınlatıyor.', '2025-05-14 20:54:14', 'https://media.sephora.eu/content/dam/digital/pim/published/F/FENTY%20BEAUTY%20BY%20RIHANNA/495141/121194-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(31, 'Icy Nude Eyeshadow Palette - Far Paleti', 'Far Paleti', 'HUDA BEAUTY', 3939.00, 500, 'En yeni koleksiyonumuzla donmuş efekti benimseyin!\r\n\r\nBuzlu görünümün hayranı olun ve Icy Nude göz farı paletimizle buz gibi bakışlar trendini takip edin. Buzlu gümüş tonlarını havalı bordoyla kombinleyerek kuralları çiğnemekten çekinmeyin.\r\n\r\nBu palet, kendinden emin, kendine güvenen görünümler yaratmak için 18 ultra pigmentli göz farı tonu ve yenilikçi dokular içerir.', '2025-05-14 20:56:51', 'https://media.sephora.eu/content/dam/digital/pim/published/H/HUDA%20BEAUTY/739400/357629-media_swatch.jpg?scaleWidth=undefined&scaleHeight=undefined&scaleMode=undefined', NULL, NULL),
(32, 'Creamy Obsessions Grey - Far Paleti', 'Far Paleti', 'HUDA BEAUTY', 1809.00, 500, 'Yumuşak, günlük hayata uygun gözlerden son derece göz alıcı görünümlere kadar zamana meydan okuyan bir görünüm yelpazesi yaratmak için kusursuz bir şekilde uygulanan, yenilikçi, yüksek pigmentli toz metalik, mermer görünümlü ve krem ​​​​göz farlarını içeren iki çok yönlü, tek renkli kremsi palet!', '2025-05-14 20:58:32', 'https://media.sephora.eu/content/dam/digital/pim/published/H/HUDA%20BEAUTY/715086/341616-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(33, 'Dior Addict Lip Glow - Dudak Balmı', 'Ruj', 'DIOR', 1990.00, 500, 'Hem dudak bakımı hem de makyaj için kullanılabilen ve bir kült haline gelen Dior lip balm, kişiye özel renk ve gelişmiş ışıltı için dudakların pH seviyesiyle etkileşime giren bir formüle sahiptir.', '2025-05-14 21:00:59', 'https://media.sephora.eu/content/dam/digital/pim/published/D/DIOR/749150/363674-media_swatch.jpg?scaleWidth=undefined&scaleHeight=undefined&scaleMode=undefined', NULL, NULL),
(34, 'Dior Addict Shine Lipstick - Ruj', 'Ruj', 'DIOR', 2125.00, 500, 'Dior\'un dudak parlatıcısı Dior Addict yeniden doldurulabilir, ultra couture bir kutuda yeniden keşfediliyor. Şimdi %90 doğal kaynaklı içeriklerden oluşan formülü dudakları 24 saat** boyunca nemlendiriyor ve 6 saat*** boyunca parlak tutuyor.\r\n\r\nYumuşak ve ultra kremsi dokusu dudaklarda kayarak anında rahatlık sağlıyor. Yasemin mumu ve bitkisel bazlı yağlarla zenginleştirilmiş Dior Addict ruj, dudakları güzelleştirir ve çarpıcı renklere büründürür.', '2025-05-14 21:03:05', 'https://media.sephora.eu/content/dam/digital/pim/published/D/DIOR/583981/270707-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(35, 'Diorshow Iconic Overcurl - Maskara', 'Maskara', 'DIOR', 2035.00, 500, '24 saatlik Diorshow Iconic Overcurl maskara, baş döndürücü kıvrımlara ve hacme sahip kirpiklerle muhteşem göz makyajını ortaya çıkarır.\r\nDiorshow Iconic Overcurl maskara, kirpik eğrisine 24 saat süre verir. \r\n\r\nPamuk nektarı ile zenginleştirilmiş formül, kirpiklere koruma, yumuşaklık ve parlaklık kazandırır: göz makyajı bakımı ve hacmi birleştirir, kirpikler daha uzun görünür ve gözler büyütülür.', '2025-05-14 21:06:11', 'https://media.sephora.eu/content/dam/digital/pim/published/D/DIOR/689063/321427-media_swatch.jpg?scaleWidth=undefined&scaleHeight=undefined&scaleMode=undefined', NULL, NULL),
(36, 'Blushing Blush - Pudra Allık', 'Allık', 'CLINIQUE', 1900.00, 500, 'İpeksi formül, doğal bir görünüm için yanaklarda eşit olarak yayılır. Yanaklarınızda taze, canlı bir görünüm için özel olarak tasarlanmış fırçası ile uygulama yapabilirsiniz. Uzun süre etkili, doğal tonlar. Yağsızdır.', '2025-05-14 21:12:30', 'https://media.sephora.eu/content/dam/digital/pim/published/C/CLINIQUE/132393/119236-media_swatch.jpg?scaleWidth=undefined&scaleHeight=undefined&scaleMode=undefined', NULL, NULL),
(37, 'Soft Pinch - Likit Allık', 'Allık', 'RARE BEAUTY', 1539.00, 499, 'Rare Beauty\'nin Soft Pinch likit allığı ile cildinizde yumuşak ve sağlıklı bir bitiş elde edin. Hafif yapısı sayesinde kolayca dağılan ve kat kat uygulanabilen bu sıvı allık, yoğun pigmentleriyle gün boyu kalıcılığını korur. Mat ve ışıltılı seçenekleri sunan ultra hafif formülü, cildinize doğal bir bitiş kazandırır. Kat kat uygulanabilir renkleriyle yumuşak ve  kusursuz bir renk etkisi yaratır.\r\n', '2025-05-14 21:16:36', 'https://media.sephora.eu/content/dam/digital/pim/published/R/RARE%20BEAUTY/577233/268485-media_swatch.jpg?scaleWidth=undefined&scaleHeight=undefined&scaleMode=undefined', NULL, NULL),
(38, 'Shape Tape™ - Kapatıcı', 'Kapatıcı', 'TARTE', 1759.00, 500, 'Tam kapatıcılık, doğal mat kapatıcı\r\n\r\nEn çok satan tarte™ ürünü, shape tape™ kapatıcı!\r\nTam kapatıcı formülü ile 16 saat kusursuz kalıcılık\r\nPürüzsüz ve aydınlık hale getirerek gözleri kalkık gösterir\r\nKırışmayan formülü ile cakey görünmez veya çizgilere yerleşmez\r\nTape technology™ ince çizgilerin ve kırışıklıkların görünümünü filtreler ve pürüzsüzleştirir\r\nJumbo speed smoother™ ile kolay uygulanır', '2025-05-14 21:21:35', 'https://media.sephora.eu/content/dam/digital/pim/published/T/TARTE/451695/112636-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL),
(39, 'Xenon Palette - Far Paleti', 'Far Paleti', 'NATASHA DENONA', 3939.00, 500, 'Natasha\'nın heyecan verici XENON Göz Farı Paleti, Natasha\'nın ünlü formüllerinden oluşturulan benzersiz dumanlı tonlara ve dokulara sahiptir.\r\n\r\nMerakla beklenen Natasha Denona XENON Göz Farı Paleti, her gün için en yeni soğuk tonlu palettir. Bu 15 renk tonundan oluşan fantezi, dünya çapında kabul gören MINI XENON PALETTE\'nin renk uzantısıdır ve imza niteliğindeki dumanlı görünümü oluşturmak için bir dizi yoğun pigment içerir. Klasik kedi gözünden yumuşaktan şehvetliye kadar canlı griler, ışıltılı gümüşler, buzlu pembeler ve nötr formüller, istenen her görünümü kolayca tamamlar.', '2025-05-14 21:29:42', 'https://media.sephora.eu/content/dam/digital/pim/published/N/NATASHA%20DENONA/690511/324540-media_swatch.jpg?scaleWidth=585&scaleHeight=585&scaleMode=fit', NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `yorum_id` int(11) NOT NULL,
  `urun_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `puan` int(11) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `durum` enum('Onaysız','Onaylı') DEFAULT 'Onaysız'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `sepet`
--
ALTER TABLE `sepet`
  ADD PRIMARY KEY (`sepet_id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`yorum_id`),
  ADD KEY `urun_id` (`urun_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `sepet`
--
ALTER TABLE `sepet`
  MODIFY `sepet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `yorum_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD CONSTRAINT `yorumlar_ibfk_1` FOREIGN KEY (`urun_id`) REFERENCES `urunler` (`urun_id`),
  ADD CONSTRAINT `yorumlar_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanicilar` (`kullanici_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
