<h2><?php echo isset($event) ? 'Edit Event' : 'Create Event'; ?></h2>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="">
    <div class="mb-3">
        <label for="name" class="form-label">Event Name<span style="color: red;">*</span></label>
        <input type="text" class="form-control" name="name" id="name" required value="<?php echo $event['name'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description<span style="color: red;">*</span></label>
        <textarea class="form-control" name="description" id="description" required><?php echo $event['description'] ?? ''; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="max_capacity" class="form-label">Max Capacity<span style="color: red;">*</span></label>
        <input type="number" class="form-control" name="max_capacity" id="max_capacity" required value="<?php echo $event['max_capacity'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="event_date_time" class="form-label">Event Date & Time<span style="color: red;">*</span></label>
        <input 
            type="datetime-local" 
            class="form-control" 
            name="event_date_time" 
            id="event_date_time" 
            required 
            value="<?php 
                echo isset($event['event_date_time']) 
                    ? date('Y-m-d\TH:i', strtotime($event['event_date_time'])) 
                    : ''; 
            ?>">
    </div>
    <button type="submit" class="btn btn-primary">
        <?php echo isset($event) ? 'Update Event' : 'Create Event'; ?>
    </button>
</form>
