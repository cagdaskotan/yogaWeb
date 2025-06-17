<?php
require_once("env/class.db.php");
require_once("admin/core/products/class.products.php");
require_once("admin/core/products/class.categories.php");

$categories = new Categories();
$allCategories = $categories->all();

$products = new Products();

if (isset($_GET['ajax'])) {
    $sort = $_GET['sort'] ?? '';
    $search = $_GET['search'] ?? '';

    $filteredProducts = $products->all();

    $categoryId = $_GET['category'] ?? '';

    if (!empty($categoryId)) {
        $filteredProducts = array_filter($filteredProducts, function($product) use ($categoryId) {
            return $product->category_id == $categoryId;
        });
    }

    if (!empty($search)) {
        $filteredProducts = array_filter($filteredProducts, function($product) use ($search) {
            return stripos($product->name, $search) !== false;
        });
    }

    if ($sort == 'az') {
        usort($filteredProducts, function($a, $b) {
            return strcmp($a->name, $b->name);
        });
    } elseif ($sort == 'za') {
        usort($filteredProducts, function($a, $b) {
            return strcmp($b->name, $a->name);
        });
    } elseif ($sort == 'price_low') {
        usort($filteredProducts, function($a, $b) {
            return $a->price - $b->price;
        });
    } elseif ($sort == 'price_high') {
        usort($filteredProducts, function($a, $b) {
            return $b->price - $a->price;
        });
    }

    header('Content-Type: application/json');
    echo json_encode(array_values($filteredProducts));
    exit;
}

$allProducts = $products->all();

