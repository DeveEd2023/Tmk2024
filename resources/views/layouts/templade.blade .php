<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Timonel @yield('title')</title>

    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    @section('style')
    @show
</head>

<body style="background-color: white">

    <header id="header" class="header fixed-top d-flex align-items-center" style="background-color:#57ad7a;">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="logo d-flex align-items-center" style="color:white;">
                <img src="img/lgt.png" alt="timonel" ">
            </a>
            <i class=" bi bi-list toggle-sidebar-btn"style=" color:white;"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="img/user.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2" style="color: white;">
                            <p class="m-0"></p>
                        </span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">

                            <span>Administrador</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
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

            <!-- agenda -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-calendar3"></i>
                    <span>Agenda escolar</span>
                </a>
            </li>
            <!-- Libreta digital -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bx bxs-folder-open"></i>
                    <span>Libreta digital</span>
                </a>
            </li>

            <!-- Aula Ova -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="https://aulaova.aprendamosjuntosedisal.com/" target="_blank">
                    <i class="ri-external-link-fill"></i>
                    <span>Aula Ova</span>
                </a>
            </li>
            <!-- Macmillan Education -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="https://www.macmillaneducationeverywhere.com/" target="_blank">
                    <i class="ri-external-link-fill"></i>
                    <span>Macmillan Education</span>
                </a>
            </li>
            <!-- Macmillan Practice Online -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="https://www.macmillanpracticeonline.com/MPO/" target="_blank">
                    <i class="ri-external-link-fill"></i>
                    <span>Macmillan Practice Online</span>
                </a>
            </li>
            <!-- Formacion docente -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="ri-share-forward-fill"></i>
                    <span>Formaci&oacute;n Docente</span>
                </a>
            </li>



            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Administrar</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{url('/')}}">
                            <i class="bx bxs-institution"></i><span> Instituciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-accordion.html">
                            <i class="ri-user-search-line"></i><span> Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-badges.html">
                            <i class="bx bxs-chevrons-up"></i><span> Grados</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-breadcrumbs.html">
                            <i class="ri-bookmark-fill"></i><span>Secciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-buttons.html">
                            <i class="ri-file-edit-line"></i><span>Materias</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-cards.html">
                            <i class="ri-shield-user-line"></i><span>Profesores</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-carousel.html">
                            <i class="ri-user-star-line"></i><span>Alumnos</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-list-group.html">
                            <i class="ri-share-fill"></i><span>Extenci&oacute;n de libreta</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-modal.html">
                            <i class="bi bi-card-image"></i><span> Im&aacute;genes Carousel</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-tabs.html">
                            <i class="bx bxl-blogger"></i><span> Blog</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-pagination.html">
                            <i class="bx bxs-pencil"></i><span> Recurso did&aacute;ctico</span>
                        </a>
                    </li>
                    <li>
                        <a href="components-progress.html">
                            <i class=" ri-link"></i><span> Sitios</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>


    <main id="main" class="main">
        @section('content')
        @show
    </main>






    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer pie">
        <div class="copyright">
            &copy; Copyright <strong><a style="color: white" href="http://www.editorialedisal.com/" target="_blank">editorialedisal.com </a>2024</strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });
    </script>
    @section('script')
    @show
</body>

</html>