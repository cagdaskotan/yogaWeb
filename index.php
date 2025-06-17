<?php
require_once("env/class.db.php");
require_once("admin/core/schedule/class.schedule.php");
require_once("admin/core/schedule/class.classes.php");
require_once("admin/core/schedule/class.instructors.php");
require_once("admin/core/products/class.products.php");
require_once("admin/core/products/class.categories.php");
require_once("admin/core/schedule/class.instructors.php");

$instructors = new Instructors();
$teamList = $instructors->all();

$categories = new Categories();
$allCategories = $categories->all();

$products = new Products();
$latestProducts = $products->latest(10);

$schedule = new Schedule();
$classes = new Classes();
$instructors = new Instructors();

if (isset($_POST['ajax_filter'])) {
    $class_id = intval($_POST['class_id'] ?? 0);
    $instructor_id = intval($_POST['instructor_id'] ?? 0);
    $days = $_POST['days'] ?? [];

    $filtered = array_filter($schedule->all(), function($item) use ($class_id, $instructor_id, $days) {
        return 
            (!$class_id || $item->class_id == $class_id) &&
            (!$instructor_id || $item->instructor_id == $instructor_id) &&
            (empty($days) || in_array($item->schedule_day, $days));
    });

    $daysText = ['', 'Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar'];

    foreach ($filtered as $r) {
        echo '<tr>';
        echo '<td data-title="Gün ve Saat">
                <div class="flex-row justify-content-between">
                    <div style="cursor:default"><strong>' . $daysText[intval($r->schedule_day)] . '</strong> | <strong>' . substr($r->start_time, 0, 5) . ' - ' . substr($r->end_time, 0, 5) . '</strong></div>
                </div>
              </td>';
        echo '<td data-title="Class"><a class="link-text" style="cursor:default"><strong>' . htmlspecialchars($r->class_name) . '</strong></a></td>';
        echo '<td data-title="Instructor"><a class="link-text" style="cursor:default"><strong>' . htmlspecialchars($r->instructor_name . ' ' . $r->instructor_surname) . '</strong></a></td>';
        echo '</tr>';
    }

    exit;
}

?>

