@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','List Data User')

@section('content')

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>List User</h1>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User id</th>
                        <th>Nama</th>
                        <th>E-Mail</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="container">
            <div class="row">Role 1 : Admin</div>
        </div>
        <div class="container">
            <div class="row">Role 2 : User</div>
        </div>

@endsection