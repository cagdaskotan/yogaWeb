<?php
require_once("env/class.db.php");
require_once("admin/core/products/class.products.php");
require_once("admin/core/contact/class.contact.php");

$contact = new Contact();
$contactData = $contact->get(1);

$products = new Products();
$slug = $_GET['slug'] ?? '';
$product = $products->getBySlug($slug);

if (!$product) {
    die("<h2 style='text-align:center;'>Ürün bulunamadı.</h2>");
}
?>

<!doctype html>
<html lang="tr">
<head>
    <base href="/">
    <meta charset="utf-8">
    <title><?= htmlspecialchars($product->name) ?> - Ürün Detayları</title>
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

</head>

<body>
<div class="loader"></div>
<div id="wrapper" class="wrapper-container">
    <?php require_once("layouts/header.php"); ?>

    <div class="breadcrumbs-wrap">
        <div class="container">
            <h1 class="page-title"><?= htmlspecialchars($product->name) ?></h1>
            <ul class="breadcrumbs">
                <li><a href="urunler">Ürünler</a></li>
                <li><?= htmlspecialchars($product->name) ?></li>
            </ul>
        </div>
    </div>

    <div id="content" class="page-content-wrap">
        <div class="container wide3">

            <div class="row align-items-start mb-5">
                <div class="col-md-6 text-center">
                    <a href="<?= htmlspecialchars($product->image) ?>" data-fancybox>
                        <img src="<?= htmlspecialchars($product->image) ?>" alt="<?= htmlspecialchars($product->name) ?>" style="width:80%; height:auto; object-fit:cover; border-radius:12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    </a>
                </div>
                <div class="col-md-6">
                    <div style="margin-bottom: 25px;">
                        <?php if (!empty($product->category_name)): ?>
                            <span style="
                                display: inline-block;
                                background-color: #45b29d;
                                color: white;
                                padding: 5px 12px;
                                border-radius: 16px;
                                font-size: 13px;
                                margin-bottom: 8px;
                            ">
                                <?= htmlspecialchars($product->category_name) ?>
                            </span>
                        <?php endif; ?>

                        <h2 style="
                            font-size: 28px;
                            font-weight: 600;
                            margin: 10px 0 10px 0;
                            color: #222;
                        ">
                            <?= htmlspecialchars($product->name) ?>
                        </h2>

                        <p style="
                            font-size: 24px;
                            color: #e883ae;
                            font-weight: bold;
                            margin: 0;
                        ">
                            <?= htmlspecialchars($product->price) ?> TL
                        </p>
                    </div>


                    <?php if (!empty($product->description)): ?>
                        <div class="product-description" style="font-size:16px; line-height:1.6; color:#444;">
                            <?= nl2br(htmlspecialchars($product->description)) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="content-element3 text-center" style="max-width: 600px; margin: 60px auto 0 auto;">
                <h4 class="section-title mb-3">Nasıl Satın Alınır?</h4>
                <p style="margin-bottom: 30px;">Aşağıdaki bilgiler aracılığıyla bizimle iletişime geçerek bu ürünü satın alabilirsiniz.</p>

                <div class="contact-links">
                    <!-- Konum -->
                    <a href="iletisim">
                        <div class="contact-icon-box">
                            <i class="icon-location"></i>
                            <div>Konum</div>
                        </div>
                    </a>

                    <!-- Mail -->
                    <a href="mailto:<?= $contactData->email ?>">
                        <div class="contact-icon-box">
                            <i class="icon-mail"></i>
                            <div>E-Posta</div>
                        </div>
                    </a>

                    <!-- Telefon -->
                    <?php
                    $whatsAppNumber = str_replace(['+', ' '], '', $contactData->phone);
                    ?>
                    <a href="https://wa.me/<?= $whatsAppNumber ?>" target="_blank">
                        <div class="contact-icon-box">
                            <i class="icon-phone"></i>
                            <div>WhatsApp</div>
                        </div>
                    </a>
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
<script src="assets/plugins/mad.customselect.js"></script>
<script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="assets/plugins/jquery.queryloader2.min.js"></script>
<script src="assets/plugins/owl.carousel.min.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>