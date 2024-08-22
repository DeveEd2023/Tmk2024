<!DOCTYPE html>
<html lang="es " style="zoom: 90%; ">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Timonel @yield('title')</title>

    <link rel="icon" href="{{ asset('public/img/favicon.png') }}" type="image/x-icon">
    <link href="{{ asset('public/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/AdminLTE.css') }}" rel="stylesheet">
    <style>
        .modal-backdrop {
            position: fixed;
            width: 100%;
            height: 100%;
        }
    </style>
    @section('style')
    @show
</head>

<body style="background-color: white">

    <header id="header" class="header fixed-top d-flex align-items-center" style="background-color:#57ad7a;">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between">
            <a href="/" class="" style="color:white;">
                <img src="{{ asset('public/img/lgt.png') }}" alt="timonel" width="200px" height="auto"
                    style="margin-right: 25px;">
            </a>
        </div>


        <i class="bi bi-list toggle-sidebar-btn "
            style="color:white; margin-right: 10px;  background-color: #57ad7a"></i>


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown" style="margin-right: 90px;">
                        <img src="{{ asset('public/img/user.jpg') }}" alt="Profile" class="rounded-circle">

                        <span class="d-none d-md-block dropdown-toggle ps-2" style="color: white;">

                            {{ $datoNombre }} {{ $datoApellido }}
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">

                            @if ($datoRoll == 1)
                                <span>Administrador</span>
                            @elseif ($datoRoll == 2)
                                <span>Profesor</span>
                            @elseif ($datoRoll == 3)
                                <span>Alumno</span>
                            @endif
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="">
                                <i class="bi bi-person"></i>
                                <span> {{ $datoNombre }} {{ $datoApellido }}</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('salir') }}">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Salir</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item ">
                <a class="nav-link  " style="background-color: #fff; color:black; ">

                    <h4>Men&uacute;</h4>
                </a>
            </li><!-- End Dashboard Nav -->

            <!-- home-->
            <li class="nav-item">
                <a class="nav-link collapsed" href="/">
                    <i class="bi bi-house-fill"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <!-- Libreta digital -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ url('alumno/recursos/' . $userid) }}">
                    <i class="bx bxs-folder-open"></i>
                    <span>Libreta digital</span>
                </a>
            </li>
            <!-- Agenda
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bx bx-calendar"></i>
                    <span>Agenda</span>
                </a>
            </li>
           Tarea
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bx bx-book"></i>
                    <span>Tarea</span>
                </a>
            </li>

       clase intrgrada
                <a class="nav-link collapsed" href="#">
                    <i class="ri-computer-line
                    "></i>
                    <span>Clase integrada</span>
                </a>
            </li>
        notas
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="ri-pencil-fill"></i>
                    <span>Notas</span>
                </a>
            </li> -->
            <hr style="color: #58ac7c; border-width: 4px;">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ url('salir') }}">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Salir</span>
                </a>
            </li>
        </ul>
    </aside>
    <main id="main" class="main" style="margin-bottom: 20px;">
        <x-alerta />
        @section('content')
        @show
    </main>
    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer "
        style="background-color: black;   
    position:fixed;
   left:0px;
   bottom:0px;
   height:30px;
   width:100%;">
        <div class="copyright"style="bottom: 100px">
            &copy; Copyright <strong><a style="color: white;" href="http://www.editorialedisal.com/"
                    target="_blank">editorialedisal.com </a>2024</strong>. All
            Rights Reserved
        </div>
    </footer><!-- End Footer -->
    <!-- Vendor JS Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('public/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('public/assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('contextmenu', function(e) {
                e.preventDefault();
            });
        });
    </script>
    @section('script')
    @show
</body>

</html>
