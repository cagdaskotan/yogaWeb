<?php
$page = basename($_SERVER['PHP_SELF']);
?>
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index.php" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/images/favicon.png" alt="" height="25">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.php" class="logo logo-light mt-2">
            <span class="logo-sm">
                <img src="assets/images/favicon.png" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo.jpg" alt="" height="55" style="max-width: 100%; border-radius: 5px;">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>İşlemler</span></li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link menu-link <?= ($page == "index.php") ? 'active' : '' ?>">
                        <i class="ri-dashboard-line"></i>
                        <span>Panel</span>
                    </a>
                </li>
                <?php
                $about_pages = array('about-educations.php', 'about-gallery.php', 'about.php');
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sb-about" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sb-about">
                        <i class="ri-team-line"></i> <span>Hakkımızda</span>
                    </a>
                    <div class="collapse menu-dropdown <?= (in_array($page, $about_pages)) ? 'show' : '' ?>" id="sb-about">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="about-educations.php" class="nav-link <?= ($page == "about-educations.php") ? 'active' : '' ?>"> Kişisel Eğitimlerim </a>
                            </li>
                            <li class="nav-item">
                                <a href="about-gallery.php" class="nav-link <?= ($page == "about-gallery.php") ? 'active' : '' ?>"> Galeri </a>
                            </li>
                            <li class="nav-item">
                                <a href="about.php" class="nav-link <?= ($page == "about.php") ? 'active' : '' ?>"> Hakkımızda </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
                $product_pages = array('categories.php', 'products.php');
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sb-products" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sb-products">
                        <i class="ri-shopping-bag-3-line"></i> <span>Alışveriş</span>
                    </a>
                    <div class="collapse menu-dropdown <?= (in_array($page, $product_pages)) ? 'show' : '' ?>" id="sb-products">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="categories.php" class="nav-link <?= ($page == "categories.php") ? 'active' : '' ?>"> Kategoriler </a>
                            </li>
                            <li class="nav-item">
                                <a href="products.php" class="nav-link <?= ($page == "products.php") ? 'active' : '' ?>"> Ürünler </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <?php
                $class_pages = array('classes.php', 'instructors.php', 'schedule.php');
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sb-classes" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sb-classes">
                        <i class="ri-calendar-2-line"></i> <span>Sınıf Takvimi</span>
                    </a>
                    <div class="collapse menu-dropdown <?= (in_array($page, $class_pages)) ? 'show' : '' ?>" id="sb-classes">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="classes.php" class="nav-link <?= ($page == "classes.php") ? 'active' : '' ?>"> Sınıflar </a>
                            </li>
                            <li class="nav-item">
                                <a href="instructors.php" class="nav-link <?= ($page == "instructors.php") ? 'active' : '' ?>"> Eğitmenler </a>
                            </li>
                            <li class="nav-item">
                                <a href="schedule.php" class="nav-link <?= ($page == "schedule.php") ? 'active' : '' ?>"> Takvim </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="events.php" class="nav-link menu-link <?= ($page == "events.php") ? 'active' : '' ?>">
                        <i class="ri-discuss-line"></i>
                        <span>Etkinlikler</span>
                    </a>
                </li>
                <?php
                $edu_pages = array('education.php', 'education-subjects.php', 'education-article-manager.php');
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sb-education" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sb-education">
                        <i class="ri-graduation-cap-line"></i> <span>Uzmanlık Eğitimleri</span>
                    </a>
                    <div class="collapse menu-dropdown <?= (in_array($page, $edu_pages)) ? 'show' : '' ?>" id="sb-education">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="education.php" class="nav-link <?= ($page == "education.php") ? 'active' : '' ?>"> Eğitimler </a>
                            </li>
                            <li class="nav-item">
                                <a href="education-subjects.php" class="nav-link <?= ($page == "education-subjects.php" || $page == "education-article-manager.php") ? 'active' : '' ?>"> Konular </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <?php
                $less_pages = array('lessons.php', 'lessons-subjects.php', 'lessons-article-manager.php');
                ?>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sb-lessons" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sb-lessons">
                        <i class="ri-book-mark-line"></i> <span>Stüdyo Dersleri</span>
                    </a>
                    <div class="collapse menu-dropdown <?= (in_array($page, $less_pages)) ? 'show' : '' ?>" id="sb-lessons">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="lessons.php" class="nav-link <?= ($page == "lessons.php") ? 'active' : '' ?>"> Dersler </a>
                            </li>
                            <li class="nav-item">
                                <a href="lessons-subjects.php" class="nav-link <?= ($page == "lessons-subjects.php" || $page == "lessons-article-manager.php") ? 'active' : '' ?>"> Konular </a>
                            </li>
                        </ul>
                    </div>
                </li>
                 <li class="nav-item">
                    <a href="file-manager.php" class="nav-link menu-link <?= ($page == "file-manager.php") ? 'active' : '' ?>">
                        <i class="ri-upload-line"></i>
                        <span>Dosya Yönetimi</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>