<?php

class Search extends Controller {

	public function searchResults() {
	    $query = $_GET['query'] ?? ''; // Get the query parameter from the URL

	    // Load the search results view
	    $this->view('search/searchResults', [
	        'query' => $query // Pass the query to the view
	    ]);
	}

	public function liveSearch() {
	    $query = sanitize($_GET['query']) ?? '';
	    $limit = 10;

	    if (!empty($query)) {
	        // Use the SearchModel to fetch results
	        $searchModel = $this->model('SearchModel');
	        $results = $searchModel->getLiveSearchResults($query, $limit + 1); // Fetch one extra result to check if more results exist

	        // Check if more results are available
	        $hasMore = count($results) > $limit;

	        // Trim results to the limit
	        if ($hasMore) {
	            array_pop($results); // Remove the extra result
	        }

	        // Return results along with a flag for more results
	        header('Content-Type: application/json');
	        echo json_encode([
	            'results' => $results,
	            'hasMore' => $hasMore
	        ]);
	    } else {
	        // Return an empty response if the query is empty
	        header('Content-Type: application/json');
	        echo json_encode([
	            'results' => [],
	            'hasMore' => false
	        ]);
	    }
	}

	public function getEvents() {
	    $query = $_GET['query'] ?? '';
	    $start = $_GET['start'] ?? 0;
	    $length = $_GET['length'] ?? 10;
	    $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
	    $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

	    // Column mapping for sorting
	    $columns = ['id', 'name', 'description', 'max_capacity', 'current_capacity', 'event_date_time'];
	    $orderColumn = $columns[$orderColumnIndex] ?? 'id';

	    $searchModel = $this->model('SearchModel');
	    $data = $searchModel->getPaginatedEvents($query, $start, $length, $orderColumn, $orderDir);
	    $totalRecords = $searchModel->getTotalEventsCount($query);

	    echo json_encode([
	        "draw" => $_GET['draw'] ?? 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalRecords,
	        "data" => $data
	    ]);
	}

	public function getAttendees() {
	    $query = $_GET['query'] ?? '';
	    $start = $_GET['start'] ?? 0;
	    $length = $_GET['length'] ?? 10;
	    $orderColumnIndex = $_GET['order'][0]['column'] ?? 0;
	    $orderDir = $_GET['order'][0]['dir'] ?? 'asc';

	    // Column mapping for sorting
	    $columns = ['id', 'attendee_name', 'attendee_email', 'registered_at'];
	    $orderColumn = $columns[$orderColumnIndex] ?? 'id';

	    $searchModel = $this->model('SearchModel');
	    $data = $searchModel->getPaginatedAttendees($query, $start, $length, $orderColumn, $orderDir);
	    $totalRecords = $searchModel->getTotalAttendeesCount($query);

	    echo json_encode([
	        "draw" => $_GET['draw'] ?? 1,
	        "recordsTotal" => $totalRecords,
	        "recordsFiltered" => $totalRecords,
	        "data" => $data
	    ]);
	}

	public function getDetails() {
	    $id = $_GET['id'] ?? null;
	    $type = $_GET['type'] ?? null;

	    if (!$id || !$type) {
	        echo '<p class="text-danger">Invalid request.</p>';
	        return;
	    }

	    if ($type === 'event') {
	        // Fetch event details
	        $searchModel = $this->model('SearchModel');
	        $event = $searchModel->getEventById($id);

	        if ($event) {
	            // Return event details as HTML
	            echo "<h4>Event Name: {$event['name']}</h4>
	                  <p><strong>Description:</strong> {$event['description']}</p>
	                  <p><strong>Max Capacity:</strong> {$event['max_capacity']}</p>
	                  <p><strong>Current Capacity:</strong> {$event['current_capacity']}</p>
	                  <p><strong>Event Date/Time:</strong> ".date('M d, Y, h:i A', strtotime($event['event_date_time']))."</p>";
	        } else {
	            echo '<p class="text-danger">Event not found.</p>';
	        }
	    } elseif ($type === 'attendee') {
	        // Fetch attendee details
	        $searchModel = $this->model('SearchModel');
	        $attendee = $searchModel->getAttendeeById($id);

	        if ($attendee) {
	            // Return attendee details as HTML
	            echo "<h4>Attendee Name: {$attendee['attendee_name']}</h4>
	                  <p><strong>Email:</strong> {$attendee['attendee_email']}</p>
	                  <p><strong>Registered At:</strong> ".date('M d, Y, h:i A', strtotime($attendee['registered_at']))."</p>";
	        } else {
	            echo '<p class="text-danger">Attendee not found.</p>';
	        }
	    } else {
	        echo '<p class="text-danger">Invalid type.</p>';
	    }
	}

}