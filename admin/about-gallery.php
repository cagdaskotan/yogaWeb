<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();

require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/about/class.gallery.php");
require_once("core/class.func.php");

?>

<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"  data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Salon Galerisi - Şehirde Yoga Yönetim</title>
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
                                <h4 class="mb-sm-0">Salon Galerisi</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="flex-grow-1">
                                            <button class="btn btn-outline-danger add-btn" onclick="$('#gallery-upload').click();">
                                                <i class="ri-upload-2-line me-1 align-bottom"></i> Görsel Ekle
                                            </button>
                                            <input type="file" id="gallery-upload" name="images[]" multiple hidden>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xxl-8">
                                            <table id="table-gallery" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th data-ordering="false" style="width: 45px;">Sıra</th>
                                                        <th>Görsel</th>
                                                        <th class="text-end" style="width: 120px;">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    $cls = new AboutGallery();
                                                    foreach($cls->all() as $x){
                                                        $i++;
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td>
                                                            <img src="/yoga/<?=$x->image?>" alt="Galeri Görseli" style="height: 60px; border-radius: 6px;">
                                                        </td>
                                                        <td class="text-end">
                                                            <a class="btn btn-sm btn-danger btn-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-whatever="<?=$x->id?>">
                                                                <i class="ri-delete-bin-5-line" data-bs-toggle="tooltip" data-bs-placement="top" title="Sil"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="add-education-modal" tabindex="-1" aria-labelledby="gr-label"  data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Görsel Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-education-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <div>
                                                                    <input type="text" name="title" id="add-title" class="form-control" placeholder="Kurum" required>
                                                                    <input type="text" name="description" id="add-description" class="form-control mt-2" placeholder="Eğitim" required>
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
                                    
                                    <div class="modal fade zoomIn" id="deleteModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                </div>
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="fs-semibold">Görsel silinecek ? Emin misiniz?</h4>
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
        
        $('#delete-record').click(function (e) {
            e.preventDefault();
            var id = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'core/about/api.gallery.php',
                data: {delete_gallery: true, id: id},
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

        $(document).on('show.bs.modal','#deleteModal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $('#delete-record').val(id);
        });
        $('#table-gallery').DataTable({
            "paging":   true,
            "searching": false,
            "lengthChange": false,
            language: {
                url: 'assets/json/tr.json',
            },
        });
        $('#gallery-upload').on('change', function () {
            let formData = new FormData();
            let files = $(this)[0].files;

            for (let i = 0; i < files.length; i++) {
                formData.append('images[]', files[i]);
            }

            formData.append('add_gallery', true);

            $.ajax({
                type: 'POST',
                url: 'core/about/api.gallery.php',
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
                        close: true
                    }).showToast();
                    setInterval(function(){ window.location.reload(); }, 2000);
                }
            });
        });
        $(document).on('click', '.delete-image', function() {
            let id = $(this).data('id');

            $.ajax({
                type: 'POST',
                url: 'core/about/api.gallery.php',
                data: { delete_gallery: true, id: id },
                success: function(data) {
                    Toastify({
                        text: data.message,
                        duration: 2000,
                        gravity: "top",
                        position: 'center',
                        className: data.status == 200 ? "bg-danger" : "bg-warning",
                        close: true
                    }).showToast();
                    setInterval(function(){ window.location.reload(); }, 2000);
                }
            });
        });

    </script>
</body>
</html>