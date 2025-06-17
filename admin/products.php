<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();

require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/products/class.products.php");
require_once("core/products/class.categories.php");
require_once("core/class.func.php");

?>

<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"  data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Ürünler - Şehirde Yoga Yönetim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Şehirde Yoga" name="description" />
    <meta content="Z-Sistem" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <!-- gridjs css -->
    <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">

    <link rel="stylesheet" href="assets/libs/datatables/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/buttons.dataTables.min.css">
    
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
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

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Ürünler</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="flex-grow-1">
                                            <button class="btn btn-outline-primary add-btn" data-bs-toggle="modal" data-bs-target="#add-product-modal"><i class="ri-add-fill me-1 align-bottom"></i> Ürün Oluştur</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xxl-8">
                                            <table id="table-product" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th data-ordering="false" style="width: 45px;">Sıra</th>
                                                        <th>Görsel</th>
                                                        <th>İsim</th>
                                                        <th>Fiyat</th>
                                                        <th>Kategori</th>
                                                        <th class="text-end" style="width: 120px;">İşlemler</th>
                                                        <th class="text-end">Aktiflik</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $cls = new Products();
                                                    foreach($cls->all(false) as $x){
                                                        $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td>
                                                            <img src="../<?= $x->image ?>" style="height:50px; width:50px; object-fit:cover; border-radius:6px;">
                                                        </td>
                                                        <td><?= $x->name ?></td>
                                                        <td><?= $x->price ?> TL</td>
                                                        <td><?= $x->category_name ?? 'Kategori Yok' ?></td>
                                                        <td class="text-end">                                                            
                                                            <a class="btn btn-sm btn-secondary btn-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#edit-product-modal" data-bs-whatever="<?=$x->id?>">
                                                                <i class="ri-edit-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Düzenle"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-danger btn-icon waves-effect waves-light mr-3" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?=$x->id?>">
                                                                <i class="ri-delete-bin-5-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sil"></i>
                                                            </a>                                                            
                                                        </td>
                                                        <?php $checked = $x->is_active == 1 ? 'checked' : ''; ?>
                                                        <td class="text-end p-0">
                                                            <div class="form-check form-switch form-switch-md form-switch-success btn">
                                                                <input name="activate" value="<?=$x->id?>" class="form-check-input" type="checkbox" <?=$checked?> role="switch" title="Yayınla">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>          

                                    <div class="modal fade" id="add-product-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Ürün Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-product-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <div class="mb-3">
                                                                        <input type="text" name="name" class="form-control" placeholder="İsim" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="file" name="image" class="form-control" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="number" name="price" class="form-control" placeholder="Fiyat" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <select name="category_id" class="form-select" required>
                                                                            <option value="">Kategori Seçin</option>
                                                                            <?php
                                                                                $categories = new Categories();
                                                                                foreach ($categories->all() as $cat) {
                                                                                    echo '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <textarea name="description" class="form-control" placeholder="Açıklama" rows="3"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <img id="add-preview" src="" alt="Görsel Önizleme" style="max-height: 100px; display: none; border-radius: 8px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="add-less" value="Ekle">
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <!--end row-->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="edit-product-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Ürün Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-product-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <div class="mb-3">
                                                                        <input type="text" name="name" id="edit-name" class="form-control" placeholder="Ürün" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="hidden" name="id" id="edit-li">
                                                                        <input type="file" name="image" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <input type="number" name="price" id="edit-price" class="form-control" placeholder="Fiyat" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <select name="category_id" id="edit-category" class="form-select" required>
                                                                            <option value="">Kategori Seçin</option>
                                                                            <?php
                                                                            $categories = new Categories();
                                                                            foreach ($categories->all() as $cat) {
                                                                                echo '<option value="'.$cat->id.'">'.$cat->name.'</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <textarea name="description" id="edit-description" class="form-control" placeholder="Açıklama" rows="3"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <img id="edit-preview" src="" alt="Ürün Görseli" style="max-height: 100px; display: block; border-radius: 8px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="edit-less" value="Güncelle">
                                                                </div>
                                                            </div>
                                                            <!--end col-->
                                                        </div>
                                                        <!--end row-->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade zoomIn" id="deleteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                </div>
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="fs-semibold">Ürün silinecek ? Emin misiniz?</h4>
                                                        <p class="text-muted fs-14 mb-4 pt-1">Veritabanından tamamen silinmez. Bağlı olan diğer içerikler ve raporlar etkilenir.</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal">
                                                                <i class="ri-close-line me-1 align-middle"></i> Vazgeç
                                                            </button>
                                                            <button class="btn btn-danger" value="" id="delete-record">Anladım, Silebilirsin!</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php require_once("layouts/footer.php");?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <script src="assets/js/jquery.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src='assets/js/toastify.js'></script>
    <script src='assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>
    <script src='assets/libs/flatpickr/flatpickr.min.js'></script> 

    <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.responsive.min.js"></script>

    <script src="assets/js/pages/form-validation.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script type="text/javascript">
        
        //Modal Senders   
        $(document).on('submit','#edit-product-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('edit_product', true);
            $.ajax({
                type: 'POST',
                url: 'core/products/api.products.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#edit-product-modal').modal('hide');
                    $('#edit-product-form').trigger('reset');
                    Toastify({
                        text: data.message,
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: 'center',
                        className: "bg-success",
                        stopOnFocus: true,
                    }).showToast();
                    setInterval(function(){ window.location.reload(); }, 2200);
                }
            });
        });     
        $(document).on('submit','#add-product-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('add_product', true);
            $.ajax({
                type: 'POST',
                url: 'core/products/api.products.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#add-product-modal').modal('hide');
                    $('#add-product-form').trigger('reset');
                    Toastify({
                        text: data.message,
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: 'center',
                        className: "bg-success",
                        stopOnFocus: true,
                    }).showToast();
                    setInterval(function(){ window.location.reload(); }, 2200);
                }
            });
        });
        $('#delete-record').click(function (e) {
            e.preventDefault();
            var id = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'core/products/api.products.php',
                data: {delete_product: true, id: id},
                success: function(data) {
                    $('#deleteModal').modal('hide');
                    $('#delete-record').val(0);
                    Toastify({
                        text: data.message,
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: 'center',
                        className: "bg-danger",
                        stopOnFocus: true,
                    }).showToast();
                    setInterval(function(){ window.location.reload(); }, 2200);
                }
            });
        });
        //Edit Modals Open Activity
        $(document).on('show.bs.modal','#edit-product-modal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $.ajax({
                type: 'POST',
                url: 'core/products/api.products.php',
                data: {get_product: true, id: id},
                success: function(data) {
                $('#edit-name').val(data.data.name);
                $('#edit-li').val(data.data.id);
                $('#edit-price').val(data.data.price);
                $('#edit-category').val(data.data.category_id);
                $('#edit-description').val(data.data.description);
                $('#edit-preview').attr('src', '../' + data.data.image);
                }
            });
        });
        $(document).on('show.bs.modal','#deleteModal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $('#delete-record').val(id);
        });
        $('#table-product').DataTable({
            "paging":   true,
            "searching": false,
            "lengthChange": false,
            language: {
                url: 'assets/json/tr.json',
            },
        });
        // Görsel seçildiğinde önizleme görselini güncelle
        $(document).on('change', '#edit-product-form input[name="image"]', function(event) {
            const input = event.target;
            const preview = document.getElementById('edit-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
        // Ürün eklerken görsel önizlemesini göster
        $(document).on('change', '#add-product-form input[name="image"]', function(event) {
            const input = event.target;
            const preview = document.getElementById('add-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
        $(document).on('change','[name="activate"]', function(e){
            e.preventDefault();
            var id = $(this).val();
            var status = $(this).is(':checked') ? 'true' : 'false';
            $.ajax({
                type: 'POST',
                url: 'core/products/api.products.php',
                data: {
                    activate: status,
                    id: id
                },
                success: function(data) {
                    Toastify({
                        text: data.message,
                        duration: 2000,
                        gravity: "top",
                        position: 'center',
                        className: data.cls || "bg-success",
                    }).showToast();
                }
            });
        });
    </script>
</body>
</html>