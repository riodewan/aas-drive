@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','View File')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body no-padding">
                    <div class="mailbox-controls with-border">
                        <a href="{{ url('admin/my-devices/') }}" class="btn btn-default btn" title="Back">
                            <i class="fa fa-home"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <h5 class="mt-3">{{$file->name}}</h5>
        <p>
            <iframe src="{{asset($file->file_path)}}" frameborder="0" style=" width: 1000px; height: 500px;"></iframe>
        </p> 
    </div>
    
@endsection
