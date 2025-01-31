<!-- Welcome Message -->
<div class="row mb-4">
    <div class="col">
        <h1 class="text-center">Welcome, <?php echo $_SESSION['first_name']." ".$_SESSION['last_name']; ?>!</h1>
    </div>
</div>

<!-- Summary Cards -->
<div class="row text-center mb-4">
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Total Events</h4>
                <p class="card-text display-4"><?php echo $totalEvents; ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Registered Attendees</h4>
                <p class="card-text display-4"><?php echo $totalAttendees; ?></p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title">Upcoming Events</h4>
                <p class="card-text display-4"><?php echo $upcomingEvents; ?></p>
            </div>
        </div>
    </div>
</div>


<!-- Events Table -->
<div class="row">
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Events</h3>
                <a href="<?php echo BASE_URL; ?>event/create" class="btn btn-light btn-sm">+ Add Event</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="eventsTable" class="table table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Capacity</th>
                                <th>Date</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here via Ajax -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Viewing Event Details -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="modalEventName"></span></p>
                <p><strong>Description:</strong> <span id="modalEventDescription"></span></p>
                <p><strong>Capacity:</strong> <span id="modalEventCapacity"></span></p>
                <p><strong>Date & Time:</strong> <span id="modalEventDate"></span></p>
            </div>
        </div>
    </div>
</div>

