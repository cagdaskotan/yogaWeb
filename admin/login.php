<?php
ob_start();
session_start();
?>
<!doctype html>
<html lang="tr" data-layout="horizontal" data-topbar="dark" data-sidebar-size="lg" data-sidebar="light" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Şehirde Yoga Admin Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Şehirde Yoga" name="description" />
    <meta content="Z-Sistem" name="author" />

    <link rel="shortcut icon" href="/yoga/assets/images/favicon.png">
    <script src="assets/js/layout.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <style>
        .auth-bg-cover {
            background: linear-gradient(-45deg, #405189 50%, #0ab39c) !important;
        }

        .bg-overlay {
            background-image: url('assets/images/cover-bg.jpg') !important;
            opacity: 0.3 !important;
        }
    </style>
</head>

<body>
    <div class="auth-page-wrapper auth-bg-cover d-flex justify-content-center min-vh-100">
        <div class="bg-overlay"></div>
        <div class="auth-page-content overflow-hidden">
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-lg-8">
                        <div class="text-center">
                            <div class="mb-4">
                                <span class="logo-lg">
                                    <img src="/yoga/assets/images/favicon.png" alt="" height="100">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center mt-4">
                                    <h4 class="card-title mb-1">Hoşgeldiniz!</h4>
                                    <p class="text-muted mb-3">Yönetici bilgileriniz ile giriş yapınız.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    
                                    <div class="col-12 text-center mb-2 d-none" id="send-app-loader">
                                        <div class="spinner-border text-success">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <p class="text-muted"><em>Lütfen bekleyiniz...</em></p>
                                    </div>

                                    <div class="alert alert-danger d-none" role="alert" id="alert-result">

                                    </div>
                                    <form id="login-form" method="POST">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">E-Mail</label>
                                            <input type="text" name="email" class="form-control" id="email" placeholder="E-Mail">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Parola</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" name="password" class="form-control pe-5 password-input" placeholder="Parola" id="password-input" autocomplete="off">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>

                                            <div class="mb-3 mt-3 d-flex align-items-center gap-3 justify-content-center">
                                                <img src="../libs/captcha/makecaptcha.php?rand=<?= rand() ?>" id="captcha" class="captcha-img">
                                                <input type="text" name="securityCode" id="securityCode" class="form-control" placeholder="Güvenlik Kodu" style="max-width: 200px;">
                                                <a href="javascript:void(0)" id="reloadCaptcha" class="btn btn-outline-danger btn-sm">
                                                    <i class="ri-refresh-line"></i>
                                                </a>
                                            </div>

                                            <!-- <div class="float-end mb-2">
                                                <a href="password.php" class="text-muted">Parolamı unuttum?</a>
                                            </div> -->
                                        </div>
                                        <div class="mt-4">
                                            <input type="submit" name="login" value="Giriş" class="btn btn-success w-100" />
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">
                                © <?= date('Y') ?> Şehirde Yoga
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src='assets/js/jquery.js'></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src='assets/js/toastify.js'></script>
    <script src='assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>
    <script src='assets/libs/flatpickr/flatpickr.min.js'></script>
    <script src="assets/libs/cleave.js/cleave.min.js"></script>
    <script src="assets/libs/cleave.js/addons/cleave-phone.tr.js"></script>
    <script>
        $(document).ready(function(){
            $(document).on('submit','#login-form',function(e){
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('login_admin', true);
                $.ajax({
                    type: 'POST',
                    url: 'core/login/api.login.php',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#send-app-loader').removeClass('d-none');
                    },
                    success: function(r) {
                        if (r.status == 'error') {
                            $('#alert-result').removeClass('d-none').text(r.message);
                            $('#send-app-loader').addClass('d-none');
                            var captchaImage = $('#captcha').attr('src');
                            captchaImage = captchaImage.split('?')[0] + "?rand=" + Date.now();
                            $('#captcha').attr('src', captchaImage);
                        } else {
                            $('#alert-result').addClass('d-none').text('');
                            setTimeout(function() {
                                window.location.href = 'index.php';
                            }, 2000);
                        }
                    }

                });
            });
            $("#reloadCaptcha").click(function() {
                var captchaImage = $('#captcha').attr('src');
                captchaImage = captchaImage.split('?')[0] + "?rand=" + Date.now();
                $('#captcha').attr('src', captchaImage);
            });
            $(document).on('click', '#password-addon', function(e) {
                e.preventDefault();
                if ($('#password-input').attr('type') == 'password') {
                    $('#password-input').attr('type', 'text');
                    $('#password-addon').html('<i class="ri-eye-off-fill align-middle"></i>');
                } else {
                    $('#password-input').attr('type', 'password');
                    $('#password-addon').html('<i class="ri-eye-fill align-middle"></i>');
                }
            });
        });        
    </script>
</body>

</html>