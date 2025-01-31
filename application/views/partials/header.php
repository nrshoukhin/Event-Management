<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-32x32.webp" sizes="32x32" />
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-192x192.webp" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-180x180.webp" />
    <title><?php echo $title ?? 'Event Management'; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/common.css?v=<?= time() ?>">
    <?php if($view === "dashboard"): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/dashboard.css?v=<?= time() ?>">
    <?php endif; ?>
</head>
<body>
    <!-- Common Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>dashboard">
                <img height="40" width="40" src="<?= BASE_URL ?>/assets/image/logo.png">
            </a>

            <!-- Toggler for Mobile -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light fw-semibold" href="<?php echo BASE_URL; ?>dashboard">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light fw-semibold" href="<?php echo BASE_URL; ?>event/create">
                            <i class="fas fa-plus-circle"></i> Create Event
                        </a>
                    </li>
                </ul>

                <!-- Search Bar -->
                <form class="d-flex me-3 position-relative" id="searchForm" autocomplete="off">
                    <input class="form-control form-control-sm me-2 rounded-pill px-3 shadow-sm" type="search" id="searchInput"
                           name="query" placeholder="🔍 Search events/attendees..." aria-label="Search"  style="width: 230px">
                    <!-- Dropdown for search results -->
                    <div id="searchResults" class="dropdown-menu w-100 p-2 shadow-sm bg-white" 
                         style="max-height: 250px; overflow-y: auto; display: none;"></div>
                </form>

                <!-- Logout Button -->
                <a class="btn btn-outline-light logout-btn fw-semibold px-3 rounded-pill" href="<?php echo BASE_URL; ?>auth/logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
