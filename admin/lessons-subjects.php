<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/lessons/class.lessons.php");
require_once("core/lessons/class.subjects.php");
require_once("core/class.func.php");
?>
<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Stüdyo Dersleri - Şehirde Yoga Yönetim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Şehirde Yoga" name="description" />
    <meta content="Z-Sistem" name="author" />

    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/libs/gridjs/theme/mermaid.min.css">
    <link rel="stylesheet" href="assets/libs/datatables/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="assets/libs/datatables/css/buttons.dataTables.min.css">

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

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Konular</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="flex-grow-1">
                                            <button class="btn btn-outline-primary add-btn" data-bs-toggle="modal" data-bs-target="#add-sub-modal"><i class="ri-add-fill me-1 align-bottom"></i> Konu Oluştur</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xxl-12">
                                            <table id="table-subject" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th data-ordering="false" style="width: 45px;">Sıra</th>
                                                        <th>Ders</th>
                                                        <th>Konu</th>
                                                        <th style="width: 100px;">İşlemler</th>
                                                        <th class="text-end" style="width: 100px;">Aktiflik</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach($sj->all() as $x){
                                                        $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?=$x->lesson?></td>
                                                        <td><?=$x->title?></td>
                                                        <td class="text-end">
                                                              

                                                            <a href="lessons-article-manager.php?subject=<?=md5('zsistem'.$x->id)?>" class="btn btn-sm btn-primary btn-icon waves-effect waves-light">
                                                                <i class="ri-add-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="İçerik Ekle"></i>
                                                            </a>                                                         
                                                            <a id="<?=$x->lesson_id?>" data-bs-whatever="<?=$x->id?>" data-bs-toggle="modal" data-bs-target="#edit-sub-modal" class="btn btn-sm btn-secondary btn-icon waves-effect waves-light">
                                                                <i class="ri-edit-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Düzenle"></i>
                                                            </a>
                                                            <a data-bs-whatever="<?=$x->id?>" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-sm btn-danger btn-icon waves-effect waves-light mr-3">
                                                                <i class="ri-delete-bin-5-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sil"></i>
                                                            </a>                                                            
                                                        </td>
                                                        <td class="text-end p-0">
                                                        <?php ($x->is_active == 1) ? $checked = "checked" : $checked = "";?>
                                                            <div class="form-check form-switch form-switch-md form-switch-success btn">
                                                                <input name="activate" value="<?=$x->id?>" class="form-check-input" type="checkbox" <?=$checked?> role="switch" id="act-this" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Yayınla">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade" id="add-sub-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Konu Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-sub-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label for="ls-id" class="form-label">Ders</label>
                                                                    <select name="lesson_id" class="form-select" id="ls-id" required>
                                                                        <option value="">Seçiniz...</option>
                                                                        <?php foreach($ls->all() as $x){?>
                                                                        <option value="<?=$x->id?>"><?=$x->title?></option>
                                                                        <?php }?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label for="ls-title" class="form-label">Konu</label>
                                                                    <input type="text" name="title" class="form-control" placeholder="Başlık" id="ls-title" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="add-sub" value="Ekle">
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

                                    <div class="modal fade" id="edit-sub-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Konu Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-sub-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label for="els-id" class="form-label">Ders</label>
                                                                    <select name="lesson_id" class="form-select" id="els-id" required>
                                                                        <option value="">Seçiniz...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <label for="ls-title" class="form-label">Konu</label>
                                                                    <input type="text" name="title" class="form-control" placeholder="Başlık" id="els-title" required>
                                                                    <input type="hidden" name="id" id="sub-id" value="">
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
                                                        <h4 class="fs-semibold">Ders silinecek ? Emin misiniz?</h4>
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



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    
    <script src="assets/js/jquery.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src='assets/js/toastify.js'></script>
    <script src='assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>
    <script src='assets/libs/flatpickr/flatpickr.min.js'></script>
    <script src="assets/libs/datatables/js/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.responsive.min.js"></script>

    <script src="assets/js/pages/form-validation.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script>
        $(document).on('submit','#edit-sub-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('edit_subject', true);
            $.ajax({
                type: 'POST',
                url: "core/lessons/api.lessons.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#edit-sub-modal').modal('hide');
                    $('#edit-sub-form').trigger('reset');
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
        $(document).on('change','[name="activate"]',function(e){
            e.preventDefault();
            var id = $(this).val();
            if($(this).is(':checked')){
                var data = {id: id, s_activate: "true"};
            }else{
                var data = {id: id, s_activate: "false"};
            }
            $.ajax({
                type: 'POST',
                url: "core/lessons/api.lessons.php",
                data: data,
                success: function(data) {
                    new Toastify({
                        text: data.message,
                        duration: 2000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: 'center',
                        className: data.cls,
                        stopOnFocus: true,
                    }).showToast();
                }
            });
        });
        $(document).on('submit','#add-sub-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('add_subject', true);
            $.ajax({
                type: 'POST',
                url: "core/lessons/api.lessons.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#add-sub-modal').modal('hide');
                    $('#add-sub-form').trigger('reset');
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
                url: "core/lessons/api.lessons.php",
                data: {delete_subject: true, id: id},
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
        $('#table-subject').DataTable({
            "paging":   true,
            "searching": true,
            "lengthChange": true,
            language: {
                url: 'assets/json/tr.json',
            },
        });        
        $(document).on('show.bs.modal','#edit-sub-modal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            var lesson_id = t.relatedTarget.getAttribute("id");
            $.ajax({
                type: 'POST',
                url: "core/lessons/api.lessons.php",
                data: {prep_subject : true, id, lesson_id},
                success: function(data) {
                    $('#els-id').html(data.lessons);
                    $('#els-title').val(data.title);
                    $('#sub-id').val(data.id);
                }
            });
        });
        $(document).on('show.bs.modal','#deleteModal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $('#delete-record').val(id);
        });
        
    </script>
</body>

</html>