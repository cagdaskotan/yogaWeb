<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/contact/class.contact.php");
require_once("core/products/class.products.php");
require_once("core/education/class.education.php");
require_once("core/lessons/class.lessons.php");
require_once("core/events/class.events.php");
require_once("core/class.func.php");

$contact = new Contact();
$contactData = $contact->get(1);

// Ürün sayısı
$products = new Products();
$total = count($products->all(false));

// Uzmanlık eğitim sayısı
$educations = new Education();
$th = count($educations->all());

// Stüdyo dersi sayısı
$lessons = new Lessons();
$fh = count($lessons->all());

// Etkinlik sayısı
$events = new Events();
$dh = count($events->all());

?>
<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Şehirde Yoga Yönetim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Şehirde Yoga" name="description" />
    <meta content="Z-Sistem" name="author" />

    <link href="assets/images/favicon.png" rel="shortcut icon">
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/layout.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="layout-wrapper">
        <?php
        require_once('layouts/header.php');
        require_once('layouts/leftmenu.php');
        ?>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="fw-medium text-muted mb-0">Toplam Ürün</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $total ?>"><?= $total ?></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="fw-medium text-muted mb-0">Toplam Uzmanlık Eğitimi</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $th ?>"><?= $th ?></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="fw-medium text-muted mb-0">Toplam Stüdyo Dersi</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $fh ?>"><?= $fh ?></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <p class="fw-medium text-muted mb-0">Toplam Etkinlik</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="<?= $dh ?>"><?= $dh ?></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FORM ALANI -->
                    <div class="row">
                    <div class="col-lg-12 mt-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light border d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">İletişim Bilgileri</h5>
                                <i class="ri-edit-2-line fs-18 text-muted"></i>
                            </div>
                            <div class="card-body">
                                <form id="contact-form">
                                    <div class="row g-4">

                                        <!-- Adres ve Harita -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Adres</label>
                                            <textarea name="address" class="form-control" rows="4" placeholder="Fiziksel adresi giriniz"><?=$contactData->address ?? ''?></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Google Maps Embed Kodu</label>
                                            <textarea name="map_embed_code" class="form-control" rows="4" placeholder="Harita iframe embed kodu"><?=$contactData->map_embed_code ?? ''?></textarea>
                                        </div>

                                        <!-- Telefon ve E-posta -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Telefon</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-phone-line"></i></span>
                                                <input type="text" name="phone" class="form-control" value="<?=$contactData->phone ?? ''?>" placeholder="+90 5XX XXX XX XX">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">E-posta</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                                <input type="email" name="email" class="form-control" value="<?=$contactData->email ?? ''?>" placeholder="ornek@mail.com">
                                            </div>
                                        </div>

                                        <!-- Sosyal Medyalar (2x2 düzen) -->
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Facebook</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-facebook-line"></i></span>
                                                <input type="url" name="facebook_url" class="form-control" value="<?=$contactData->facebook_url ?? ''?>" placeholder="Facebook linki">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Instagram</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-instagram-line"></i></span>
                                                <input type="url" name="instagram_url" class="form-control" value="<?=$contactData->instagram_url ?? ''?>" placeholder="Instagram linki">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">YouTube</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-youtube-line"></i></span>
                                                <input type="url" name="youtube_url" class="form-control" value="<?=$contactData->youtube_url ?? ''?>" placeholder="YouTube linki">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">X</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-twitter-x-line"></i></span>
                                                <input type="url" name="x_url" class="form-control" value="<?=$contactData->x_url ?? ''?>" placeholder="X / Twitter linki">
                                            </div>
                                        </div>


                                        <!-- Kaydet Butonu -->
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                <i class="ri-save-line me-1 align-middle"></i> Kaydet
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                </div>
            </div>
            <?php
            require_once("layouts/footer.php");
            ?>
        </div>
    </div>

    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <script src="assets/js/jquery.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/toastify.js"></script>
    <script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/js/app.js"></script>
    
    <script>
    $(document).on('submit', '#contact-form', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('update_contact', true);
        $.ajax({
            type: 'POST',
            url: 'core/contact/api.contact.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                Toastify({
                    text: data.message,
                    duration: 2000,
                    gravity: "top",
                    position: 'center',
                    className: data.status == 200 ? "bg-success" : "bg-danger",
                }).showToast();
            }
        });
    });
    </script>

</body>

</html>