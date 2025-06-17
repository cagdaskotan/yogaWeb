<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/class.func.php");
?>
<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Dosya Yönetimi - Şehirde Yoga Yönetim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="TUSEKON" name="description" />
    <meta content="Z-Sistem" name="author" />

    <link rel="shortcut icon" href="assets/images/favicon.png">

    <link rel="stylesheet" href="assets/libs/dropzone/dropzone.css" type="text/css" />
    <link rel="stylesheet" href="assets/libs/glightbox/css/glightbox.min.css">
    <link rel="stylesheet" href="assets/libs/sweetalert2/sweetalert2.min.css" type="text/css" />

    <script src="assets/js/layout.js"></script>
    <link href="assets/libs/datatables/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="assets/libs/datatables/css/responsive.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/libs/datatables/css/buttons.dataTables.min.css" rel="stylesheet" />
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
                                <h4 class="mb-sm-0">Dosya Yönetimi</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form action="core/uploads/api.uploads.php" method="post" enctype="multipart/form-data" class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                    </div>
                                                    <h4>Dosyaları buraya bırakın veya yüklemek için tıklayın.</h4>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="card-header d-flex justify-content-start align-item-center">
                                            <div class="col-auto me-1">
                                                <select class="form-select form-select-sm" id="page-length">
                                                    <option value="-1">Tümü</option>
                                                    <option value="5" selected>5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="50">50</option>
                                                </select>
                                            </div>
                                            <div class="col-auto me-1">
                                                <input type="text" class="form-control form-control-sm" id="search" placeholder="Ara...">
                                            </div>
                                        </div>


                                        <div class="table-responsive">
                                            <table id="table-files" class="table align-middle table-bordered table-hover mt-4">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th class="text-center">Önizleme</th>
                                                        <th>Dosya Adı</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $folder_path = '../media/gallery';
                                                    $files = scandir($folder_path);
                                                    $files = array_diff(scandir($folder_path), array('.', '..'));
                                                    foreach ($files as $file) {
                                                        $file_info = pathinfo($folder_path . '/' . $file);
                                                        if (isset($file_info['extension'])) {
                                                            $extension = strtolower($file_info['extension']);
                                                            if (in_array($extension, array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
                                                            ?>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <a class="image-popup" href="<?= $folder_path . '/' . $file ?>" title="">
                                                                            <img class="gallery-img img-fluid mx-auto" src="<?= $folder_path . '/' . $file ?>" alt="" style="max-height: 100px; object-fit: cover; border-radius: 6px;" />
                                                                        </a>
                                                                    </td>
                                                                    <td>
                                                                        <p class="overlay-caption"><?= $file ?></p>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="<?= $folder_path . '/' . $file ?>" class="btn btn-sm btn-primary btn-icon waves-effect" download><i class="ri-download-2-line"></i></a>
                                                                        <button type="button" name="delete" target="<?= $file ?>" class="btn btn-sm btn-danger btn-icon waves-effect waves-light">
                                                                            <i class="ri-delete-bin-5-line"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- container-fluid -->
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
    <script src='assets/js/toastify.js'></script>
    <script src='assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>
    <script src='assets/libs/flatpickr/flatpickr.min.js'></script>
    <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.responsive.min.js"></script>

    <script src="assets/libs/dropzone/dropzone-min.js"></script>
    <script src="assets/libs/glightbox/js/glightbox.min.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/libs/isotope-layout/isotope.pkgd.min.js"></script>

    <script src="assets/js/pages/gallery.init.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function() {
            $('[name="delete"]').click(function() {
                var target = $(this).attr('target');
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Dosya silinecek!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, Sil!',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'core/uploads/api.uploads.php',
                            type: 'post',
                            data: {
                                delete: true,
                                target: target
                            },
                            success: function(data) {
                                console.log(data.status);
                                if (data.status == 200) {
                                    new Toastify({
                                        text: data.message,
                                        duration: 2000,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: 'center',
                                        className: "bg-success",
                                        stopOnFocus: true,
                                    }).showToast();
                                    setInterval(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                                if (data.status == 300) {
                                    new Toastify({
                                        text: data.message,
                                        duration: 2000,
                                        newWindow: true,
                                        close: true,
                                        gravity: "top",
                                        position: 'center',
                                        className: "bg-danger",
                                        stopOnFocus: true,
                                    }).showToast();
                                    setInterval(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    }
                });
            });

            var table = $('#table-files').DataTable({
                language: {
                    url: 'assets/json/tr.json',
                },
                order: [
                    [0, 'asc']
                ],
                pageLength: 5,
                initComplete: function() {
                    $('#table-files_filter').hide();
                    $('#table-files_length').hide();
                }
            });
            $('#page-length').on('change', function() {
                var length = $(this).val();
                table.page.len(length).draw();
            });
            $('#search').on('keyup', function() {
                table.search($(this).val()).draw();
            });
        });

        Dropzone.autoDiscover = false;

        // Dropzone options
        var myDropzone = new Dropzone(".dropzone", {
            url: 'core/uploads/api.uploads.php',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 5, // MB
            maxFiles: 5,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            dictDefaultMessage: "Dosyaları buraya sürükleyin veya tıklayın",
            dictRemoveFile: "Dosyayı kaldır",
            init: function() {
                this.on("success", function(file, response) {
                    window.location.href = "file-manager.php";
                });
                this.on("error", function(file, errorMessage) {
                    console.log("Dosya yükleme hatası: " + errorMessage);
                });
            }
        });
    </script>

</body>
</html>