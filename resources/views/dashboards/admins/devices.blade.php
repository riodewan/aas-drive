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
                        <a class="btn btn-default btn" data-toggle="modal" data-target="#newFolderModal" title="New Folder">
                            <i class="fa fa-folder"></i>
                        </a>  
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

<!-- MODAL CREATE FOLDER -->
    <div class="modal fade" id="newFolderModal" tabindex="-1" role="dialog" aria-labelledby="newFolderModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="newFolderModalLabel">New Folder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="" method="post" id="new-folder">
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
                <form action="{{ route('fileUpload') }}" method="post" enctype="multipart/form-data">
                    @csrf
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