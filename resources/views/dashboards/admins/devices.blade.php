@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','My Devices')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>My Devices</h1>
            </div>
        </div>
    </div>
    <hr>
    
<!-- TOMBOL CREATE & UPLOAD -->
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body no-padding">
                    <div class="mailbox-controls with-border">
                        @if(!$folderId)
                        <a class="btn btn-default btn" data-toggle="modal" data-target="#newFolderModal" title="New Folder">
                            <i class="fa fa-folder"></i>
                        </a>  
                        @endif
                        @if($folderId)
                        <a href="{{ url('admin/my-devices/') }}" class="btn btn-default btn" title="Back">
                            <i class="fa fa-home"></i>
                        </a>
                        @endif
                        <a class="btn btn-default btn" data-toggle="modal" data-target="#uploadModal" title="Upload File">
                            <i class="fa fa-upload"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
<!-- FOLDER -->
    <div class="d-flex flex-wrap">
        @foreach ($folders as $folder)
            <div class="p-2">
                <a href="{{ url('admin/my-devices/folder/'.$folder->id )}}" class="card" style="width: 9rem;">
                    <div  class="card-body">
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
                        <img src="img/file.jpeg" class="card-img-top" style="width: 100px; height: 80px;" alt="file gambar">
                        <p class="card-text">{{ $file->name}}</p>
                        <div class="dropdown float-right">
                            <a class="dropdown-toggle" style="color: black" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a class="dropdown-item" href="{{ url('admin/delete-admin-file/'.$file->id) }}">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fas fa-share"></i> Share
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

<!-- MODAL CREATE FOLDER -->
    <div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newFolderModalLabel">New Folder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('adminCreateFolder') }}" method="post" id="new-folder">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" />
                        </div>
                        <input type="hidden" name="dir" value=""/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- MODAL UPLOAD FILE -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="uploadModalLabel">Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('adminFileUpload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if($folderId)
                        <input type="hidden" name="folder_id" value="{{$folderId}}" />
                    @endif
                    <div class="modal-body">
                      <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection