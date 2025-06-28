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
                    <form style="max-width: 550px;">
                        <div class="card bg-white border-0 rounded-10 mb-4 text-center">
                            <div class="card-body p-4">
                                <div class="mb-3 mb-md-4">
                                    <img src="{{ mix('backend/images/logo.svg') }}" alt="logo">
                                </div>
                                <img src="{{ $status ? mix('backend/images/success.png') : mix('backend/images/error.png') }}" class="mb-3 mb-md-4" alt="message">
                                <h4 class="fs-20 fw-semibold mb-2">Konfirmasi Email {{ $status ? 'Berhasil' : 'Gagal' }}</h4>
                                <p class="mb-4">{{ $status ? 'Silahkan Login Untuk Melanjutkan' : 'Tautan Konfirmasi Email Tidak Valid atau Sudah Tidak Berlaku, Silahkan Klik Untuk Mengirim Ulang Tautan Konfirmasi' }}</p>

                                @if ($status)
                                <a href="{{ route('authentication.login') }}" class="btn btn-primary fs-16 fw-medium text-dark py-2 px-4 text-white w-100">
                                    Login
                                </a>
                                @else 
                        
                                <button class="btn btn-primary fw-medium py-2 px-3 w-100" id="submit-btn">
                                    <div class="d-flex align-items-center justify-content-center py-1">
                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="spinner"></span>
                                        <i id="icon-submit" class="material-symbols-outlined text-white fs-20 me-2">autorenew</i>
                                        <span id="btn-text">Kirim Ulang</span>
                                    </div>
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
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

        @if (!$status)

        <script>

        $(document).ready(function () {
            $('#submit-btn').on('click', function (e) {
                e.preventDefault();

                $('#submit-btn').prop('disabled', true);
                $('#spinner').removeClass('d-none');
                $('#icon-submit').addClass('d-none');
                $('#btn-text').text('Loading...');

                $.ajax({
                    url: "{{ route('authentication.confirm_email_resend', $token) }}",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {

                        if (response.success) {

                            Swal.fire({
                                icon: "success",
                                title: 'Tautan Berhasil Dikirim',
                                text: response.message || 'Silahkan Klik Untuk Melanjutkan'
                            }).then((result) => {
                                window.location.href = response.data.redirectTo;
                            })

                        } else {

                            Swal.fire({
                                icon: "error",
                                title: 'Tautan Gagal Dikirim',
                                text: response.message || 'Silahkan Coba Lagi',
                            })

                        }

                    },
                    error: function (xhr) {

                        Swal.fire({
                            icon: "error",
                            title: 'Tautan Gagal Dikirim',
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

        @endif

    </body>
</html>