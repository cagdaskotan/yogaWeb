<?php
require_once("env/class.db.php");
require_once("admin/core/events/class.events.php");
require_once("admin/core/events/class.articles.php");

$events = new Events();
$allEvents = $events->all();

$articles = new EventArticles();

$selectedMonth = $_GET['month'] ?? '';

if (!empty($selectedMonth)) {
    $allEvents = array_filter($allEvents, function($e) use ($selectedMonth) {
        return date('m', strtotime($e->start_date)) === $selectedMonth && $e->is_active == 1;
    });
} else {
    $allEvents = array_filter($allEvents, fn($e) => $e->is_active == 1);
    usort($allEvents, function($a, $b) {
    return strtotime($a->start_date) - strtotime($b->start_date);
});

}

?>

<!doctype html>
<html lang="tr">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CPrata" rel="stylesheet">
	<title>Etkinlikler</title>
	<meta charset="utf-8">
	<meta name="author" content="">
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  
  <link rel="shortcut icon" href="assets/images/favicon.png">
	<link rel="stylesheet" href="assets/font/demo-files/demo.css">
  <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.css">
	<link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="assets/css/fontello.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
  <style>
    #detaylar:hover {
      background-color: #e883ae;
    }
    .entry {
      transition: box-shadow 0.3s ease;
    }

    .entry:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    @media (max-width: 768px) {
      .entry-responsive {
        flex-direction: column !important;
      }

      .entry-responsive .thumbnail-attachment {
        max-width: 100% !important;
        margin: 0 auto !important;
        text-align: center !important;
      }

      .entry-responsive .thumbnail-attachment img {
        width: 100% !important;
        height: auto !important;
        display: block !important;
        margin: 0 auto !important;
      }

      .entry-responsive .entry-body {
        padding: 20px !important;
      }
    }
  </style>
</head>

<body>

  <div class="loader"></div>

  <div id="wrapper" class="wrapper-container">

    <nav id="mobile-advanced" class="mobile-advanced"></nav>
    <?php
        require_once("layouts/header.php");
    ?>
    <div class="breadcrumbs-wrap">

      <div class="container">
        
        <h1 class="page-title">Etkinlikler</h1>

      </div>

    </div>
    
    <div id="content" class="page-content-wrap">

      <div class="container">
        
        <!-- <div class="content-element8">
          
          <div class="tribe-events-bar">
            
            <div class="row">

              <div class="col-lg-10">
                
                <form method="GET">
                  <div class="row">
                    <div class="col-sm-4 col-no-space mad-custom-select">
                      <select id="monthFilter" class="form-control" data-default-text="Tüm Aylar">
                        <option value="">Tüm Aylar</option>
                        <option value="01">Ocak</option>
                        <option value="02">Şubat</option>
                        <option value="03">Mart</option>
                        <option value="04">Nisan</option>
                        <option value="05">Mayıs</option>
                        <option value="06">Haziran</option>
                        <option value="07">Temmuz</option>
                        <option value="08">Ağustos</option>
                        <option value="09">Eylül</option>
                        <option value="10">Ekim</option>
                        <option value="11">Kasım</option>
                        <option value="12">Aralık</option>
                      </select>
                    </div>

                  </div>
                </form>
     
              </div>

            </div>
        
          </div>

        </div> -->

        <div class="entry-box list-type" id="eventList">
            
          <!-- - - - - - - - - - - - - - Entry - - - - - - - - - - - - - - - - -->
          <?php if (empty($allEvents)): ?>
            <div style="padding: 60px 20px; text-align: center; background-color: #f8f9fa; border-radius: 12px; margin-bottom: 40px;">
              <h2 style="font-size: 24px; color: #e883ae; margin-bottom: 10px;">Henüz Etkinlik Eklenmemiştir</h2>
              <p style="color: #555;">Yeni etkinlikleri yakında burada bulabilirsiniz.</p>
            </div>
          <?php endif; ?>

          <?php foreach ($allEvents as $event): ?>
            <?php
              if ($event->is_active != 1) continue;

              if (!empty($selectedMonth)) {
                $eventMonth = date("m", strtotime($event->start_date));
                if ($eventMonth !== $selectedMonth) continue;
              }

              $eventArticles = $articles->getArticlesByEventId($event->id);
              $article = $eventArticles[0] ?? null;

              $imgSrc = 'assets/images/null-images/default.jpg';

              if ($article && preg_match('/<img[^>]+src="([^">]+)"/i', $article->article, $imgMatch)) {
                  $imgSrcCandidate = str_replace('../', '', $imgMatch[1]);
                  if (!empty($imgSrcCandidate)) {
                      $imgSrc = $imgSrcCandidate;
                  }
              }

              $description = $article ? mb_substr(strip_tags($article->article), 0, 180) . '...' : 'Henüz açıklama eklenmemiş.';

              $months = [
                  'January' => 'Ocak', 'February' => 'Şubat', 'March' => 'Mart',
                  'April' => 'Nisan', 'May' => 'Mayıs', 'June' => 'Haziran',
                  'July' => 'Temmuz', 'August' => 'Ağustos', 'September' => 'Eylül',
                  'October' => 'Ekim', 'November' => 'Kasım', 'December' => 'Aralık'
              ];

              $startDate = date("d F Y", strtotime($event->start_date));
              $endDate = date("d F Y", strtotime($event->end_date));
              foreach ($months as $en => $tr) {
                $startDate = str_replace($en, $tr, $startDate);
                $endDate = str_replace($en, $tr, $endDate);
              }
            ?>

            <div class="entry entry-responsive" style="display: flex; gap: 0; align-items: stretch; background: #f8f9fa; border-radius: 10px; overflow: hidden; margin-bottom: 30px;">
                <div class="thumbnail-attachment" style="flex: 0 0 380px; max-width: 380px; text-align: center; margin: auto;">
                    <a href="<?= $imgSrc ?>" data-fancybox>
                      <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($event->title) ?>"
                          style="width: auto; max-width: 100%; height: auto; display: inline-block; border-radius: 5px;">
                    </a>
                </div>
                <div class="entry-body" style="flex: 1; padding: 30px;">
                    <h5 class="entry-title" style="margin-top: 0;">
                        <a href="etkinlik/<?= $event->slug ?>">
                            <?= htmlspecialchars($event->title) ?>
                        </a>
                    </h5>
                    <div class="our-info" style="margin-bottom: 15px;">
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
                                    <span><?= $startDate ?> - <?= $endDate ?></span>
                                <?php else: ?>
                                    <span><?= $startDate ?></span>
                                <?php endif; ?>
 
                            </div>
                        </div>
                    </div>
                    <p style="margin-bottom: 20px;"><?= $description ?></p>
                    <a href="etkinlik/<?= $event->slug ?>" class="btn btn-small" id="detaylar">Detaylar</a>
                </div>
            </div>

          <?php endforeach; ?>

        </div>

      </div>
      
    </div>
    <?php
        require_once("layouts/footer.php");
    ?>

  </div>

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
  <!-- <script>
  document.getElementById('monthFilter').addEventListener('change', function () {
      const selectedMonth = this.value;
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "events.php?month=" + selectedMonth, true);
      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4 && xhr.status === 200) {
              // HTML içinde etkinlik listesi bloğunu güncelle
              const parser = new DOMParser();
              const htmlDoc = parser.parseFromString(xhr.responseText, 'text/html');
              const newEvents = htmlDoc.getElementById('eventList');
              document.getElementById('eventList').innerHTML = newEvents.innerHTML;
          }
      };
      xhr.send();
  });
  </script> -->
</body>
</html>