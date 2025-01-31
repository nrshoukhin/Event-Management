<?php

class EventModel extends Model {
    public function getAllEvents() {
        $stmt = $this->db->query("SELECT * FROM events ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createEvent($name, $description, $max_capacity, $created_by, $event_date_time_db) {
        $stmt = $this->db->prepare("INSERT INTO events (name, description, max_capacity, created_by, event_date_time) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $max_capacity, $created_by, $event_date_time_db]);
    }

    public function getEventById($id) {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEventByIdForAPI($id) {
        $stmt = $this->db->prepare("SELECT id,name,description,max_capacity,current_capacity,event_date_time,created_at FROM events WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateEvent($id, $name, $description, $max_capacity, $event_date_time_db) {
        $stmt = $this->db->prepare("UPDATE events SET name = ?, description = ?, max_capacity = ?, event_date_time = ? WHERE id = ?");
        $stmt->execute([$name, $description, $max_capacity, $event_date_time_db, $id]);
    }

    public function deleteEvent($id) {
        $stmt = $this->db->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getUpcomingEventCount() {
        $query = "SELECT COUNT(*) AS upcoming FROM events WHERE event_date_time > :current_time";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':current_time', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['upcoming'];
    }

    public function incrementEventCapacity($event_id) {
        $stmt = $this->db->prepare("UPDATE events SET current_capacity = current_capacity + 1 WHERE id = ?");
        return $stmt->execute([$event_id]);
    }

    public function decrementEventCapacity($event_id) {
        $stmt = $this->db->prepare("UPDATE events SET current_capacity = current_capacity - 1 WHERE id = ? AND current_capacity > 0");
        return $stmt->execute([$event_id]);
    }

    public function getEventsPaginated($start, $length, $search = '', $orderColumnIndex = 0, $orderDir = 'asc') {
        // Define the mapping of column indices to database column names
        $columns = [
            0 => 'id',                // Index 0 corresponds to 'id'
            1 => 'name',              // Index 1 corresponds to 'name'
            2 => 'current_capacity',  // Index 2 corresponds to 'current_capacity'
            3 => 'event_date_time',   // Index 3 corresponds to 'event_date_time'
            4 => 'max_capacity',   // Index 4 corresponds to 'max_capacity'
        ];

        // Determine the column to order by
        $orderBy = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'id';

        // Prevent invalid order directions
        $orderDir = strtolower($orderDir) === 'desc' ? 'DESC' : 'ASC';

        // Build the search conditions dynamically for all columns
        $searchConditions = [];
        foreach ($columns as $column) {
            if ($column === 'event_date_time') {
                // Handle partial date input for event_date_time column
                $searchConditions[] = "DATE_FORMAT($column, '%b %d, %Y %h:%i %p') LIKE :search OR DATE_FORMAT($column, '%b %d') LIKE :searchPartialDate";
            } else {
                $searchConditions[] = "$column LIKE :search";
            }
        }
        $whereClause = implode(' OR ', $searchConditions);

        // Build the query
        $query = "
            SELECT * 
            FROM events 
            WHERE ($whereClause) 
            ORDER BY $orderBy $orderDir 
            LIMIT :start, :length
        ";

        $stmt = $this->db->prepare($query);

        // Convert the search term to a partial date format for the database
        $searchPartialDate = null;
        if (!empty($search)) {
            $searchPartialDate = date('M d', strtotime($search)); // Convert to 'Feb 07' format
        }

        // Bind the parameters
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':searchPartialDate', "%$searchPartialDate%", PDO::PARAM_STR);
        $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
        $stmt->bindValue(':length', (int)$length, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Helper function to fetch column names from the events table
    private function getEventTableColumns() {
        $query = "DESCRIBE events";
        $stmt = $this->db->query($query);
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $columns;
    }

    public function getTotalEventCount() {
        $query = "SELECT COUNT(*) as total FROM events";
        $stmt = $this->db->query($query);
        return $stmt->fetchColumn();
    }

    public function getFilteredEventCount($search) {
        $query = "SELECT COUNT(*) as total FROM events WHERE name LIKE :search OR description LIKE :search";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}
