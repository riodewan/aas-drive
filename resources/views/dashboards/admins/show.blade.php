<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show File</title>
</head>
<body>
    <a href="{{ url('admin/my-devices/') }}">Back</a>
    <h3>{{$file->name}}</h3>          
    <p>
        <iframe src="{{ url('storage/uploads/'.$file->file)}}" style=" width: 900px; height: 500px;"></iframe>
    </p>  
</body>
</html>