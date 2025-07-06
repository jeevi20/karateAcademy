<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
</button>

<!-- Institute Moto -->
<div class="motto-spacing">
    <h5 class="text-center text-md-left text-lg-center font-weight-bold">
        Discipline First, Techniques Second
    </h5>
</div>


<!-- Topbar Search -->
<!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"> 
    <div class="input-group">
    
        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn" style="background-color: #060b33; color: white;"  type="button" >
                <i class="fas fa-search fa-sm"></i>
            </button>
        </div>
    </div>
</form> -->

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
    <li class="nav-item dropdown no-arrow d-sm-none">
        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-search fa-fw"></i>
        </a>
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown">
            <form class="form-inline mr-auto w-100 navbar-search">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small"
                        placeholder="Search for..." aria-label="Search"
                        aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </li>

    <!-- Nav Item - Announcements -->
<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw"></i>
        @if($announcements->count() > 0)
            <span class="badge badge-danger badge-counter">{{ $announcements->count() }}</span>
        @endif
    </a>
    <!-- Dropdown - Announcements -->
    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header">
            Announcements Center
        </h6>

        @forelse($announcements as $announcement)
            <a class="dropdown-item d-flex align-items-center" href="{{ $announcement->link ? $announcement->link : route('announcement.show', $announcement->id) }}" 
            target="_blank">
                <div class="mr-3">
                    <div class="icon-circle bg-primary">
                        <i class="fas fa-bullhorn text-white"></i>
                    </div>
                </div>
                <div>
                    <div class="small text-gray-500">{{ \Carbon\Carbon::parse($announcement->announcement_date)->format('M d, Y') }}</div>
                    <span class="font-weight-bold">{{ $announcement->title }}</span>
                    <div>{{ \Illuminate\Support\Str::limit($announcement->body, 50) }}</div>
                </div>
            </a>
        @empty
            <div class="dropdown-item text-center small text-gray-500">No new announcements</div>
        @endforelse
    </div>
</li>

    
        

    
    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            <!-- Dynamic User Name -->
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                {{ Auth::user()->name ?? 'Guest' }} 
            </span> 
            <!-- Dynamic User Profile Picture -->
            <img class="rounded-circle" src="{{ Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('img/undraw_profile_2.svg') }}" alt="Profile Picture" style="width: 40px; height: 40px;">

        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                {{ __('Profile') }}
            </a>
            
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>

</ul>

</nav>
<!-- End of Topbar -->