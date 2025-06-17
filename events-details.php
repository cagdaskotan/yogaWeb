<?php
require_once("env/class.db.php");
require_once("admin/core/events/class.events.php");
require_once("admin/core/events/class.articles.php");

$slug = $_GET['slug'] ?? '';
$event = $events->getBySlug($slug);
$db = new dbClass();
$events = new Events();
$articles = new EventArticles();

// Etkinliği çek
$event = $db->object($db->q("SELECT * FROM events WHERE slug = '{$db->rescape($slug)}' LIMIT 1"));
if (!$event) {
    echo "Etkinlik bulunamadı.";
    exit;
}

$article = $articles->getArticlesByEventId($event->id)[0] ?? null;
$imgSrc = 'assets/images/null-images/default.jpg';

if ($article && preg_match('/<img[^>]+src="([^">]+)"/i', $article->article, $imgMatch)) {
    $imgSrcCandidate = str_replace('../', '', $imgMatch[1]);
    if (!empty($imgSrcCandidate)) {
        $imgSrc = $imgSrcCandidate;
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
    <base href="/">
    <meta charset="utf-8">
    <title><?= htmlspecialchars($event->title) ?> | Etkinlik Detayları</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CPrata" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/font/demo-files/demo.css">
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <style>
        .btn-style-3:hover {
            background-color: #45b29d;
        }
    </style>
</head>
<body>

<?php require_once("layouts/header.php"); ?>

<div class="breadcrumbs-wrap">
  <div class="container">
    <h1 class="page-title"><?= htmlspecialchars($event->title) ?></h1>
        <ul class="breadcrumbs">
            <li><a href="etkinlikler">Etkinlikler</a></li>
            <li><?= htmlspecialchars($event->title) ?></li>
        </ul>
  </div>
</div>

<div id="content" class="page-content-wrap">
  <div class="container">
    
    <div class="content-element">
      
        <!-- Görsel -->
        <div style="max-width: 900px; margin: 0 auto 30px auto;">
        <a href="<?= $imgSrc ?>" data-fancybox>
            <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($event->title) ?>" style="width: 100%; height: auto; border-radius: 8px; display: block;">
        </a>
        </div>

        <!-- Tarih -->
        <div style="max-width: 900px; margin: 0 auto 20px auto;">
            <div class="our-info">
                <div class="info-item">
                    <i class="licon-clock3"></i>
                    <div class="wrapper">
                        <?php
                        $months = [
                        'January' => 'Ocak',
                        'February' => 'Şubat',
                        'March' => 'Mart',
                        'April' => 'Nisan',
                        'May' => 'Mayıs',
                        'June' => 'Haziran',
                        'July' => 'Temmuz',
                        'August' => 'Ağustos',
                        'September' => 'Eylül',
                        'October' => 'Ekim',
                        'November' => 'Kasım',
                        'December' => 'Aralık'
                        ];

                        $startDate = date("d F Y", strtotime($event->start_date));

                        if (!empty($event->end_date) && $event->end_date !== '0000-00-00') {
                            $endDate = date("d F Y", strtotime($event->end_date));
                        } else {
                            $endDate = null;
                        }

                        foreach ($months as $en => $tr) {
                            $startDate = str_replace($en, $tr, $startDate);
                            if ($endDate) {
                                $endDate = str_replace($en, $tr, $endDate);
                            }
                        }

                        ?>
                        <?php if ($endDate): ?>
                            <span><strong><?= $startDate ?> - <?= $endDate ?></strong></span>
                        <?php else: ?>
                            <span><strong><?= $startDate ?></strong></span>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Açıklama -->
        <div class="event-description" style="max-width: 900px; margin: 0 auto; font-size: 16px; line-height: 1.8; background: #fff; padding: 30px 40px; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.05);">
            <?= $article ? preg_replace('/<img[^>]*>/', '', $article->article) : "<em>Etkinliğe ait açıklama henüz eklenmemiş.</em>" ?>
        </div>

        <!-- Geri dön -->
        <div style="margin-top: 30px;">
            <a href="etkinlikler" class="btn btn-style-3">← Tüm Etkinliklere Dön</a>
        </div>

    </div>

  </div>
</div>

<?php require_once("layouts/footer.php"); ?>

<script src="assets/js/libs/jquery.modernizr.js"></script>
<script src="assets/js/libs/jquery-2.2.4.min.js"></script>
<script src="assets/js/libs/jquery-ui.min.js"></script>
<script src="assets/js/libs/retina.min.js"></script>
<script src="assets/plugins/jquery.scrollTo.min.js"></script>
<script src="assets/plugins/jquery.localScroll.min.js"></script>
<script src="assets/plugins/mad.customselect.js"></script>
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="assets/plugins/jquery.queryloader2.min.js"></script>
<script src="assets/plugins/owl.carousel.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>