<?php

class Dashboard extends Controller {
    public function index() {
        $eventModel = $this->model('EventModel');
        $attendeeModel = $this->model('AttendeeModel');

        $totalAttendees = $attendeeModel->getTotalAttendees();
        $upcomingEvents = $eventModel->getUpcomingEventCount();
        $totalEvents = $eventModel->getTotalEventCount();

        $this->view('dashboard', [
            'totalAttendees' => $totalAttendees,
            'upcomingEvents' => $upcomingEvents,
            'totalEvents' => $totalEvents,
        ]);
    }

    public function getEventsAjax() {
        $start = $_GET['start'] ?? 0;
        $length = $_GET['length'] ?? 10;
        $search = $_GET['search']['value'] ?? '';
        $orderColumn = $_GET['order'][0]['column'] ?? 0; // Column index
        $orderDir = $_GET['order'][0]['dir'] ?? 'asc';   // asc or desc

        $eventModel = $this->model('EventModel');
        $events = $eventModel->getEventsPaginated($start, $length, $search, $orderColumn, $orderDir);

        // Fetch total records
        $totalRecords = $eventModel->getTotalEventCount();

        $response = [
            "draw" => $_GET['draw'] ?? 1, // Required by DataTables
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords, // Adjust if search is used
            "data" => $events
        ];

        echo json_encode($response);
    }

    public function event($event_id) {
        $eventModel = $this->model('EventModel');
        $attendeeModel = $this->model('AttendeeModel');

        $event = $eventModel->getEventById($event_id);
        $attendees = $attendeeModel->getAttendeesByEventId($event_id);

        $this->view('event/dashboard', ['event' => $event, 'attendees' => $attendees]);
    }
}
