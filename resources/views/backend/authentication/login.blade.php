<!DOCTYPE html>
<html lang="zxx">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link rel="stylesheet" href="{{ mix('backend/css/sidebar-menu.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/simplebar.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/apexcharts.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/prism.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/rangeslider.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/quill.snow.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/google-icon.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/remixicon.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/fullcalendar.main.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/jsvectormap.min.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/lightpick.css') }}">
        <link rel="stylesheet" href="{{ mix('backend/css/style.css') }}">
		
		<link rel="icon" type="image/png" href="{{ mix('backend/images/favicon.png') }}">
        <title>{{ $title ?? env('APP_NAME') }}</title>

    </head>
    <body class="boxed-size bg-white">
        
        @include('backend.section.loader')

        <div class="container">
            <div class="main-content d-flex flex-column p-0">
                <div class="m-auto m-1230">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="mw-480 ms-lg-auto">
                                <div class="d-inline-block mb-4">
                                    <img src="{{ mix('backend/images/logo.svg') }}" class="rounded-3 for-light-logo" alt="login">
                                    <img src="{{ mix('backend/images/white-logo.svg') }}" class="rounded-3 for-dark-logo" alt="login">
                                </div>
                                <h3 class="fs-28 mb-2">Selamat Datang di {{ env('APP_NAME') }}</h3>
                                <p class="fw-medium fs-16 mb-4">Silahkan Masuk Menggunakan Akses Anda</p>
                                
                                <form id="form">
                                    <div class="form-group mb-4">
                                        <label class="label text-secondary">Email</label>
                                        <input type="email" class="form-control h-55" placeholder="Masukkan Email" name="email">
                                    </div>
                                    <div class="form-group mb-4">
                                        <label class="label text-secondary">Kata Sandi</label>
                                        <input type="password" class="form-control h-55" placeholder="Masukkan Kata Sandi" name="password">
                                    </div>
                                    <div class="form-group mb-4">
                                        <a href="{{ route('authentication.forgot_password') }}" class="text-decoration-none text-primary fw-semibold">Lupa Kata Sandi?</a>
                                    </div>
                                    <div class="form-group mb-4">
                                        <button class="btn btn-primary fw-medium py-2 px-3 w-100" id="submit-btn">
                                            <div class="d-flex align-items-center justify-content-center py-1">
                                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="spinner"></span>
                                                <i id="icon-submit" class="material-symbols-outlined text-white fs-20 me-2">login</i>
                                                <span id="btn-text">Masuk</span>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <p>Belum Mempunyai Akun? <a href="{{ route('authentication.registration') }}" class="fw-medium text-primary text-decoration-none">Daftar Sekarang</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     
        <script src="{{ mix('backend/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ mix('backend/js/sidebar-menu.js') }}"></script>
        <script src="{{ mix('backend/js/dragdrop.js') }}"></script>
        <script src="{{ mix('backend/js/rangeslider.min.js') }}"></script>
        <script src="{{ mix('backend/js/quill.min.js') }}"></script>
        <script src="{{ mix('backend/js/data-table.js') }}"></script>
        <script src="{{ mix('backend/js/prism.js') }}"></script>
        <script src="{{ mix('backend/js/clipboard.min.js') }}"></script>
        <script src="{{ mix('backend/js/feather.min.js') }}"></script>
        <script src="{{ mix('backend/js/simplebar.min.js') }}"></script>
        <script src="{{ mix('backend/js/apexcharts.min.js') }}"></script>
        <script src="{{ mix('backend/js/echarts.min.js') }}"></script>
        <script src="{{ mix('backend/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ mix('backend/js/fullcalendar.main.js') }}"></script>
        <script src="{{ mix('backend/js/jsvectormap.min.js') }}"></script>
        <script src="{{ mix('backend/js/world-merc.js') }}"></script>
        <script src="{{ mix('backend/js/moment.min.js') }}"></script>
        <script src="{{ mix('backend/js/lightpick.js') }}"></script>
        <script src="{{ mix('backend/js/custom/apexcharts.js') }}"></script>
        <script src="{{ mix('backend/js/custom/echarts.js') }}"></script>
        <script src="{{ mix('backend/js/custom/custom.js') }}"></script>
        <script src="{{ mix('backend/js/jquery.js') }}"></script>
        <script src="{{ mix('backend/js/swal.js') }}"></script>

        <script>

        $(document).ready(function () {
            $('#form').on('submit', function (e) {
                e.preventDefault();

                $('#submit-btn').prop('disabled', true);
                $('#spinner').removeClass('d-none');
                $('#icon-submit').addClass('d-none');
                $('#btn-text').text('Loading...');

                $.ajax({
                    url: "{{ route('authentication.login') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {

                        if (response.success) {

                            Swal.fire({
                                icon: "success",
                                title: 'Login Berhasil',
                                text: response.message || 'Silahkan Klik Untuk Melanjutkan'
                            }).then((result) => {
                                window.location.href = response.data.redirectTo;
                            })

                        } else {

                            Swal.fire({
                                icon: "error",
                                title: 'Login Gagal',
                                text: response.message || 'Silahkan Coba Lagi',
                            })

                        }

                    },
                    error: function (xhr) {

                        Swal.fire({
                            icon: "error",
                            title: 'Login Gagal',
                            html: xhr.responseJSON.message || 'Silahkan Coba Lagi',
                        })
                        
                        $('#submit-btn').prop('disabled', false);
                        $('#spinner').addClass('d-none');
                        $('#icon-submit').removeClass('d-none');
                        $('#btn-text').text('Masuk');

                    },
                    complete: function () {
                        $('#submit-btn').prop('disabled', false);
                        $('#spinner').addClass('d-none');
                        $('#icon-submit').removeClass('d-none');
                        $('#btn-text').text('Masuk');
                    }
                });
            });
        });

        </script>

    </body>
</html>