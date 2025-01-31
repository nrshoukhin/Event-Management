<h2>Search Results for "<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>"</h2>

<!-- Events Table -->
<div class="row">
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Events</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="eventsTable" class="table table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Max Capacity</th>
                                <th>Current Capacity</th>
                                <th>Event Date/Time</th>
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

<!-- Attendees Table -->
<div class="row mt-4">
    <div class="col">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Attendees</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="attendeesTable" class="table table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Event Name</th>
                                <th>Registered At</th>
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

