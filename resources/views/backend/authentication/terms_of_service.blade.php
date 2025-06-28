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
                            <div class="card-body p-4">
                                <div class="d-inline-block mb-4">
                                    <img src="{{ mix('backend/images/logo.svg') }}" class="rounded-3 for-light-logo" alt="login">
                                    <img src="{{ mix('backend/images/white-logo.svg') }}" class="rounded-3 for-dark-logo" alt="login">
                                </div>
                                <h3 class="fs-28 mb-2">Terms Of Service</h3>
                                <ul class="ps-0 mb-0 list-unstyled">
                                    <li class="mb-4">
                                        <h4 class="fw-semibold fs-14">Desktop, Email, Chat, Purchase Notifications</h4>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </li>
                                    <li class="mb-4">
                                        <h4 class="fw-semibold fs-14">Delete This Account :</h4>
                                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                    </li>
                                    <li class="mb-4">
                                        <h4 class="fw-semibold fs-14">Two-factor Authentication</h4>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of.</p>
                                    </li>
                                    <li class="mb-4">
                                        <h4 class="fw-semibold fs-14">Secondary Verification</h4>
                                        <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing.</p>
                                    </li>
                                    <li class="mb-0">
                                        <h4 class="fw-semibold fs-14">Backup Codes</h4>
                                        <p>Lorem ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of lorem ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                    </li>
                                </ul>
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

    </body>
</html>