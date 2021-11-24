@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','View File')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary"> 
                <div class="box-body no-padding">
                    <div class="mailbox-controls with-border">
                        <a href="{{ url('admin/dashboard/') }}" class="btn btn-default btn" title="Back">
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
            <iframe src="{{asset($file->file_path)}}" frameborder="0" style="width: 62%; min-height: 562px;"></iframe>
        </p>
    </div>
    
@endsection
