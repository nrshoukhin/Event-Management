$(document).ready(function () {
    // Initialize Events DataTable
    $('#eventsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false, // Disable the search functionality
        "ajax": {
            "url": `${baseUrl}search/getEvents`,
            "type": "GET",
            "data": {
                "query": queryString
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "description" },
            { "data": "max_capacity" },
            { "data": "current_capacity" },
            { 
                "data": "event_date_time",
                "render": function(data) {
                    const options = { 
                        day: '2-digit', 
                        month: 'short', 
                        year: 'numeric', 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        hour12: true 
                    };
                    return new Intl.DateTimeFormat('en-US', options).format(new Date(data));
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function (data) {
                    return `
                        <button class="btn btn-primary btn-sm view-details" data-id="${data.id}" data-type="event">View Event</button>
                    `;
                }
            }
        ],
        "responsive": true // Enable responsive extension
    });

    // Initialize Attendees DataTable
    $('#attendeesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false, // Disable the search functionality
        "ajax": {
            "url": `${baseUrl}search/getAttendees`,
            "type": "GET",
            "data": {
                "query": queryString
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "email" },
            { "data": "event_name" },
            { 
                "data": "registered_at",
                "render": function(data) {
                    const options = { 
                        day: '2-digit', 
                        month: 'short', 
                        year: 'numeric', 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        hour12: true 
                    };
                    return new Intl.DateTimeFormat('en-US', options).format(new Date(data));
                }
            },
            {
                "data": null,
                "orderable": false,
                "render": function (data) {
                    return `
                        <button class="btn btn-primary btn-sm view-details" data-id="${data.id}" data-type="attendee">View Profile</button>
                    `;
                }
            }
        ],
        "responsive": true // Enable responsive extension
    });
});