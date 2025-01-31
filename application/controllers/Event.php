<?php

class Event extends Controller {
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Initialize an array for errors
            $errors = [];

            // Sanitize input values
            $name = sanitize($_POST['name']);
            $description = sanitize($_POST['description']);
            $max_capacity = sanitize($_POST['max_capacity']);
            $event_date_time = sanitize($_POST['event_date_time']); // Format: 'YYYY-MM-DDTHH:mm'

            // Validate name
            if (empty($name)) {
                $errors[] = 'Event name is required.';
            }

            // Validate description
            if (empty($description)) {
                $errors[] = 'Description is required.';
            }

            // Validate max capacity
            if (empty($max_capacity)) {
                $errors[] = 'Max capacity is required.';
            } elseif (!is_numeric($max_capacity) || $max_capacity <= 0) {
                $errors[] = 'Max capacity must be a positive number.';
            }

            // Validate event date and time
            if (empty($event_date_time)) {
                $errors[] = 'Event date and time are required.';
            } elseif (!strtotime($event_date_time)) {
                $errors[] = 'Invalid date and time format.';
            } else {
                // Convert to DB format if valid
                $event_date_time_db = date('Y-m-d H:i:s', strtotime($event_date_time));
            }

            // If there are errors, reload the view with error messages
            if (!empty($errors)) {
                $this->view('event/create', [
                    'errors' => $errors
                ]);
                return;
            }

            $eventModel = $this->model('EventModel');
            $eventModel->createEvent($name, $description, $max_capacity, $_SESSION['user_id'], $event_date_time_db);

            // Redirect to the dashboard
            redirect(BASE_URL . 'dashboard');
        }
        else {
            $this->view('event/create');
        }
    }

    public function edit($id) {
        $eventModel = $this->model('EventModel');
        // Fetch event details
        $event = $eventModel->getEventById($id);

        // If the event is not found, render a 404 page
        if (!$event) {
            http_response_code(404); // Set the HTTP response code to 404
            $this->view('errors/404'); // Load the 404 error view
            return; // Exit the method
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Initialize an array for errors
            $errors = [];

            // Sanitize input values
            $name = sanitize($_POST['name']);
            $description = sanitize($_POST['description']);
            $max_capacity = sanitize($_POST['max_capacity']);
            $event_date_time = sanitize($_POST['event_date_time']); // Format: 'YYYY-MM-DDTHH:mm'

            // Validate name
            if (empty($name)) {
                $errors[] = 'Event name is required.';
            }

            // Validate description
            if (empty($description)) {
                $errors[] = 'Description is required.';
            }

            // Validate max capacity
            if (empty($max_capacity)) {
                $errors[] = 'Max capacity is required.';
            } elseif (!is_numeric($max_capacity) || $max_capacity <= 0) {
                $errors[] = 'Max capacity must be a positive number.';
            }

            // Validate event date and time
            if (empty($event_date_time)) {
                $errors[] = 'Event date and time are required.';
            } elseif (!strtotime($event_date_time)) {
                $errors[] = 'Invalid date and time format.';
            } else {
                // Convert to DB format if valid
                $event_date_time_db = date('Y-m-d H:i:s', strtotime($event_date_time));
            }

            // If there are errors, reload the view with error messages
            if (!empty($errors)) {
                $this->view('event/create', [
                    'event' => $event,
                    'errors' => $errors
                ]);
                return;
            }

            // Update the event in the database if validation passes
            $eventModel->updateEvent($id, $name, $description, (int) $max_capacity, $event_date_time_db);

            // Redirect to the dashboard
            redirect(BASE_URL . 'dashboard');
        } else {
            // Fetch event details again for the edit view
            $event = $eventModel->getEventById($id);
            $this->view('event/create', ['event' => $event]);
        }
    }

    public function delete($id) {
        $eventModel = $this->model('EventModel');
        // Fetch event details
        $event = $eventModel->getEventById($id);

        // If the event is not found, render a 404 page
        if (!$event) {
            http_response_code(404); // Set the HTTP response code to 404
            $this->view('errors/404'); // Load the 404 error view
            return; // Exit the method
        }
        $eventModel->deleteEvent($id);
        redirect(BASE_URL . 'dashboard');
    }

    public function details($id) {
        $eventModel = $this->model('EventModel');
        $event = $eventModel->getEventById($id);

        if ($event) {
            echo json_encode($event);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Event not found']);
        }
    }

}
