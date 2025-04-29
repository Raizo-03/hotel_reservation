<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
<link rel="stylesheet" href="{{ asset('css/adminstyle.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('styles')


        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            display: flex;
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        #sidebar {
            width: 280px;
            height: 100vh;
            background: #212529;
            color: white;
            padding-top: 20px;
            position: fixed;
            transition: all 0.3s;
        }

        #sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 12px;
            text-decoration: none;
            transition: background 0.3s;
        }

        #sidebar a:hover {
            background: #495057;
        }

        #sidebar i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        #main-content {
            margin-left: 300px;
            padding: 20px;
            width: 100%;
            transition: all 0.3s;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-hover tbody tr:hover {
            background: #e9ecef;
        }

        .btn-rounded {
            border-radius: 50px;
            padding: 5px 15px;
        }
    </style>
</head>
<body>
    @yield('content')
    
    @yield('scripts')
</body>
</html>