<!doctype html>
<html lang="tr">
<head>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700%7CPrata" rel="stylesheet">
    <title>Şehirde Yoga</title>
    <meta charset="utf-8">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/font/demo-files/demo.css">
    <link rel="stylesheet" href="assets/plugins/fancybox/jquery.fancybox.css">
    <link rel="stylesheet" href="assets/plugins/revolution/css/settings.css">
    <link rel="stylesheet" href="assets/plugins/revolution/css/layers.css">
    <link rel="stylesheet" href="assets/plugins/revolution/css/navigation.css">

    <link rel="stylesheet" href="assets/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <style>
    #products-details-button:hover {
        background-color: #45b29d !important;
        border-color: #45b29d !important;
        color: #fff !important;
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

        <div class="rev-slider-wrapper">
            <div id="rev-slider" class="rev-slider tp-simpleresponsive" data-version="5.0">
                <ul>
                    <li data-transition="fade">
                        <img src="assets/images/null-images/default.jpg" class="rev-slidebg" alt="">
                        <div class="tp-caption tp-resizeme"
                            data-x="['left','left','left','left']" data-hoffset="30"
                            data-y="['middle','middle','middle','middle']" data-voffset="-110"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":150,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05">
                            <div class="section-pre-title">Şehirde Yoga'ya Hoşgeldiniz</div>
                        </div>
                        <div class="tp-caption tp-resizeme scaption-dark-large"
                            data-x="['left','left','left','left']" data-hoffset="30"
                            data-y="['middle','middle','middle','middle']" data-voffset="0"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":450,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05">Bedeninle Düşün<br> Zihninle Hareket Et
                        </div>
                        <div class="tp-caption tp-resizeme"
                            data-x="['left','left','left','left']" data-hoffset="30"
                            data-y="['middle','middle','middle','middle']" data-voffset="130"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":750,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05">
                            <a href="#schedule-1" class="btn btn-big scroll-link">Sınıf Takvimi</a>
                            <a href="#ekip" class="btn btn-big btn-style-3 scroll-link">Ekibimiz</a>
                        </div>
                    </li>
                    <li data-transition="fade">
                        <img src="assets/images/null-images/default.jpg" class="rev-slidebg" alt="">
                        <div class="tp-caption tp-resizeme"
                            data-x="['right','right','right','right']" data-hoffset="410"
                            data-y="['middle','middle','middle','middle']" data-voffset="-110"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":150,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05">
                            <div class="section-pre-title">Alışveriş</div>
                        </div>
                        <div class="tp-caption tp-resizeme scaption-dark-large"
                            data-x="['right','right','right','right']" data-hoffset="50"
                            data-y="['middle','middle','middle','middle']" data-voffset="0"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":150,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05">Hareketine Anlam <br> Katan Dokunuşlar
                        </div>
                        <div class="tp-caption tp-resizeme"
                            data-x="['right','right','right','right']" data-hoffset="440"
                            data-y="['middle','middle','middle','middle']" data-voffset="130"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":450,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05"><a href="urunler" class="btn btn-big btn-style-3">Ürünlerimiz</a>
                        </div>
                    </li>
                    <li data-transition="fade">
                        <img src="assets/images/null-images/default.jpg" class="rev-slidebg" alt="">
                        <div class="tp-caption tp-resizeme scaption-dark-large align-center"
                            data-x="['center','center','center','center']" data-hoffset="0"
                            data-y="['middle','middle','middle','middle']" data-voffset="-20"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":150,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05">Yolculuğumuzda <br> Sen De Yerini Al
                        </div>
                        <div class="tp-caption tp-resizeme"
                            data-x="['center','center','center','center']" data-hoffset="0"
                            data-y="['middle','middle','middle','middle']" data-voffset="120"
                            data-whitespace="nowrap"
                            data-frames='[{"delay":750,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                            data-responsive_offset="on"
                            data-elementdelay="0.05"><a href="hakkimizda" class="btn btn-big btn-style-3">Bizi Tanıyın</a>
                            <a href="iletisim" class="btn btn-big">İletişime Geçin</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div id="content">        
            <!-- SINIF TAKVİMİ -->
            <div id="schedule-1" class="page-section">
                <div class="container wide2">
                    <div class="content-element2">
                        <div class="section-pre-title">Sınıflar</div>
                        <h2 class="section-title">Sınıf Takvimi</h2>
                    </div>
                    <div class="healcode">
                        <div class="healcode-header">
                            <div class="filters">
                                <div class="filters-select">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mad-custom-select">
                                                <select id="filter-class" name="filter_class" class="filter-control" data-default-text="Tüm Sınıflar">
                                                    <option value="">Tüm Sınıflar</option>
                                                    <?php foreach($classes->all() as $c): ?>
                                                        <option value="<?= $c->id ?>"><?= $c->class ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mad-custom-select">
                                                <select id="filter-instructor" name="filter_instructor" class="filter-control" data-default-text="Tüm Eğitmenler">
                                                <option value="">Tüm Eğitmenler</option>
                                                <?php foreach($instructors->all() as $i): ?>
                                                    <option value="<?= $i->id ?>"><?= $i->name . ' ' . $i->surname ?></option>
                                                <?php endforeach; ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="filter_days">
                                    <div class="input-wrapper">
                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-1" value="1">
                                        <label for="day-1">Pazartesi</label>

                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-2" value="2">
                                        <label for="day-2">Salı</label>

                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-3" value="3">
                                        <label for="day-3">Çarşamba</label>

                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-4" value="4">
                                        <label for="day-4">Perşembe</label>

                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-5" value="5">
                                        <label for="day-5">Cuma</label>

                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-6" value="6">
                                        <label for="day-6">Cumartesi</label>

                                        <input type="checkbox" class="filter-day" name="schedule_day[]" id="day-7" value="7">
                                        <label for="day-7">Pazar</label>
                                    </div>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="table-type-1 schedule responsive-table">
                            <table id="schedule-list">
                                <thead>
                                <tr>
                                    <th>Gün ve Saat</th>
                                    <th>Sınıf</th>
                                    <th>Eğitmen</th>
                                </tr>
                                </thead>
                                <tbody id="schedule-data">
                                <?php
                                $days = ['', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];
                                $schedule = new Schedule();

                                foreach ($schedule->all() as $r): ?>
                                <tr>
                                    <td data-title="Gün ve Saat">
                                        <div class="flex-row justify-content-between">
                                            <div style="cursor:default"><strong><?= $days[intval($r->schedule_day)] ?></strong> | <strong><?= substr($r->start_time, 0, 5) ?> - <?= substr($r->end_time, 0, 5) ?></strong></div>
                                        </div>
                                    </td>
                                    <td data-title="Class"><a class="link-text" style="cursor:default"><strong><?= htmlspecialchars($r->class_name) ?></strong></a></td>
                                    <td data-title="Instructor"><a class="link-text" style="cursor:default"><strong><?= htmlspecialchars($r->instructor_name . ' ' . $r->instructor_surname) ?></strong></a></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>                    
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- EĞİTMENLER -->
            <div class="page-section-bg" id="ekip">
                <div class="container wide2">
                    <div class="content-element4">
                        <div class="section-pre-title">Eğitmenler</div>
                        <h2 class="section-title">Ekibimizle Tanışın</h2>
                    </div>

                    <div class="carousel-type-2">
                        <div class="team-holder owl-carousel" data-item-margin="30" data-max-items="5">
                            <?php foreach ($teamList as $instructor): ?>
                                <div class="team-item">
                                    <a href="<?= $instructor->image ?>" data-fancybox class="member-photo">
                                        <img src="<?= $instructor->image ?>" alt="" style="width: 100%; height: 312px; object-fit: cover; border-radius: 8px;">
                                    </a>
                                    <div class="team-desc">
                                        <div class="member-info">
                                            <h5 class="member-name"><?= htmlspecialchars($instructor->name . ' ' . $instructor->surname) ?></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty($latestProducts)): ?>
            <!-- ÜRÜNLER -->
            <div class="page-section">
                <div class="container wide2">
                    <div class="content-element4">
                        <div class="section-pre-title">Alışveriş</div>
                        <h2 class="section-title">Yoga Ürünleri</h2>
                    </div>
                    
                    <div class="carousel-type-2">
                        <div class="owl-carousel products-holder" data-item-margin="30" data-max-items="5">
                            <?php foreach ($latestProducts as $product): ?>
                                <div class="product">
                                    <figure class="product-image">
                                        <a href="<?= htmlspecialchars($product->image) ?>" data-fancybox>
                                            <img src="<?= htmlspecialchars($product->image) ?>" alt="" style="width:289px; height:286px; object-fit:contain;">
                                        </a>
                                    </figure>
                                    <div class="product-description">
                                        <a href="javascript:void(0)" class="product-cat"><?= htmlspecialchars($product->category_name ?? 'Kategori Yok') ?></a>
                                        <h6 class="product-name">
                                            <a href="urun/<?= $product->slug ?>"><?= htmlspecialchars($product->name) ?></a>
                                        </h6>
                                        <div class="pricing-area">
                                            <div class="product-price"><?= htmlspecialchars($product->price) ?> TL</div>
                                        </div>
                                            <a href="urun/<?= $product->slug ?>" class="btn btn-small btn-style-3" id="products-details-button">Detaylar</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
      <?php require_once("layouts/footer.php");?>
    </div>

    <script src="assets/js/libs/jquery.modernizr.js"></script>
    <script src="assets/js/libs/jquery-2.2.4.min.js"></script>
    <script src="assets/js/libs/jquery-ui.min.js"></script>
    <script src="assets/js/libs/retina.min.js"></script>
    <script src="assets/plugins/jquery.scrollTo.min.js"></script>
    <script src="assets/plugins/jquery.localScroll.min.js"></script>
    <script src="assets/plugins/instafeed.min.js"></script>
    <script src="assets/plugins/fancybox/jquery.fancybox.min.js"></script>
    <script src="assets/plugins/mad.customselect.js"></script>
    <script src="assets/plugins/revolution/js/jquery.themepunch.tools.min.js?ver=5.0"></script>
    <script src="assets/plugins/revolution/js/jquery.themepunch.revolution.min.js?ver=5.0"></script>
    <script src="assets/plugins/jquery.queryloader2.min.js"></script>
    <script src="assets/plugins/owl.carousel.min.js"></script>

    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
    $(document).ready(function () {
        function fetchFilteredData() {
            var classId = $('#filter-class').val();
            var instructorId = $('#filter-instructor').val();
            var days = [];

            $('.filter-day:checked').each(function () {
                days.push($(this).val());
            });

            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    ajax_filter: true,
                    class_id: classId,
                    instructor_id: instructorId,
                    days: days
                },
                success: function (response) {
                    $('#schedule-data').html(response);
                }
            });
        }

        $('#filter-class, #filter-instructor').on('change', fetchFilteredData);
        $('.filter-day').on('change', fetchFilteredData);
    });
    document.querySelectorAll('.scroll-link').forEach(link => {
        link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        target.scrollIntoView({
            behavior: 'smooth'
        });
        });
    }); 
    </script>

</body>
</html>