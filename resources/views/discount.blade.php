<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('images/icon.jpg') }}" rel="icon" type="image/gif">
    <title>K2 Support</title>

    @include('templates.TagHeader')

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Main.css') }}">



    {{-- Pusher Broadcast --}}
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    {{-- Bootstrap 4 Chartjs pie chart --}}
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>

</head>

<body>

    @include('component.Loading')


    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        @include('component.Left_Navbar')

        <div class="page-wrapper">

            <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="page-title mb-0 p-0">เพิ่มส่วนลด</h3>
                        <div class="d-flex align-items-center">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">เพิ่มส่วนลด</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid main-content">

                @include('component.footer')

            </div>

        </div>

    </div>


</body>

</html>



<script>
    $(document).ready(function() {


    });
</script>
