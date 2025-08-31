<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light" style="font-size:18px">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('admin.home') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
     
      <div class="nav-link">
        <i  class="d-block">Welcome, {{ Auth::user()->name }} </i>
      </div>
      <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-sign-out-alt"></i>
          </a>

          <div class="dropdown">
              <div class="dropdown-menu dropdown-menu-right" style="font-size:12px" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Notification</a>
                  <a class="dropdown-item" href="{{ route('profile.password.edit') }}">Change Password</a>
                  <a class="dropdown-item" id="logout">Logout</a>
              </div>
          </div>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
      </li>
      {{--<li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>--}}
      </li> 
    </ul>
  </nav>

  <script>

    document.getElementById("logout"). onclick= function(){myFunction()};

    function myFunction(){
      document.getElementById('logout-form').submit();
    }
  </script>