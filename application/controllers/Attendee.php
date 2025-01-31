<?php
class Attendee extends Controller {
    public function register($event_id) {
        $eventModel = $this->model('EventModel');
        $attendeeModel = $this->model('AttendeeModel');

        // Fetch event details
        $event = $eventModel->getEventById($event_id);

        // If the event is not found, render a 404 page
        if (!$event) {
            http_response_code(404); // Set the HTTP response code to 404
            $this->view('errors/404'); // Load the 404 error view
            return; // Exit the method
        }

        // Render the registration view
        $this->view('attendee/register', [
            'event' => $event
        ]);
    }

    public function submit_registration() {
        $eventModel = $this->model('EventModel');
        $attendeeModel = $this->model('AttendeeModel');

        // Check if the request is an AJAX request
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(400); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Invalid request type.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $eventId = sanitize($_POST['event_id']);

            // Fetch event details
            $event = $eventModel->getEventById($eventId);

            // If the event is not found, render a 404 page
            if (!$event) {
                http_response_code(404); // Set the HTTP response code to 404
                echo json_encode(['success' => false, 'message' => 'Page not found.']);
                return; // Exit the method
            }

            $name = sanitize($_POST['name']);
            $email = sanitize($_POST['email']);

            // Validate inputs
            if (empty($name)) {
                echo json_encode(['success' => false, 'message' => 'Name is required.']);
                return;
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
                return;
            }

            // Check if the user is already registered
            if ($attendeeModel->isAlreadyRegistered($eventId, $email)) {
                echo json_encode(['success' => false, 'message' => 'You are already registered for this event.']);
                return;
            }

            // Check if the event is full
            if ($event['current_capacity'] >= $event['max_capacity']) {
                echo json_encode(['success' => false, 'message' => 'Event is already full.']);
                return;
            }

            // Register the attendee
            if ($attendeeModel->registerAttendee($eventId, $name, $email)) {
                $eventModel->incrementEventCapacity($eventId);
                echo json_encode(['success' => true, 'message' => 'Registration successful!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to register. Please try again.']);
            }
        }
    }

    public function export($event_id) {

        if( $_SESSION['is_admin'] != 1 ){
            if (isset($_SERVER['HTTP_REFERER'])) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit(); // Always call `exit` after `header` to prevent further script execution
            } else {
                // Fallback: If no referrer is available, redirect to a default page
                header('Location: ' . BASE_URL); // Replace BASE_URL with your default page URL
                exit();
            }
        }

        $attendeeModel = $this->model('AttendeeModel');
        $eventModel = $this->model('EventModel');

        $event = $eventModel->getEventById($event_id);

        if (!$event) {
            die('Event not found.');
        }

        $attendees = $attendeeModel->getAttendeesByEventId($event_id);

        // Set headers for CSV download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="attendees_' . $event_id . '.csv"');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($output, ['ID', 'Name', 'Email', 'Registered At']);

        // Add data
        foreach ($attendees as $attendee) {
            fputcsv($output, [
                $attendee['id'],
                $attendee['attendee_name'],
                $attendee['attendee_email'],
                $attendee['registered_at']
            ]);
        }

        fclose($output);
        exit();
    }

    public function attendeesData($event_id) {
        $attendeeModel = $this->model('AttendeeModel');
        $attendees = $attendeeModel->getAttendeesByEventId($event_id);

        // Send JSON response for DataTable
        header('Content-Type: application/json');
        echo json_encode(['data' => $attendees]);
        exit();
    }
}
