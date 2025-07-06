<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #060b33;" >


            <!-- Sidebar  -->
             <br><br>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
              
              <img src="{{ asset('img/logo.jpg') }}" alt="logo" 
              style="position: center;  max-height: 75px;" >
            </a>
            <br>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
               
            </div>

            <!-- Nav Item - Users -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('userlist.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span></a>
            </li>

            <!-- Nav Item - Classes -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('class.index') }}">
                <i class="fas fa-chalkboard-teacher"></i>
                    <span>Classes</span></a>
            </li>
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item has-treeview">
            <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseManagement" aria-expanded="false" aria-controls="collapseManagement">
                <i class="fas fa-cogs"></i>
                <span>Management</span>
            </a>

            <ul class="nav nav-treeview collapse" id="collapseManagement">
                    <!-- Nav Item - Announcements -->
                    <li class="nav-item">
                        <a href="{{ route('announcement.index') }}" class="nav-link">
                            <i class="fas fa-bullhorn"></i>
                            <span>Announcements</span>
                        </a>
                    </li>
        
                    <!-- Nav Item - Classes -->
                    <li class="nav-item">
                        <a href="{{ route('event.index') }}" class="nav-link">
                            <i class="far fa-calendar-alt"></i>
                            <span>Events</span>
                        </a>
                    </li>

                    <!-- Nav Item - Belts -->
                    <li class="nav-item">
                        <a href="{{ route('belt.index') }}" class="nav-link">
                            <i class="fas fa-medal"></i>
                            <span>Belts</span>
                        </a>
                    </li>

                    <!-- Nav Item - Certifications -->
                    <li class="nav-item">
                        <a href="" class="nav-link">
                        <i class="fas fa-certificate"></i>
                            <span>Certifications</span>
                        </a>
                    </li>

                    <!-- Nav Item - Attendance -->
                    <li class="nav-item">
                        <a href="{{ route('attendance.index') }}" class="nav-link">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Attendance</span>
                        </a>
                    </li>
                </ul>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Grading Exam -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('grading_exam.index') }}">
                <i class="fas fa-file-alt"></i>
                    <span>Grading Exams</span></a>
            </li>

             <!-- Nav Item - Achievements -->
             <li class="nav-item">
                <a class="nav-link" href="{{ route('achievement.index') }}">
                <i class='fas fa-award'></i>
                    <span>Achievements</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Payments -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('payment.index') }}">
                <i class='fas fa-dollar-sign'></i>
                    <span>Student Payments</span></a>
            </li>

         
            

           

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            

        </ul>
        <!-- End of Sidebar -->