<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AAS Drive | Welcome</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
        .banner-image {
            background-image: url('dist/img/welcome2.jpg');
            background-size: cover;
        }
    </style>
  </head>
  <body>
    <!-- Navbar  -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark p-md-3 bg-dark">
      <div class="container">
        <img src="dist/img/logoAASDrive.png" alt="AAS Drive Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <h1 class="navbar-brand">AAS Drive</h1>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <div class="mx-auto"></div>
          <ul class="navbar-nav">
          @if (Route::has('login'))
                    @auth
                        {{-- 
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ url('/home') }}">Home</a>
                        </li>
                        --}}

                        @if ( Auth::user()->role == 1)
                            <li class="nav-item">
                                <a class="nav-link text-white btn" href="{{ route('admin.dashboard') }}">Home</a>
                            </li>                 
                        @endif

                        @if ( Auth::user()->role == 2)
                            <li class="nav-item">
                                <a class="nav-link text-white btn" href="{{ route('user.dashboard') }}">Home</a>
                            </li>                      
                        @endif

                    @else
                        <li class="nav-item">
                            <a class="nav-link text-white btn" href="{{ route('login') }}">Login</a>
                        </li>              
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link text-white btn btn-primary" href="{{ route('register') }}">Register</a>
                        </li> 
                        @endif
                    @endauth
                </div>
            @endif
          </ul>
        </div>
      </div>
    </nav>

    <!-- Banner Image  -->
    <div
      class="banner-image w-100 vh-100 d-flex justify-content-center align-items-center"
    >
      <div class="content text-center bg-gradient opacity-2 shadow">
        <h1 class="text-white">Welcome to AAS Drive</h1>
        <p class="text-white"><strong>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minima, in!</strong></p>
      </div>
    </div>

    <!-- Footer  -->
    <footer class="bg-dark text-center fixed-bottom text-white p-3">
        Copyright &copy; 2021 <a href="https://aaslaboratory.com" target="_blank">AAS Labolatory</a>. All rights reserved.
    </footer>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>