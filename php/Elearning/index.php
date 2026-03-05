<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Programming Courses</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background: #f4f6f9;
            font-family: Segoe UI;
        }

        /* navbar */

        .navbar {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* cards */

        .course-card {
            border: none;
            border-radius: 14px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .course-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .course-card img {
            height: 200px;
            object-fit: cover;
        }

        /* youtube button */

        .youtube-btn {
            color: #ff0000;
            font-weight: 500;
            text-decoration: none;
        }

        .youtube-btn:hover {
            color: #cc0000;
        }

        /* enroll button */

        .enroll-btn {
            background: #198754;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
        }

        .enroll-btn:hover {
            background: #157347;
        }

        /* footer */

        footer {
            background: #2d3436;
            color: white;
            padding: 18px;
            text-align: center;
            margin-top: 50px;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand fw-bold">CourseHub</a>

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house"></i> Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>


    <!-- COURSES -->

    <div class="container mt-5">

        <div class="text-center mb-5">
            <h2 class="fw-bold">Programming Courses</h2>
            <p class="text-muted">Choose your favorite programming course</p>
        </div>

        <div class="row g-4">

            <!-- PYTHON -->

            <div class="col-md-4">
                <div class="card course-card">

                    <img src="https://images.unsplash.com/photo-1526379095098-d400fd0bf935" class="card-img-top">

                    <div class="card-body">

                        <h5>Python Programming</h5>

                        <p class="text-muted small">
                            Learn Python programming from beginner to advanced.
                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>⭐ 4.8 (120 Reviews)</span>
                            <span class="text-success">Backend</span>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a class="youtube-btn watch-video"
                                data-video="https://www.youtube.com/embed/_uQrJ0TkZlc"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">

                                <i class="bi bi-youtube"></i> Watch
                            </a>

                            <button class="enroll-btn">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </button>

                        </div>

                    </div>
                </div>
            </div>


            <!-- ASP.NET -->

            <div class="col-md-4">
                <div class="card course-card">

                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c" class="card-img-top">

                    <div class="card-body">

                        <h5>ASP.NET Development</h5>

                        <p class="text-muted small">
                            Build dynamic web applications using ASP.NET Core.
                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>⭐ 4.7 (95 Reviews)</span>
                            <span class="text-primary">Web Dev</span>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a class="youtube-btn watch-video"
                                data-video="https://www.youtube.com/embed/1p3x7S3J8vU"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">

                                <i class="bi bi-youtube"></i> Watch
                            </a>

                            <button class="enroll-btn">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </button>

                        </div>

                    </div>
                </div>
            </div>


            <!-- BOOTSTRAP -->

            <div class="col-md-4">
                <div class="card course-card">

                    <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c" class="card-img-top">

                    <div class="card-body">

                        <h5>Bootstrap Framework</h5>

                        <p class="text-muted small">
                            Create responsive websites using Bootstrap 5.
                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>⭐ 4.6 (70 Reviews)</span>
                            <span class="text-info">Frontend</span>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a class="youtube-btn watch-video"
                                data-video="https://www.youtube.com/embed/4sosXZsdy-s"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">

                                <i class="bi bi-youtube"></i> Watch
                            </a>

                            <button class="enroll-btn">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </button>

                        </div>

                    </div>
                </div>
            </div>


            <!-- C# -->

            <div class="col-md-4">
                <div class="card course-card">

                    <img src="https://images.unsplash.com/photo-1518770660439-4636190af475" class="card-img-top">

                    <div class="card-body">

                        <h5>C# Programming</h5>

                        <p class="text-muted small">
                            Learn C# and .NET for desktop and web applications.
                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>⭐ 4.8 (110 Reviews)</span>
                            <span class="text-success">Programming</span>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a class="youtube-btn watch-video"
                                data-video="https://www.youtube.com/embed/GhQdlIFylQ8"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">

                                <i class="bi bi-youtube"></i> Watch
                            </a>

                            <button class="enroll-btn">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </button>

                        </div>

                    </div>
                </div>
            </div>


            <!-- JAVASCRIPT -->

            <div class="col-md-4">
                <div class="card course-card">

                    <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c" class="card-img-top">

                    <div class="card-body">

                        <h5>JavaScript Course</h5>

                        <p class="text-muted small">
                            Master JavaScript and modern web development.
                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>⭐ 4.9 (200 Reviews)</span>
                            <span class="text-warning">Frontend</span>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a class="youtube-btn watch-video"
                                data-video="https://www.youtube.com/embed/W6NZfCO5SIk"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">

                                <i class="bi bi-youtube"></i> Watch
                            </a>

                            <button class="enroll-btn">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </button>

                        </div>

                    </div>
                </div>
            </div>


            <!-- DJANGO -->

            <div class="col-md-4">
                <div class="card course-card">

                    <img src="https://images.unsplash.com/photo-1605379399642-870262d3d051" class="card-img-top">

                    <div class="card-body">

                        <h5>Django Framework</h5>

                        <p class="text-muted small">
                            Build powerful web apps using Django and Python.
                        </p>

                        <div class="d-flex justify-content-between mb-2">

                            <span>⭐ 4.7 (85 Reviews)</span>
                            <span class="text-success">Backend</span>

                        </div>

                        <div class="d-flex justify-content-between">

                            <a class="youtube-btn watch-video"
                                data-video="https://www.youtube.com/embed/F5mRW0jo-U4"
                                data-bs-toggle="modal"
                                data-bs-target="#videoModal">

                                <i class="bi bi-youtube"></i> Watch
                            </a>

                            <button class="enroll-btn">
                                <i class="bi bi-mortarboard"></i> Enroll
                            </button>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- YOUTUBE MODAL -->

    <div class="modal fade" id="videoModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">Course Video</h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body p-0">

                    <div class="ratio ratio-16x9">

                        <iframe id="youtubeVideo" src="" allowfullscreen></iframe>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- FOOTER -->

    <footer>

        <p>© 2026 Programming Courses | All Rights Reserved</p>

    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const videoLinks = document.querySelectorAll(".watch-video");
        const videoFrame = document.getElementById("youtubeVideo");

        videoLinks.forEach(link => {

            link.addEventListener("click", function() {

                videoFrame.src = this.getAttribute("data-video");

            });

        });

        const modal = document.getElementById('videoModal');

        modal.addEventListener('hidden.bs.modal', function() {

            videoFrame.src = "";

        });
    </script>

</body>

</html>