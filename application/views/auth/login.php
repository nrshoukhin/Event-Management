<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-32x32.webp" sizes="32x32" />
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-192x192.webp" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-180x180.webp" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login.css?v=<?= time() ?>">
    <style>
        
    </style>
</head>
<body>

<div class="login-card">
    <h2>Login</h2>
    <?php if (!empty($_SESSION['success_message'])): ?>
        <div class="alert alert-success text-center">
            <?php
            echo $_SESSION['success_message'];
            unset($_SESSION['success_message']); // Remove the message after displaying it
            ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="" id="loginForm">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" required placeholder="Enter your email">
            <div class="error-message text-danger" id="emailError"></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required placeholder="Enter your password">
            <div class="error-message text-danger" id="passwordError"></div>
        </div>
        <button type="submit" class="btn w-100">Login</button>
        <p class="mt-3 text-center">Don't have an account? <a href="<?php echo BASE_URL; ?>auth/register">Register here</a>.</p>
    </form>
</div>

<script src="<?php echo BASE_URL; ?>assets/js/login.js"></script>
</body>
</html>
