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

<!-- BACK -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body no-padding">
                    <div class="mailbox-controls with-border">
                        @if($folderId)
                        <a href="{{ url('admin/dashboard/') }}" class="btn btn-default btn" title="Back">
                            <i class="fa fa-home"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- FOLDER -->
    <div class="d-flex flex-wrap">
        @foreach ($folders as $folder)
            <div class="p-2">
                <a href="{{ url('admin/dashboard/folder/'.$folder->id )}}" class="card" style="width: 9rem;">
                    <div class="card-body">
                        <img src="img/folder.jpg" class="card-img-top" style="width: 100px; height: 80px;" alt="file gambar">
                        <p class="card-text text-center" style="color: rgb(49, 49, 49)">{{ $folder->folder_name }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    
<!-- FILE -->
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
                                <a class="dropdown-item" href="{{ url('admin/view/view-dashboard-file/'.$file->id) }}">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a class="dropdown-item">
                                    <i class="fas fa-key"></i> User id: {{ $file->user_id}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</section>

@endsection