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
    </div><!-- /.container-fluid -->
    <hr>
    
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="box box-primary">
    
                <div class="box-body no-padding">
    
                    <div class="mailbox-controls with-border">
    
                        <!-- /.btn-group -->
                        <a class="btn btn-default btn" title="Create New Folder" data-toggle="modal" data-target="#newFolderModal">
                            <i class="fa fa-folder"></i>
                        </a>

                        <a class="btn btn-default btn" title="Upload File" data-toggle="modal" data-target="#uploadModal">
                            <i class="fa fa-upload"></i>
                        </a>
                        
    
                    </div>
    
                    <!-- /.mailbox-read-message -->
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
                        <a class="dropdown-item" data-toggle="modal" data-target="#editModal">
                            <i class="fas fa-edit"></i> Rename
                        </a>
                        <a class="dropdown-item" href="" onclick="return confirm('Ingin Menghapus?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                        <a class="dropdown-item" href="">
                            <i class="fas fa-download"></i> Download
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

    <!-- Modal Create New Folder  -->
    <div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newFolderModalLabel">New Folder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="new-folder">
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

    <!-- Modal Uload File  -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="uploadModalLabel">Upload File</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('fileUpload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="file" name="file" class="form-control" id="chooseFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Rename File -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editModalLabel">Rename</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ url('files', $file->id ) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" value="{{ $file->name }}" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection