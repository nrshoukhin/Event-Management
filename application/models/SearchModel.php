<?php

class SearchModel extends Model {

	public function getLiveSearchResults($query, $limit) {
	    $stmt = $this->db->prepare("
	        SELECT id, name AS label, description, max_capacity, current_capacity, event_date_time, 'event' AS type, 'event' AS link
	        FROM events
	        WHERE name LIKE :query
	           OR description LIKE :query
	           OR max_capacity LIKE :query
	           OR current_capacity LIKE :query
	           OR event_date_time LIKE :query
	        UNION
	        SELECT id, attendee_name AS label, attendee_email, '' AS max_capacity, '' AS current_capacity, registered_at AS event_date_time, 'attendee' AS type, 'attendee' AS link
	        FROM attendees
	        WHERE attendee_name LIKE :query
	           OR attendee_email LIKE :query
	           OR registered_at LIKE :query
	        LIMIT :limit
	    ");
	    $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
	    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
	    $stmt->execute();

	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getPaginatedEvents($query, $start, $length, $orderColumn, $orderDir) {
	    $stmt = $this->db->prepare("
	        SELECT id, name, description, max_capacity, current_capacity, event_date_time, CONCAT('event/dashboard/', id) AS link
	        FROM events
	        WHERE name LIKE :query
	           OR description LIKE :query
	           OR max_capacity LIKE :query
	           OR current_capacity LIKE :query
	           OR event_date_time LIKE :query
	        ORDER BY $orderColumn $orderDir
	        LIMIT :start, :length
	    ");
	    $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
	    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
	    $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
	    $stmt->execute();

	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getPaginatedAttendees($query, $start, $length, $orderColumn, $orderDir) {
	    // Updated SQL query to join with the events table
	    $stmt = $this->db->prepare("
	        SELECT 
	            a.id, 
	            a.attendee_name AS name, 
	            a.attendee_email AS email,
	            a.registered_at, 
	            CONCAT('attendee/profile/', a.id) AS link,
	            e.name AS event_name, 
	            e.description AS event_description, 
	            e.event_date_time
	        FROM attendees AS a
	        INNER JOIN events AS e ON a.event_id = e.id
	        WHERE a.attendee_name LIKE :query
	           OR a.attendee_email LIKE :query
	           OR a.registered_at LIKE :query
	           OR e.name LIKE :query
	           OR e.description LIKE :query
	           OR e.event_date_time LIKE :query
	        ORDER BY $orderColumn $orderDir
	        LIMIT :start, :length
	    ");
	    
	    $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
	    $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
	    $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
	    $stmt->execute();

	    return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getTotalEventsCount($query = '') {
	    if (!empty($query)) {
	        // Count events matching the search query
	        $stmt = $this->db->prepare("
	            SELECT COUNT(*) AS total
	            FROM events
	            WHERE name LIKE :query
	               OR description LIKE :query
	               OR max_capacity LIKE :query
	               OR current_capacity LIKE :query
	               OR event_date_time LIKE :query
	        ");
	        $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
	    } else {
	        // Count all events if no query is provided
	        $stmt = $this->db->prepare("SELECT COUNT(*) AS total FROM events");
	    }

	    $stmt->execute();
	    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
	}

    public function getTotalAttendeesCount($query = '') {
        if (!empty($query)) {
            // Count attendees matching the search query, joined with events
            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS total
                FROM attendees AS a
                INNER JOIN events AS e ON a.event_id = e.id
                WHERE a.attendee_name LIKE :query
                   OR a.attendee_email LIKE :query
                   OR a.registered_at LIKE :query
                   OR e.name LIKE :query
                   OR e.description LIKE :query
                   OR e.event_date_time LIKE :query
            ");
            $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        } else {
            // Count all attendees, joined with events
            $stmt = $this->db->prepare("
                SELECT COUNT(*) AS total
                FROM attendees AS a
                INNER JOIN events AS e ON a.event_id = e.id
            ");
        }

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getEventById($id) {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAttendeeById($id) {
        $stmt = $this->db->prepare("SELECT * FROM attendees WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}