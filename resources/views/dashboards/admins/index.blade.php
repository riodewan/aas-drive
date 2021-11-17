@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','Dashboard')

@section('content')

<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Files</h1>
            </div>
        </div>
    </div>
    <hr>
    
    <div class="d-flex flex-wrap">
        @foreach ($files as $file)
            <div class="p-2">
                <div class="card" style="width: 9rem;">
                    <div class="card-body">
                        <img src="img/file.jpeg" class="card-img-top" alt="file gambar">
                        <p class="card-text">{{ $file->name}}</p>
                        <div class="dropdown float-right">
                            <a class="dropdown-toggle" style="color: black" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
@endsection