?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title>Yoga Ürünleri</title>
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
    .filter-bar {
        margin-bottom: 50px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .product:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }
    .btn-style-3:hover {
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
    <?php require_once("layouts/header.php"); ?>

    <div class="breadcrumbs-wrap">
        <div class="container">
            <h1 class="page-title">Ürünler</h1>
            <!-- <ul class="breadcrumbs">
                <li><a href="index.html">Anasayfa</a></li>
                <li>Alışveriş</li>
                <li>Ürünler</li>
            </ul> -->
        </div>
    </div>

    <div id="content" class="page-content-wrap">
        <div class="container wide3">
            <div class="row">
                <main id="main" class="col-12">
                    <?php if (!empty($allProducts)) : ?>
                    <div class="product-sort-section d-flex justify-content-end align-items-center mb-3">
                        <div class="product-count">
                            <span id="productCount"><?= count($allProducts) ?> ürün</span>
                        </div>
                    </div>
                    <div class="row filter-bar align-items-center g-2">
                        <!-- Arama -->
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <form class="search-form" onsubmit="return false;">
                                <input type="text" id="searchInput" class="form-control" placeholder="Ürünleri Ara">
                            </form>
                        </div>

                        <!-- Sıralama -->
                        <div class="col-lg-3 col-md-4 col-sm-12 mad-custom-select">
                            <select id="sortProducts" class="form-select" data-default-text="Sıralama">
                                <option value="">Varsayılan</option>
                                <option value="az">İsim (A-Z)</option>
                                <option value="za">İsim (Z-A)</option>
                                <option value="price_low">Fiyat (Düşükten Yükseğe)</option>
                                <option value="price_high">Fiyat (Yüksekten Düşüğe)</option>
                            </select>
                        </div>

                        <!-- Kategori -->
                        <div class="col-lg-3 col-md-4 col-sm-12 mad-custom-select">
                            <select id="categoryFilter" class="form-select" data-default-text="Kategori Seçin">
                                <option value="">Tüm Kategoriler</option>
                                <?php foreach ($allCategories as $cat): ?>
                                    <option value="<?= $cat->id ?>"><?= htmlspecialchars($cat->name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Sıfırla Butonu -->
                        <div class="col-lg-3 col-md-12 col-sm-12 text-end">
                            <button id="resetFilters" class="btn btn-outline-secondary btn-sm w-100 w-lg-auto">
                                Sıfırla
                            </button>
                        </div>
                    </div>

                    <div class="row products-holder g-4">
                        <?php foreach ($allProducts as $product) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-6" style="margin-bottom: 10px;">
                                <div class="product" style="
                                    border: 1px solid #eee;
                                    border-radius: 10px;
                                    background-color: #fff;
                                    padding: 15px;
                                    transition: all 0.2s ease-in-out;
                                    height: 100%;
                                ">
                                    <figure class="product-image" style="text-align:center; margin-bottom: 15px;">
                                        <a href="<?= htmlspecialchars($product->image) ?>" data-fancybox>
                                            <img src="<?= htmlspecialchars($product->image) ?>" alt="" style="width:100%; max-width:289px; height:286px; object-fit:contain; border-radius: 7px;">
                                        </a>
                                    </figure>
                                    <div class="product-description">
                                        <a href="javascript:void(0)" class="product-cat" style="cursor: default;"><?= htmlspecialchars($product->category_name ?? 'Kategori Yok') ?></a>
                                        <h6 class="product-name">
                                            <a href="urun/<?= $product->slug ?>"><?= htmlspecialchars($product->name) ?></a>
                                        </h6>
                                        <div class="pricing-area">
                                            <div class="product-price"><?= htmlspecialchars($product->price) ?> TL</div>
                                        </div>
                                    <a href="urun/<?= $product->slug ?>" class="btn btn-small btn-style-3" style="margin-bottom: 10px;">Detaylar</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php else: ?>
                        <!-- Ürün Yoksa Göster -->
                        <div style="padding: 60px 20px; text-align: center; background-color: #f8f9fa; border-radius: 12px; margin-top: 40px;">
                            <h2 style="font-size: 24px; color: #e883ae; margin-bottom: 10px;">Henüz Ürün Eklenmemiştir</h2>
                            <p style="color: #555;">Yeni ürünleri yakında burada bulabilirsiniz.</p>
                        </div>
                    <?php endif; ?>
                </main>
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

<script>
    function loadProducts(sortValue = '', searchValue = '', categoryId = '') {
        $.ajax({
            url: 'products.php?ajax=1',
            method: 'GET',
            data: {
                sort: sortValue,
                search: searchValue,
                category: categoryId
            },
            dataType: 'json',
            success: function(response) {
                var html = '';
                $('#productCount').text(response.length + " ürün");

                $.each(response, function(index, product) {
                    html += '<div class="col-lg-4 col-md-6 col-sm-6" style="margin-bottom: 10px;">' +
                            '<div class="product" style="border: 1px solid #eee;border-radius: 10px;background-color: #fff;padding: 15px;transition: all 0.2s ease-in-out;height: 100%;">' +
                                '<figure class="product-image" style="text-align:center; margin-bottom: 15px;">' +
                                '<a href="' + product.image + '" data-fancybox>' +
                                    '<img src="' + product.image + '" alt="" style="width:100%; max-width:289px; height:286px; object-fit:contain; border-radius:7px;">' +
                                '</a>' +
                                '</figure>' +
                                '<div class="product-description">' +
                                '<a href="javascript:void(0)" class="product-cat" style="cursor: default;">' + (product.category_name || 'Kategori Yok') + '</a>' +
                                '<h6 class="product-name"><a href="urun/' + product.slug + '">' + product.name + '</a></h6>' +
                                '<div class="pricing-area"><div class="product-price">' + product.price + ' TL</div></div>' +
                                '<a href="urun/' + product.slug + '" class="btn btn-small btn-style-3" style="margin-bottom:10px;">Detaylar</a>' +
                                '</div>' +
                            '</div>' +
                            '</div>';
                });

                $('.products-holder').html(html);
            },
            error: function() {
                alert("Ürünler yüklenirken bir hata oluştu.");
            }
        });
    }

    $('#sortProducts').on('change', function(e) {
        e.preventDefault();
        var sortValue = $(this).val();
        var searchValue = $('#searchInput').val();
        var categoryId = $('#categoryFilter').val();
        loadProducts(sortValue, searchValue, categoryId);
    });

    $('#searchInput').on('input', function() {
        var sortValue = $('#sortProducts').val();
        var searchValue = $(this).val();
        var categoryId = $('#categoryFilter').val();
        loadProducts(sortValue, searchValue, categoryId);
    });

    $('#categoryFilter').on('change', function() {
        var sortValue = $('#sortProducts').val();
        var searchValue = $('#searchInput').val();
        var categoryId = $(this).val();
        loadProducts(sortValue, searchValue, categoryId);
    });

    $('#resetFilters').on('click', function () {
        $('#searchInput').val('');
        $('#sortProducts').val('');
        $('#categoryFilter').val('');
        loadProducts();
    });


</script>

<script>
    const resetBtn = document.getElementById("resetFilters");
    resetBtn.addEventListener("mouseover", () => {
        resetBtn.style.backgroundColor = "#e883ae";
        resetBtn.style.color = "#fff";
        resetBtn.style.borderColor = "#e883ae";
    });
    resetBtn.addEventListener("mouseout", () => {
        resetBtn.style.backgroundColor = "";
        resetBtn.style.color = "";
        resetBtn.style.borderColor = "";
    }); 
</script>

</body>
</html>