<?php
require_once("env/class.db.php");
require_once("admin/core/contact/class.contact.php");

$contact = new Contact();
$contactData = $contact->get(1);
?>

<!doctype html>
<html lang="tr">

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CPrata" rel="stylesheet">

	<title>İletişim - Şehirde Yoga</title>
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
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

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
        
        <h1 class="page-title">İletişim</h1>

      </div>

    </div>

    <div id="content">

      <div class="page-section">
        
        <div class="container">
          
          <div class="row">
          
          <main id="main" class="col-lg-8 col-md-12">
            <div class="our-info content-element3">
              <div class="info-item">
                <i class="licon-clock3"></i>
                <span class="post" style="font-family: inherit;">Salonumuzun Konumu</span>
              </div>
            </div>
            <?php if (!empty($contactData->map_embed_code)) : ?>
              <div class="contact-map-wrapper" style="overflow:hidden; border-radius:16px;">
                <?= str_replace(['width="600"', 'height="450"'], ['width="100%"', 'height="500"'], $contactData->map_embed_code) ?>
              </div>
            <?php endif; ?>
          </main>

            <aside id="sidebar" class="col-lg-3 offset-lg-1 col-md-12">
              
              <div class="map-section">
                
                <div class="our-info vr-type">
                    
                  <div class="content-element3 text-center info-item" style="margin-top: 0;">
                    <i class="licon-clock3"></i>
                    <span class="post">İletişim Bilgilerimiz</span>

                    <div class="contact-links" style="display: flex; flex-direction: column; gap: 15px; align-items: flex-start;">
                      
                      <?php if (!empty($contactData->address)) : ?>
                        <div class="contact-box" style="display: flex; align-items: center; gap: 12px;">
                          <i class="icon-location" style="font-size: 18px; background-color: #fafafa; color: #e883ae; padding: 12px; border-radius: 8px; min-width: 40px; text-align: center;"></i>
                          <span><?= nl2br($contactData->address) ?></span>
                        </div>
                      <?php endif; ?>

                      <?php if (!empty($contactData->email)) : ?>
                        <div class="contact-box" style="display: flex; align-items: center; gap: 12px;">
                          <i class="icon-mail" style="font-size: 18px; background-color: #fafafa; color: #e883ae; padding: 12px; border-radius: 8px; min-width: 40px; text-align: center;"></i>
                          <a href="mailto:<?= $contactData->email ?>" style="color: #333; text-decoration: none;">
                            <span style="font-size: 15px; color: #333; display: inline-block;"><?= $contactData->email ?></span>
                          </a>
                        </div>
                      <?php endif; ?>

                      <?php if (!empty($contactData->phone)) : ?>
                        <div class="contact-box" style="display: flex; align-items: center; gap: 12px;">
                          <i class="icon-phone" style="font-size: 18px; background-color: #fafafa; color: #e883ae; padding: 12px; border-radius: 8px; min-width: 40px; text-align: center;"></i>
                          <?php
                            $whatsAppNumber = str_replace(['+', ' '], '', $contactData->phone);
                          ?>
                          <a href="https://wa.me/<?= $whatsAppNumber ?>" target="_blank" style="color: #333; text-decoration: none;">

                            <span style="font-size: 15px; color: #333; display: inline-block;"><?= $contactData->phone ?></span>
                          </a>
                        </div>
                      <?php endif; ?>

                    </div>

                  </div>

                  <?php if (
                      !empty($contactData->facebook_url) || 
                      !empty($contactData->instagram_url) || 
                      !empty($contactData->youtube_url) || 
                      !empty($contactData->x_url)
                  ) : ?>
                    <div class="info-item">
                      <i class="licon-clock3"></i>
                      <span class="post">Sosyal Medya Hesaplarımız</span>
                      <ul class="social-icons var2">

                        <?php if (!empty($contactData->facebook_url)) : ?>
                          <li><a href="<?= $contactData->facebook_url ?>" target="_blank"><i class="icon-facebook"></i></a></li>
                        <?php endif; ?>

                        <?php if (!empty($contactData->x_url)) : ?>
                          <li><a href="<?= $contactData->x_url ?>" target="_blank" style="text-decoration: none;" ><i class="ri-twitter-x-line"></i></a></li>
                        <?php endif; ?>

                        <?php if (!empty($contactData->instagram_url)) : ?>
                          <li><a href="<?= $contactData->instagram_url ?>" target="_blank"><i class="icon-instagram-5"></i></a></li>
                        <?php endif; ?>

                        <?php if (!empty($contactData->youtube_url)) : ?>
                          <li><a href="<?= $contactData->youtube_url ?>" target="_blank"><i class="icon-youtube-play"></i></a></li>
                        <?php endif; ?>

                      </ul>
                    </div>
                  <?php endif; ?>
                
                </div>

              </div>

            </aside>

          </div>

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
  <script src="assets/plugins/instafeed.min.js"></script>
  <script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
  <script src="assets/plugins/jquery.queryloader2.min.js"></script>
  <script src="assets/plugins/owl.carousel.min.js"></script>
  <script src="assets/js/plugins.js"></script>
  <script src="assets/js/script.js"></script>
  
</body>
</html>