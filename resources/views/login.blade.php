<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <meta content="width=device-width, initial-scale=1.0" name="viewport">



    <title>Login </title>

    <meta content="" name="description">

    <meta content="" name="keywords">





    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">

    <link

        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"

        rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">

    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">

    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">

    <style>

        body {

            background-image: url('img/imgK.webp');

            background-size: cover;

            background-repeat: no-repeat;

            background-position: center;

    

  

            margin: 0;

            padding: 0;

            height: 100vh;



            display: flex;

            align-items: center;

            justify-content: center;



        }

body::before {

  content: "";

  position: absolute;

  top: 0;

  left: 0;

  width: 100%;

  height: 100%;

  background-color: rgba(0, 0, 0, 0.3);

}

        .contenido {

            color: white;

            font-size: 24px;

        }

    </style>



</head>





<body style="background-image: url('img/imgK.webp');  ">



    <main>

        <div style="margin: auto">

            <x-alerta />

        </div>

        <div class="d-flex justify-content-center align-items-center" style="height:80vh;">



            <div class="card shadow"

                style="width: 330px; border: 1px solid #ccc; background-color: #fff; padding: 20px; border-radius:5%;">

                <img src="{{ asset('img/icono.png') }}" alt="" class="mx-auto d-block"

                    style="max-width: 35%;"><br>

                <h2 style="text-align: center; margin-bottom: 20px; font-family: Franklin Gothic Medium;">

                    Timonel</h2>

                <form action="{{ url('acceso') }}" method="post">

                    @csrf

                    <div class="mb-3">

                        <label for="username" class="form-label">

                            <i class="ri-user-3-fill" style="color: #57ad7a"></i> Nombre de Usuario:</label>

                        <input type="text" class="form-control" id="username" name="username" required>

                    </div>

                    <div class="mb-3">

                        <label for="password" class="form-label"> <i class="ri-lock-password-fill"

                                style="color: #57ad7a"></i>

                            Contraseña:</label>

                        <input type="password" class="form-control" id="password" name="password" required>

                    </div>

                    <div class="d-grid gap-2">

                        <button type="submit" class="btn btn-success" style="background-color: #57ad7a">Iniciar

                            Sesión</button>

                    </div>

                </form>

            </div>

        </div>

    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i

            class="bi bi-arrow-up-short"></i></a>

    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/vendor/chart.js/chart.umd.js"></script>

    <script src="assets/vendor/echarts/echarts.min.js"></script>

    <script src="assets/vendor/quill/quill.min.js"></script>

    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

    <script src="assets/vendor/tinymce/tinymce.min.js"></script>

    <script src="assets/vendor/php-email-form/validate.js"></script>

    <script src="assets/js/main.js"></script>

</body>



</html>

