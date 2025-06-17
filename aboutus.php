<?php
require_once("env/class.db.php");
require_once("admin/core/about/class.educations.php");
require_once("admin/core/about/class.about.php");

$edu = new AboutEducations();
$educations = $edu->all();

$about = new About();
$aboutData = $about->get();
$aboutData = $aboutData ?: (object)['title' => '', 'article' => ''];

$imagePath = '';
if (!empty($aboutData->article) && preg_match('/<img[^>]+src="([^">]+)"/i', $aboutData->article, $matches)) {
    $imagePath = str_replace('../', '', $matches[1]);
}

$articleText = !empty($aboutData->article)
    ? preg_replace('/<img[^>]*>/i', '', $aboutData->article)
    : '';

$hasContent = !empty(trim(strip_tags($articleText))) || count($educations) > 0;
?>

<!doctype html>
<html lang="tr">
<head>
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CPrata" rel="stylesheet">
	<title>Hakkımızda</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="shortcut icon" href="assets/images/favicon.png">
	<link rel="stylesheet" href="assets/font/demo-files/demo.css">
	<link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.css">
	<link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="assets/css/fontello.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
<div class="loader"></div>
<div id="wrapper" class="wrapper-container">
  <nav id="mobile-advanced" class="mobile-advanced"></nav>
  <?php require_once("layouts/header.php"); ?>

  <div class="breadcrumbs-wrap">
    <div class="container">
      <h1 class="page-title">Hakkımızda</h1>
    </div>
  </div>

  <div id="content" class="mt-2">
    <?php if (!$hasContent): ?>
      <div class="page-section">
        <div class="container">
          <div class="alert alert-warning text-center">
            Henüz hakkımızda bilgileri girilmemiştir.
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="page-section">
        <div class="container">
          <div class="row align-items-center <?= $imagePath ? '' : 'justify-content-center text-center' ?>">
            <div class="col-lg-6 col-md-12 <?= $imagePath ? '' : 'col-lg-8 col-md-10' ?>">
              <h3 class="section-title"><?= htmlspecialchars($aboutData->title) ?></h3>
              <div class="content-element3">
                <?= $articleText ?>
              </div>
            </div>
            <?php if ($imagePath): ?>
            <div class="col-lg-6 col-md-12">
              <div class="video-holder">
                <img style="border-radius: 50px;" src="<?= $imagePath ?>" alt="">
              </div>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="page-section-bg">
        <div class="container">
          <div class="content-element5">
            <h3 class="align-center">Öne Çıkan Eğitimleri</h3>
          </div>
          <div class="row">
            <?php
              $half = max(1, ceil(count($educations) / 2));
              $chunks = array_chunk($educations, $half);
              foreach ($chunks as $column):
            ?>
            <div class="col-lg-6 col-md-12">
              <div class="services">
                <?php foreach ($column as $item): ?>
                <div class="secvice-item">
                  <h5 class="service-title"><?= htmlspecialchars($item->description) ?></h5>
                  <p><?= htmlspecialchars($item->title) ?></p>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <div class="page-section">
        <div class="container">
          <div class="content-element5">
            <h3 class="align-center">Salondan Görseller</h3>
          </div>
          <div class="carousel-type-2">
            <div class="owl-carousel portfolio-holder" data-max-items="3" data-item-margin="30">
              <?php
              $dir = "media/about/";
              $files = scandir($dir);
              foreach($files as $file){
                if ($file != '.' && $file != '..' && !is_dir($dir . $file)) {
                  $path = $dir . $file;
              ?>
              <div class="project">
                <div class="project-image">
                  <img style="border-radius: 8px;" src="<?=$path?>" alt="">
                  <a href="<?=$path?>" class="project-link" data-fancybox="group"></a>
                </div>
              </div>
              <?php }} ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <?php require_once("layouts/footer.php"); ?>
</div>
<script src="assets/js/libs/jquery.modernizr.js"></script>
<script src="assets/js/libs/jquery-2.2.4.min.js"></script>
<script src="assets/js/libs/jquery-ui.min.js"></script>
<script src="assets/js/libs/retina.min.js"></script>
<script src="assets/plugins/jquery.scrollTo.min.js"></script>
<script src="assets/plugins/jquery.localScroll.min.js"></script>
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="assets/plugins/jquery.queryloader2.min.js"></script>
<script src="assets/plugins/owl.carousel.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
