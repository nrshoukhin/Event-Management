<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-32x32.webp" sizes="32x32" />
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-192x192.webp" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-180x180.webp" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/user-form.css?v=<?= time() ?>">
</head>
<body>

<div class="register-card">
    <h2>Register</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="" id="registerForm">
        <div class="mb-3">
            <label for="first-name" class="form-label">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="first_name" id="first-name" required placeholder="Enter your first name">
            <div class="error-message" id="firstNameError"></div>
        </div>
        <div class="mb-3">
            <label for="last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="last_name" id="last-name" required placeholder="Enter your last name">
            <div class="error-message" id="lastNameError"></div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" name="email" id="email" required placeholder="Enter your email">
            <div class="error-message" id="emailError"></div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="password" id="password" required placeholder="Enter your password">
            <ul id="passwordCriteria" class="list-unstyled">
                <li id="uppercaseCriteria" class="text-danger">⬤ At least one uppercase letter (A-Z)</li>
                <li id="lowercaseCriteria" class="text-danger">⬤ At least one lowercase letter (a-z)</li>
                <li id="numberCriteria" class="text-danger">⬤ At least one number (0-9)</li>
                <li id="specialCharCriteria" class="text-danger">⬤ At least one special character (@, #, $, %, etc.)</li>
                <li id="lengthCriteria" class="text-danger">⬤ At least 6 characters long</li>
            </ul>
        </div>
        <div class="mb-3">
            <label for="confirm-password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" class="form-control" name="confirm_password" id="confirm-password" required placeholder="Confirm your password">
            <div class="error-message" id="confirmPasswordError"></div>
        </div>
        <button type="submit" class="btn w-100">Register</button>
        <p class="mt-3 text-center">Already have an account? <a href="<?php echo BASE_URL; ?>auth/login">Login here</a>.</p>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/user-form.js?v=<?= time() ?>"></script>
</body>
</html>
