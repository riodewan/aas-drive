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
        @if($extension == '.png' || $extension == '.jpg' || $extension == '.jpeg')
            <img src="{{asset($file->file_path)}}"/>
        @elseif($extension == '.pdf')
            <embed src="{{asset($file->file_path)}}" type="application/pdf" frameborder="0" scrolling="auto" height="100%" width="100%"/>
        @elseif($extension == '.docx' || $extension == '.xlsx' || $extension == '.xlx')
            <iframe src="https://view.officeapps.live.com/op/view.aspx?src={{asset($file->file_path)}}" style=" width: 1000px; height: 500px;"></iframe>
        @elseif($extension == '.zip')
            <iframe src="{{asset($file->file_path)}}" style=" width: 1000px; height: 500px;"></iframe>
        @endif
    </div>
    
@endsection
