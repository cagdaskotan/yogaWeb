<?php

require_once(__DIR__ . "/env/class.db.php");
require_once(__DIR__ . "/admin/core/lessons/class.lessons.php");
require_once(__DIR__ . "/admin/core/lessons/class.articles.php");

$subjectSlug = $_GET['slug'] ?? '';

$articleClass = new LessonsArticles();
$subject = $articleClass->getSubjectBySlug($subjectSlug);

$articles = $articleClass->getArticles($subject->id);
$firstArticle = $articles[0] ?? null;

// Eğer konu bulunamazsa 404
if (!$subject) {
    die("Konu bulunamadı.");
}

$lessonId = $subject->lesson_id ?? 0;
$lessonClass = new Lessons();
$lesson = $lessonClass->get($lessonId);

// Eğer ders bulunamazsa 404
if (!$lesson) {
    die("Ders bulunamadı.");
}

?>
<!doctype html>
<html lang="tr">
<head>
    <base href="/">
    <title><?= htmlspecialchars($lesson->title) ?> | <?= htmlspecialchars($subject->title) ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CPrata" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/font/demo-files/demo.css">
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= filemtime('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <style>

    </style>

</head>


<body>

<div class="loader"></div>
<div id="wrapper" class="wrapper-container">
    <?php require_once("layouts/header.php"); ?>

    <div class="breadcrumbs-wrap">
        <div class="container">
            <h1 class="section-title text-center">
                <?= $firstArticle ? htmlspecialchars($firstArticle->subject_title) : htmlspecialchars($subject->title) ?>
            </h1>
            <ul class="breadcrumbs">
                <li style="color: black;">Stüdyo Dersleri</li>
                <li><?= $firstArticle ? htmlspecialchars($firstArticle->lesson_title) : htmlspecialchars($lesson->title) ?></li>
            </ul>
        </div>
    </div>

    <div id="content" class="page-content-wrap">
        <div class="container">
            <div class="content-element6 text-center">
                <div class="single-post">

                    <?php if (!empty($lesson->image)): ?>
                        <div class="project mb-4">
                            <img src="<?= $lesson->image ?>" alt="<?= htmlspecialchars($lesson->title) ?>" style="max-width: 70%; height: auto;">
                        </div>
                    <?php endif; ?>

                    <div class="content-element2">
                        <?php if (!empty($articles)): ?>
                            
                            <?php foreach ($articles as $article): ?>
                                <?php
                                $content = $article->article;

                                $content = str_replace('../media/gallery/', 'media/gallery/', $content);

                                preg_match('/<img[^>]+>/i', $content, $imageMatch);
                                $imageHTML = $imageMatch[0] ?? '';

                                $imageHTML = preg_replace('/(width|height)="[^"]*"/i', '', $imageHTML);
                                $textContent = preg_replace('/<img[^>]+>/i', '', $content);
                                ?>
                                <div class="article-content mb-5">
                                    <div class="article-card" style="max-width: 900px; margin: 0 auto; border-radius: 16px; box-shadow: 0 8px 24px rgba(0,0,0,0.05); overflow: hidden; transition: all 0.3s ease; background-color: #fff;">
                                        <?php if ($imageHTML): ?>
                                            <div class="article-image">
                                                <?= str_replace('<img', '<img style="width: 100%; height: auto; display:block;"', $imageHTML) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="article-body" style="padding: 30px 40px; font-size: 16px; line-height: 1.8; color: #333;">
                                            <?= $textContent ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Henüz içerik eklenmedi.</p>
                        <?php endif; ?>
                    </div>

                    <div class="lesson-details-box mt-5" style="max-width: 900px; margin: 0 auto;">
                        <h4 class="section-title mb-4 text-center">Ders Detayları</h4>
                        <div class="details-grid">
                            <div class="detail-item">
                                <i class="icon-book"></i>
                                <div>
                                    <div class="label">Ders</div>
                                    <div class="value"><?= $firstArticle ? htmlspecialchars($firstArticle->lesson_title) : htmlspecialchars($lesson->title) ?></div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="icon-clipboard"></i>
                                <div>
                                    <div class="label">Konu</div>
                                    <div class="value"><?= $firstArticle ? htmlspecialchars($firstArticle->subject_title) : htmlspecialchars($subject->title) ?></div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <i class="icon-tag"></i>
                                <div>
                                    <div class="label">Kategori</div>
                                    <div class="value">Stüdyo Dersleri</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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
<script src="assets/plugins/mad.customselect.js"></script>
<script src="assets/plugins/jquery.queryloader2.min.js"></script>
<script src="assets/plugins/owl.carousel.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>