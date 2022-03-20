@extends('layouts.app')

@section('css')
    <style>
        .container {
            height: 80vh;
        }
        .student-img {
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid container">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 col-md-6 text-left">
                <div class="display-5">CCompanion</div> 
                <div class="lead fa-2x text-secondary">Your <i>partner</i> on any journey you take on.</div>
                <div class="lead text-secondary mt-4 fa-1x">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa, non mollitia itaque a natus laborum cupiditate quam tenetur aspernatur libero necessitatibus ex id unde ad ea velit eos alias possimus!
                </div>
            </div>
            <div class="col-md-6">
                <img src="images/bg.svg" class="student-img">
            </div>
        </div>
    </div>
    <div class="mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" style="height: 30vh">
                        <div class="carousel-item active">
                            <img src="https://cdn.wallpapersafari.com/44/15/ux7WdH.jpg" class="d-block w-100 rounded">
                        </div>
                        @foreach ($announcements as $announcement)
                            <div 
                                class="carousel-item text-center" 
                                style="background: url({{ asset('storage/' . $announcement->image_path) }}) no-repeat right; background-size: cover; width: 100%; height: 100%;"
                            >
                                <h1 class="display-5 mt-5 text-white">{{ $announcement->header }}</h1>
                                <p class="lead text-white">{{ $announcement->subheader }}</p>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-9 mt-5">
                <h1 class="display-4"><strong>Announcements</strong></h1>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6">
                                <img
                                    class="img img-responsive rounded" 
                                    src="{{ asset('storage/' . $announcements[0]->image_path) }}" style="width: 100%; height: 50vh;">
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <p class="display-6">{{ $announcements[0]->header }}</p>
                                <p class="lead text-secondary">{!! $announcements[0]->body !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection