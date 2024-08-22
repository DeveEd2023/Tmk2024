@extends('layouts.master')

@section('title', 'Inicio')
@section('style')
    <style>
        .carousel-container {
            margin-left: auto;
            margin-right: auto;
        }

        @media (min-width: 576px) {
            .carousel-container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .carousel-container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .carousel-container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .carousel-container {
                max-width: 95%;
            }
        }
    </style>
@endsection
@section('content')

    <section class="section">

        <div class="carousel-container">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                  
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="public/img/1_carousel.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="public/img/2_carousel.png" class="d-block w-100" alt="...">
                    </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div><!-- End Slides with captions -->
        </div>

    </section>

@endsection

@section('script')
