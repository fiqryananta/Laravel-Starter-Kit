<!DOCTYPE html>
<html lang="zxx">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		@include('backend.section.styles')
		
		<link rel="icon" type="image/png" href="{{ mix('backend/images/favicon.png') }}">

        <title>{{ $title ?? env('APP_NAME') }}</title>

    </head>

    <body class="boxed-size">

        @include('backend.section.loader')

        @include('backend.section.navigation')

        <div class="container-fluid">
            <div class="main-content d-flex flex-column">

                @include('backend.section.header')

                @yield('content')

                <div class="flex-grow-1"></div>

                @include('backend.section.footer')

            </div>
        </div>

        @include('backend.section.scripts')

    </body>

</html>