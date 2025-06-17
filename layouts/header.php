<?php
$page = basename($_SERVER['PHP_SELF']);
$fxhd = $page == 'index.php' ? 'fixed-header' : '';

require_once(__DIR__ . "/../env/class.db.php");
require_once(__DIR__ . "/../admin/core/education/class.education.php");
require_once(__DIR__ . "/../admin/core/lessons/class.lessons.php");

$edu = new Education();
$allEducations = $edu->all();

$ls = new Lessons();
$allLessons = $ls->all();

// Kontrol: aktif eğitim ve ders var mı?
$hasActiveEducation = false;
foreach ($allEducations as $education) {
    if ($education->is_active != 1) continue;
    $subjects = $edu->subjects($education->id);
    $activeSubjects = array_filter($subjects, fn($s) => $s->is_active == 1);
    if (!empty($activeSubjects)) {
        $hasActiveEducation = true;
        break;
    }
}

$hasActiveLesson = false;
foreach ($allLessons as $lesson) {
    if ($lesson->is_active != 1) continue;
    $subjects = $ls->subjects($lesson->id);
    $activeSubjects = array_filter($subjects, fn($s) => $s->is_active == 1);
    if (!empty($activeSubjects)) {
        $hasActiveLesson = true;
        break;
    }
}
?>
<style>
.logo-wrap img {
    transition: box-shadow 0.3s ease;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.logo-wrap img:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.no-submenu + .sub-menu-wrap { 
    display: none !important;
}
.no-submenu {
    cursor: pointer;
    /*pointer-events: none;*/
}
</style>
<header id="header" class="header <?=$fxhd?> sticky-header">
    <div class="searchform-wrap">
        <div class="vc-child h-inherit">
            <form class="search-form">
                <button type="submit" class="search-button"></button>
                <div class="wrapper">
                    <input type="text" name="search" placeholder="Start typing...">
                </div>
            </form>
            <button class="close-search-form"></button>
        </div>
    </div>
    <div class="top-header">
        <div class="flex-row align-items-center justify-content-between">
            <div class="logo-wrap">
                <a href="anasayfa" class="logo"><img src="assets/images/logo5.png" alt="" width="90" style="border-radius: 0 0 16px 16px; padding: 4px; background-color: transparent; display: block; margin: 0 auto;"></a>
            </div>
            <div class="menu-holder">
                <div class="menu-wrap">
                    <div class="nav-item">
                        <nav id="main-navigation" class="main-navigation">
                            <ul id="menu" class="clearfix">
                                <li><a href="anasayfa">Anasayfa</a></li>
                                <li><a href="hakkimizda">Hakkımızda</a></li>

                                <li>
                                  <a href="javascript:void(0)" <?= !$hasActiveEducation ? 'class="no-submenu"' : '' ?>>Uzmanlık Eğitimleri</a>
                                  <?php if ($hasActiveEducation): ?>
                                  <div class="sub-menu-wrap">
                                    <ul>
                                      <?php foreach ($allEducations as $education):
                                        if ($education->is_active != 1) continue;
                                        $subjects = $edu->subjects($education->id);
                                        $activeSubjects = array_filter($subjects, fn($s) => $s->is_active == 1);
                                        if (!empty($activeSubjects)): ?>
                                          <li class="sub">
                                            <a href="#"><?= htmlspecialchars($education->title) ?></a>
                                            <div class="sub-menu-wrap sub-menu-inner">
                                              <ul>
                                                <?php foreach ($activeSubjects as $subject): ?>
                                                  <li><a href="uzmanlik-egitimleri/<?= htmlspecialchars($subject->slug) ?>"><?= htmlspecialchars($subject->title) ?></a></li>
                                                <?php endforeach; ?>
                                              </ul>
                                            </div>
                                          </li>
                                        <?php endif; endforeach; ?>
                                    </ul>
                                  </div>
                                  <?php endif; ?>
                                </li>

                                <li>
                                  <a href="javascript:void(0)" <?= !$hasActiveLesson ? 'class="no-submenu"' : '' ?>>Stüdyo Dersleri</a>
                                  <?php if ($hasActiveLesson): ?>
                                  <div class="sub-menu-wrap">
                                    <ul>
                                      <?php foreach ($allLessons as $lesson):
                                        if ($lesson->is_active != 1) continue;
                                        $subjects = $ls->subjects($lesson->id);
                                        $activeSubjects = array_filter($subjects, fn($s) => $s->is_active == 1);
                                        if (!empty($activeSubjects)): ?>
                                          <li class="sub">
                                            <a href="#"><?= htmlspecialchars($lesson->title) ?></a>
                                            <div class="sub-menu-wrap sub-menu-inner">
                                              <ul>
                                                <?php foreach ($activeSubjects as $subject): ?>
                                                  <li><a href="studyo-dersleri/<?= htmlspecialchars($subject->slug) ?>"><?= htmlspecialchars($subject->title) ?></a></li>
                                                <?php endforeach; ?>
                                              </ul>
                                            </div>
                                          </li>
                                        <?php endif; endforeach; ?>
                                    </ul>
                                  </div>
                                  <?php endif; ?>
                                </li>

                                <li><a href="etkinlikler">Etkinlikler</a></li>
                                <li><a href="urunler">Ürünler</a></li>
                                <li><a href="iletisim">İletişim</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>