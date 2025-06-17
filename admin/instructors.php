<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();

require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/schedule/class.instructors.php");
require_once("core/class.func.php");

?>

<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"  data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Eğitmenler - Şehirde Yoga Yönetim</title>
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
                                <h4 class="mb-sm-0">Eğitmenler</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="flex-grow-1">
                                            <button class="btn btn-outline-danger add-btn" data-bs-toggle="modal" data-bs-target="#add-instructor-modal"><i class="ri-add-fill me-1 align-bottom"></i> Eğitmen Ekle</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xxl-8">
                                            <table id="table-instructor" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th data-ordering="false" style="width: 45px;">Sıra</th>
                                                        <th>Görsel</th>
                                                        <th>Eğitmen</th>
                                                        <th class="text-end" style="width: 120px;">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $cls = new Instructors();
                                                    foreach($cls->all() as $x){
                                                        $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td>
                                                            <img src="../<?= $x->image ?>" alt="Eğitmen" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                                        </td>
                                                        <td><?=$x->name . ' ' . $x->surname?></td>
                                                        <td class="text-end">                                                            
                                                            <a class="btn btn-sm btn-secondary btn-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#edit-instructor-modal" data-bs-whatever="<?=$x->id?>">
                                                                <i class="ri-edit-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Düzenle"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-danger btn-icon waves-effect waves-light mr-3" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?=$x->id?>">
                                                                <i class="ri-delete-bin-5-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Sil"></i>
                                                            </a>                                                            
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>          

                                    <div class="modal fade" id="add-instructor-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Eğitmen Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-instructor-form" class="needs-validation" enctype="multipart/form-data" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <input type="text" name="instructor_name" class="form-control" placeholder="Ad" required>
                                                                    <input type="text" name="instructor_surname" class="form-control mt-2" placeholder="Soyad" required>
                                                                    <input type="file" name="instructor_image" class="form-control mt-2" accept="image/*">
                                                                    <div class="text-center py-3">
                                                                        <img id="add-preview" src="" style="display:none; width: 120px; height: 120px; border-radius: 50%; object-fit: cover; box-shadow: 0 0 8px rgba(0,0,0,0.15);">
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
                                    <div class="modal fade" id="edit-instructor-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Eğitmen Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-instructor-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <input type="text" name="instructor_name" id="edit-name" class="form-control" placeholder="Ad" required>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <input type="text" name="instructor_surname" id="edit-surname" class="form-control" placeholder="Soyad" required>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <input type="file" id="edit-image" name="instructor_image" class="form-control" accept="image/*">
                                                                <input type="hidden" name="instructor_id" value="" id="edit-li">
                                                            </div>
                                                            <div class="col-xxl-12 text-center">
                                                                <img id="edit-preview" src="" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; box-shadow: 0 0 8px rgba(0,0,0,0.15);">
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="edit-less" value="Güncelle">
                                                                </div>
                                                            </div>
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
                                                        <h4 class="fs-semibold">Eğitmen silinecek ? Emin misiniz?</h4>
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
        $(document).on('submit','#edit-instructor-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('edit_instructor', true);
            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.instructors.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#edit-instructor-modal').modal('hide');
                    $('#edit-instructor-form').trigger('reset');
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
        $(document).on('submit','#add-instructor-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('add_instructor', true);
            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.instructors.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#add-instructor-modal').modal('hide');
                    $('#add-instructor-form').trigger('reset');
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
                url: 'core/schedule/api.instructors.php',
                data: {delete_instructor: true, id: id},
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
        $(document).on('show.bs.modal','#edit-instructor-modal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.instructors.php',
                data: {get_instructor: true, id: id},
                success: function(data) {
                $('#edit-name').val(data.data.name);
                $('#edit-surname').val(data.data.surname);
                $('#edit-li').val(data.data.id);
                $('#edit-preview').attr('src', '../' + data.data.image);
                }
            });
        });
        $(document).on('show.bs.modal','#deleteModal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $('#delete-record').val(id);
        });
        $('#table-instructor').DataTable({
            "paging":   true,
            "searching": false,
            "lengthChange": false,
            language: {
                url: 'assets/json/tr.json',
            },
        });
        // Görsel dosyası seçildiğinde önizlemeyi güncelle
        $(document).on('change', 'input[name="instructor_image"]', function (e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#edit-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
        $('#edit-image').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#edit-preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
        $('#add-instructor-form input[name="instructor_image"]').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#add-preview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });
        $('#add-instructor-modal').on('hidden.bs.modal', function () {
            $('#add-preview').hide().attr('src', '');
        });

    </script>
</body>
</html>