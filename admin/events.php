<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();
require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/events/class.events.php");
require_once("core/class.func.php");
?>
<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>Etkinlikler - Şehirde Yoga Yönetim</title>
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
                                <h4 class="mb-sm-0">Etkinlikler</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="flex-grow-1">
                                            <button class="btn btn-outline-primary add-btn" data-bs-toggle="modal" data-bs-target="#add-event-modal"><i class="ri-add-fill me-1 align-bottom"></i> Etkinlik Oluştur</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xxl-12">
                                            <table id="table-event" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th data-ordering="false" style="width: 45px;">Sıra</th>
                                                        <th>Başlık</th>
                                                        <th>Başlangıç Tarihi</th>
                                                        <th>Bitiş Tarihi</th>
                                                        <th style="width: 100px;">İşlemler</th>
                                                        <th class="text-end" style="width: 100px;">Aktiflik</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $months = [
                                                        'January' => 'Ocak', 'February' => 'Şubat', 'March' => 'Mart',
                                                        'April' => 'Nisan', 'May' => 'Mayıs', 'June' => 'Haziran',
                                                        'July' => 'Temmuz', 'August' => 'Ağustos', 'September' => 'Eylül',
                                                        'October' => 'Ekim', 'November' => 'Kasım', 'December' => 'Aralık'
                                                    ];
                                                    $i = 0;
                                                    foreach($events->all() as $x){
                                                        $i++;
                                                        $startDate = date("d F Y", strtotime($x->start_date));

                                                        if (!empty($x->end_date) && $x->end_date != '0000-00-00') {
                                                            $endDate = date("d F Y", strtotime($x->end_date));
                                                        } else {
                                                            $endDate = "-";
                                                        }
                                                        foreach ($months as $en => $tr) {
                                                            $startDate = str_replace($en, $tr, $startDate);
                                                            $endDate = str_replace($en, $tr, $endDate);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?=$x->title?></td>
                                                        <td><?= $startDate ?></td>
                                                        <td><?= $endDate ?></td>
                                                        <td class="text-end">
                                                              

                                                            <a href="events-article-manager.php?event_id=<?=md5('zsistem'.$x->id)?>" class="btn btn-sm btn-primary btn-icon waves-effect waves-light">
                                                                <i class="ri-add-line" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="İçerik Ekle"></i>
                                                            </a>                                                         
                                                            <a id="<?=$x->id?>" data-bs-whatever="<?=$x->id?>" data-bs-toggle="modal" data-bs-target="#edit-event-modal" class="btn btn-sm btn-secondary btn-icon waves-effect waves-light">
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
                                    
                                    <div class="modal fade" id="add-event-modal" tabindex="-1" aria-labelledby="gr-label" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Etkinlik Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-event-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">

                                                            <div class="col-xxl-12">
                                                                <input type="text" name="add_title" class="form-control" id="event-title" placeholder="Başlık" required>
                                                            </div>

                                                            <div class="col-xxl-12">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                    <input type="text" name="add_start_date" class="form-select" id="event-start" placeholder="Başlangıç Tarihi" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                    <input type="text" name="add_end_date" class="form-select" id="event-end" placeholder="Bitiş Tarihi">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="add_event" value="Ekle">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="edit-event-modal" tabindex="-1" aria-labelledby="gr-label" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Etkinlik Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-event-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-12">
                                                                <label for="edit-event-title" class="form-label">Etkinlik Başlığı</label>
                                                                <input type="text" name="edit_title" class="form-control" id="edit-event-title" placeholder="Başlık" required>
                                                            </div>

                                                            <div class="col-xxl-12">
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                    <label for="edit-event-start" class="form-label">Başlangıç Tarihi</label>
                                                                    <input type="text" name="edit_start_date" class="form-select" id="edit-event-start" placeholder="Başlangıç Tarihi" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                    <label for="edit-event-end" class="form-label">Bitiş Tarihi</label>
                                                                    <input type="text" name="edit_end_date" class="form-select" id="edit-event-end" placeholder="Bitiş Tarihi">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <input type="hidden" name="event_id" id="event-id" value="">

                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="edit_event" value="Güncelle">
                                                                </div>
                                                            </div>
                                                        </div>
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
                                                        <h4 class="fs-semibold">Etkinlik silinecek ? Emin misiniz?</h4>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
    <script src="assets/libs/datatables/js/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/datatables/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/libs/datatables/js/dataTables.responsive.min.js"></script>

    <script src="assets/js/pages/form-validation.init.js"></script>

    <script src="assets/js/app.js"></script>

    <script>

        $(document).on('submit','#edit-event-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('edit_event', true);
            formData.append('title', $('[name="edit_title"]').val());
            formData.append('start_date', $('[name="edit_start_date"]').val());
            formData.append('end_date', $('[name="edit_end_date"]').val());

            $.ajax({
                type: 'POST',
                url: "core/events/api.events.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#edit-event-modal').modal('hide');
                    $('#edit-event-form').trigger('reset');
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
                var data = {id: id, activate: "true"};
            }else{
                var data = {id: id, activate: "false"};
            }
            $.ajax({
                type: 'POST',
                url: "core/events/api.events.php",
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
                    setInterval(function(){ window.location.reload(); }, 2200);
                }
            });
        });
        $(document).on('submit','#add-event-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('add_event', true);
            formData.append('title', $('[name="add_title"]').val());
            formData.append('start_date', $('[name="add_start_date"]').val());
            formData.append('end_date', $('[name="add_end_date"]').val());

            $.ajax({
                type: 'POST',
                url: "core/events/api.events.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#add-event-modal').modal('hide');
                    $('#add-event-form').trigger('reset');
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
                url: "core/events/api.events.php",
                data: {delete_event: true, id: id},
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
        $('#table-event').DataTable({
            "paging":   true,
            "searching": true,
            "lengthChange": true,
            language: {
                url: 'assets/json/tr.json',
            },
        });        
        $(document).on('show.bs.modal','#edit-event-modal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            var event_id = t.relatedTarget.getAttribute("id");
            $.ajax({
                type: 'POST',
                url: "core/events/api.events.php",
                data: {prep_event: true, id: id},
                success: function(data) {
                    $('#edit-event-title').val(data.title);
                    $('#edit-event-start').val(data.start_date);
                    $('#edit-event-end').val(data.end_date);
                    $('#event-id').val(data.id);
                }
            });
        });
        $(document).on('show.bs.modal','#deleteModal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $('#delete-record').val(id);
        });
        flatpickr("#event-start", { dateFormat: "Y-m-d", locale: "tr" });
        flatpickr("#event-end", { dateFormat: "Y-m-d", locale: "tr" });
        flatpickr("#edit-event-start", { dateFormat: "Y-m-d", locale: "tr" });
        flatpickr("#edit-event-end", { dateFormat: "Y-m-d", locale: "tr" });
    </script>
</body>

</html>