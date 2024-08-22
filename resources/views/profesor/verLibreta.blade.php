@extends('layouts.profesor')
@section('title', 'Intituciones')
@section('content')
    <section class="content">
        <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-12">
                <div id="vista" style="text-align: center;">
                    <h5 style="text-align: center;">
                        <a href="#" class="requestfullscreen" style="color: #58ac7c; text-decoration: none;">Click para
                            Ver en pantalla completa</a>
                        <a href="#" class="exitfullscreen" style="display: none ;color: #ffffff; text-decoration: none;">Click o Presiona ESC para Salir de
                            pantalla completa</a>
                    </h5>
                    <iframe id="vista" style="width: 100vw; height: 100vh;"
                        src="{{ URL::to('/') . '/public/recursos/' . $id . '/' . $grado . '/' . $materia . '/' . $archivo }}"
                        frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function deshabilitarClicDerecho(event) {
            event.preventDefault();
        }
        var iframe = document.getElementById('vista');
        iframe.onload = function() {
            var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
            iframeDocument.addEventListener("contextmenu", deshabilitarClicDerecho);
        };

        document.addEventListener('DOMContentLoaded', function() {
            var fullscreenButton = document.querySelector('.requestfullscreen');
            var exitFullscreenButton = document.querySelector('.exitfullscreen');
            var iframe = document.getElementById('vista');


            fullscreenButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (iframe.requestFullscreen) {
                    iframe.requestFullscreen();
                } else if (iframe.mozRequestFullScreen) {
                    iframe.mozRequestFullScreen();
                } else if (iframe.webkitRequestFullscreen) {
                    iframe.webkitRequestFullscreen();
                } else if (iframe.msRequestFullscreen) {
                    iframe.msRequestFullscreen();
                }
                fullscreenButton.style.display = 'none';
                exitFullscreenButton.style.display = 'inline';
            });

            // Función para salir de pantalla completa
            exitFullscreenButton.addEventListener('click', function(event) {
                event.preventDefault();
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
                fullscreenButton.style.display = 'inline';
                exitFullscreenButton.style.display = 'none';
            });


            iframe.addEventListener('fullscreenchange', function() {
                if (document.fullscreenElement === iframe) {
                    fullscreenButton.style.display = 'none';
                    exitFullscreenButton.style.display = 'inline';
                } else {
                    fullscreenButton.style.display = 'inline';
                    exitFullscreenButton.style.display = 'none';
                }
            });

            iframe.addEventListener('webkitfullscreenchange', function() {
                if (document.webkitFullscreenElement === iframe) {
                    fullscreenButton.style.display = 'none';
                    exitFullscreenButton.style.display = 'inline';
                } else {
                    fullscreenButton.style.display = 'inline';
                    exitFullscreenButton.style.display = 'none';
                }
            });

            iframe.addEventListener('mozfullscreenchange', function() {
                if (document.mozFullscreenElement === iframe) {
                    fullscreenButton.style.display = 'none';
                    exitFullscreenButton.style.display = 'inline';
                } else {
                    fullscreenButton.style.display = 'inline';
                    exitFullscreenButton.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.getElementById('vista').onload = function() {
            var iframeDocument = document.getElementById('vista').contentDocument || document.getElementById('vista')
                .contentWindow.document;

            var script = iframeDocument.createElement('script');
            script.innerHTML = `
    document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
    });
`;
            iframeDocument.body.appendChild(script);
        };
    </script>
    <script>
        function deshabilitarClicDerecho(event) {
            event.preventDefault();
        }
        window.onload = function() {
            document.addEventListener("contextmenu", deshabilitarClicDerecho);
        };
    </script>
@endsection
