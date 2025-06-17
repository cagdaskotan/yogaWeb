<?php
ob_start();
session_save_path("../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();

require_once("../env/class.db.php");
require_once("core/users/class.users.php");
require_once("core/schedule/class.schedule.php");
require_once("core/schedule/class.classes.php");
require_once("core/schedule/class.instructors.php");
require_once("core/class.func.php");

$classes = new Classes();
$instructors = new Instructors();
$schedule = new Schedule();

?>

<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"  data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>Sınıf Takvimi - Şehirde Yoga Yönetim</title>
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
                                <h4 class="mb-sm-0">Takvim</h4>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <div class="flex-grow-1">
                                            <button class="btn btn-outline-primary add-btn" data-bs-toggle="modal" data-bs-target="#add-schedule-modal"><i class="ri-add-fill me-1 align-bottom"></i> Program Oluştur</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xxl-8">
                                            <table id="table-schedule" class="table table-bordered dt-responsive nowrap table-hover align-middle" style="width:100%">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Sıra</th>
                                                        <th>Sınıf</th>
                                                        <th>Eğitmen</th>
                                                        <th>Gün</th>
                                                        <th>Saat</th>
                                                        <th class="text-end">İşlemler</th>
                                                        <th class="text-end">Aktiflik</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;
                                                    foreach($schedule->all(false) as $item){
                                                        $i++;
                                                        $dayNames = ['','Pazartesi','Salı','Çarşamba','Perşembe','Cuma','Cumartesi','Pazar'];
                                                    ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?=$item->class_name?></td>
                                                        <td><?=$item->instructor_name . ' ' . $item->instructor_surname?></td>
                                                        <td><?=$dayNames[intval($item->schedule_day)]?></td>
                                                        <td><?=substr($item->start_time, 0, 5)?> - <?=substr($item->end_time, 0, 5)?></td>
                                                        <td class="text-end">
                                                            <a class="btn btn-sm btn-secondary btn-icon waves-effect waves-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#edit-schedule-modal"
                                                            data-bs-whatever="<?=$item->id?>">
                                                                <i class="ri-edit-line" data-bs-toggle="tooltip" data-bs-placement="top" title="Düzenle"></i>
                                                            </a>
                                                            <a class="btn btn-sm btn-danger btn-icon waves-effect waves-light"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal"
                                                            data-bs-whatever="<?=$item->id?>">
                                                                <i class="ri-delete-bin-5-line" data-bs-toggle="tooltip" data-bs-placement="top" title="Sil"></i>
                                                            </a>
                                                        </td>
                                                        <?php $checked = $item->is_active == 1 ? 'checked' : ''; ?>
                                                        <td class="text-end p-0">
                                                            <div class="form-check form-switch form-switch-md form-switch-success btn">
                                                                <input name="activate" value="<?=$item->id?>" class="form-check-input" type="checkbox" <?=$checked?> role="switch" title="Yayınla">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>          

                                    <div class="modal fade" id="add-schedule-modal" tabindex="-1" aria-labelledby="gr-label" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Program Ekle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="add-schedule-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <!-- Sınıf Seçimi -->
                                                            <div class="col-xxl-6">
                                                                <select name="class_id" class="form-select" required>
                                                                    <option value="">Sınıf Seçin</option>
                                                                    <?php foreach($classes->all() as $class): ?>
                                                                        <option value="<?=$class->id?>"><?=$class->class?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>

                                                            <!-- Eğitmen Seçimi -->
                                                            <div class="col-xxl-6">
                                                                <select name="instructor_id" class="form-select" required>
                                                                    <option value="">Eğitmen Seçin</option>
                                                                    <?php foreach($instructors->all() as $ins): ?>
                                                                        <option value="<?=$ins->id?>"><?=$ins->name . ' ' . $ins->surname?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>

                                                            <!-- Gün Seçimi -->
                                                            <div class="col-xxl-12">
                                                                <select name="schedule_day" class="form-select" required>
                                                                    <option value="">Gün Seçin</option>
                                                                    <option value="1">Pazartesi</option>
                                                                    <option value="2">Salı</option>
                                                                    <option value="3">Çarşamba</option>
                                                                    <option value="4">Perşembe</option>
                                                                    <option value="5">Cuma</option>
                                                                    <option value="6">Cumartesi</option>
                                                                    <option value="7">Pazar</option>
                                                                </select>
                                                            </div>

                                                            <!-- Saat Seçimi -->
                                                            <div class="col-xxl-12">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <input type="time" name="start_time" class="form-control timepicker" placeholder="Başlangıç Saati" required>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <input type="time" name="end_time" class="form-control timepicker" placeholder="Bitiş Saati" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Butonlar -->
                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" name="add-schedule" value="Ekle">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end row -->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="edit-schedule-modal" tabindex="-1" aria-labelledby="gr-label" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="gr-label">Programı Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="edit-schedule-form" class="needs-validation" novalidate>
                                                        <div class="row g-3">
                                                            <div class="col-xxl-6">
                                                                <label>Sınıf</label>
                                                                <select name="class_id" id="edit-class" class="form-select" required>
                                                                    <?php foreach ($classes->all() as $c): ?>
                                                                        <option value="<?=$c->id?>"><?=$c->class?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-xxl-6">
                                                                <label>Eğitmen</label>
                                                                <select name="instructor_id" id="edit-instructor" class="form-select" required>
                                                                    <?php foreach ($instructors->all() as $i): ?>
                                                                        <option value="<?=$i->id?>"><?=$i->name?> <?=$i->surname?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-xxl-12">
                                                                <label>Gün</label>
                                                                <select name="schedule_day" id="edit-day" class="form-select" required>
                                                                    <option value="1">Pazartesi</option>
                                                                    <option value="2">Salı</option>
                                                                    <option value="3">Çarşamba</option>
                                                                    <option value="4">Perşembe</option>
                                                                    <option value="5">Cuma</option>
                                                                    <option value="6">Cumartesi</option>
                                                                    <option value="7">Pazar</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xxl-6">
                                                                <label>Başlangıç Saati</label>
                                                                <input type="time" name="start_time" id="edit-start" class="form-control timepicker" required>
                                                            </div>
                                                            <div class="col-xxl-6">
                                                                <label>Bitiş Saati</label>
                                                                <input type="time" name="end_time" id="edit-end" class="form-control timepicker" required>
                                                            </div>
                                                            <input type="hidden" name="id" id="edit-id">
                                                            <div class="col-lg-12">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Vazgeç</button>
                                                                    <input type="submit" class="btn btn-primary" value="Güncelle">
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
        $(document).on('submit', '#edit-schedule-form', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('edit_schedule', true);

            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.schedule.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#edit-schedule-modal').modal('hide');
                    $('#edit-schedule-form').trigger('reset');

                    Toastify({
                        text: data.message,
                        duration: 2000,
                        close: true,
                        gravity: "top",
                        position: 'center',
                        className: "bg-success",
                    }).showToast();

                    setTimeout(() => { window.location.reload(); }, 2200);
                }
            });
        });
            
        $(document).on('submit','#add-schedule-form', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('add_schedule', true);

            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.schedule.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    $('#add-schedule-modal').modal('hide');
                    $('#add-schedule-form').trigger('reset');

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

                    setTimeout(() => { window.location.reload(); }, 2200);
                }
            });
        });

        $('#delete-record').click(function (e) {
            e.preventDefault();
            var id = $(this).val();
            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.schedule.php',
                data: {delete_schedule: true, id: id},
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
        $(document).on('show.bs.modal', '#edit-schedule-modal', function (e) {
            var id = e.relatedTarget.getAttribute("data-bs-whatever");

            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.schedule.php',
                data: { get_schedule: true, id: id },
                success: function (data) {
                    if (data.status === 200) {
                        $('#edit-id').val(data.data.id);
                        $('#edit-class').val(data.data.class_id);
                        $('#edit-instructor').val(data.data.instructor_id);
                        $('#edit-day').val(data.data.schedule_day);
                        $('#edit-start').val(data.data.start_time);
                        $('#edit-end').val(data.data.end_time);
                    }
                }
            });
        });

        $(document).on('show.bs.modal','#deleteModal', function (t) {
            var id = t.relatedTarget.getAttribute("data-bs-whatever");
            $('#delete-record').val(id);
        });
        $('#table-schedule').DataTable({
            "paging":   true,
            "searching": false,
            "lengthChange": false,
            language: {
                url: 'assets/json/tr.json',
            },
        });
        $(document).on('change','[name="activate"]', function(e){
            e.preventDefault();
            var id = $(this).val();
            var status = $(this).is(':checked') ? 'true' : 'false';
            $.ajax({
                type: 'POST',
                url: 'core/schedule/api.schedule.php',
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
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            allowInput: true
        });
    </script>
</body>
</html>