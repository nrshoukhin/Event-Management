<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event</title>
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-32x32.webp" sizes="32x32" />
    <link rel="icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-192x192.webp" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://ollyo.com/wp-content/uploads/2024/05/cropped-favicon-180x180.webp" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/event-attendee.css?v=<?= time() ?>">
</head>
<body>

<div class="register-card">
    <h2>Register for "<?php echo htmlspecialchars($event['name']); ?>"</h2>
    <div id="alert-message"></div>
    <form id="attendeeForm">
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" class="form-control" name="name" id="name" required placeholder="Enter your full name">
            <input type="hidden" class="form-control" name="event_id" id="event-id" value="<?= $event['id'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" required placeholder="Enter your email">
        </div>
        <button type="submit" id="register-btn" class="btn w-100">Register</button>
    </form>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script type="text/javascript">
    var baseUrl = "<?= BASE_URL ?>";
</script>
<script src="<?php echo BASE_URL; ?>assets/js/event-attendee.js?v=<?= time() ?>"></script>
</body>
</html>
