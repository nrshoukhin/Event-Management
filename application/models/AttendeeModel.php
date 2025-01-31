<?php

class AttendeeModel extends Model {
    public function registerAttendee($event_id, $name, $email) {
        $stmt = $this->db->prepare("INSERT INTO attendees (event_id, attendee_name, attendee_email) VALUES (?, ?, ?)");
        return $stmt->execute([$event_id, $name, $email]);
    }

    public function getAttendeesByEventId($event_id) {
        $stmt = $this->db->prepare("SELECT * FROM attendees WHERE event_id = ?");
        $stmt->execute([$event_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalAttendees() {
        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM attendees");
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function isAlreadyRegistered($event_id, $email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM attendees WHERE event_id = ? AND attendee_email = ?");
        $stmt->execute([$event_id, $email]);
        return $stmt->fetchColumn() > 0; // Returns true if the count is greater than 0
    }
}
