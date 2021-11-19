@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','Dashboard')

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

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