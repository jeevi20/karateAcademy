<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    @include('layouts/admin/_meta')
    @include('layouts/admin/_style')
</head>

<body style="background-color: #060b33; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <!-- Left Dojo Image Panel -->
                    <div class="col-lg-5 d-none d-lg-block bg-dark text-white p-4" style="background: url('https://i.pinimg.com/originals/dc/bc/41/dcbc4126d9ee275bc2f87f8d3a581485.jpg') center/cover; position: relative;">
                        <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; background: rgba(0,0,0,0.6); padding: 20px; border-radius: 10px;">
                            <h4 class="text-white font-weight-bold">🥋 Academy of Japanese Shotokan Karate International - Northen province</h4>
                            <!-- <p class="mb-0">Discipline, Respect, and Honor. Start your martial arts journey with us.</p> -->
                        </div>
                    </div>

                    <!-- Right Info Panel -->
                    <div class="col-lg-7 d-flex align-items-center">
                        <div class="p-5 w-100">

                            <!-- Logo -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('img/logo.jpg') }}" alt="Academy Logo" style="height: 80px;">
                            </div>

                            <div class="text-center mb-4">
                                <h1 class="h3 text-gray-800 font-weight-bold">Welcome to the Dojo!</h1>
                                
                            </div>

                            <div class="mb-4">
                                <h5 class="text-dark">🌟 What You’ll Experience:</h5>
                                <ul class="text-muted pl-3">
                                    <li>Structured Karate Training Classes</li>
                                    <li>National & International Seminars</li>
                                    <li>Grading Exams and Certifications</li>
                                    <li>Student Achievements & Medals</li>
                                    <li>Events, Tournaments, and More!</li>
                                </ul>
                            </div>

                            <blockquote class="blockquote text-center text-secondary">
                                <p class="mb-0">“Karate is a lifelong journey of self-discovery and self-improvement.”</p>
                            </blockquote>

                            <div class="text-center mt-5">
                                <a href="{{ route('login') }}" class="btn btn-danger px-5 py-2 font-weight-bold">
                                    <i class="fas fa-sign-in-alt"></i> Login 
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('layouts/admin/_script')
</body>
</html>
