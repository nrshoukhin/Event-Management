$(document).ready(function() {

    $('#eventsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": `${baseUrl}dashboard/getEventsAjax`,
            "type": "GET"
        },
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { 
                "data": null, 
                "render": function(data) {
                    return `<span class="badge bg-secondary">${data.current_capacity}/${data.max_capacity}</span>`;
                } 
            },
            { 
                "data": "event_date_time",
                "render": function(data) {
                    if (!data) return ""; // Handle empty date values
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
                "className": "text-center",
                "render": function(data) {
                    let actionButtons = `
                        <button class="btn btn-info btn-sm view-event" data-id="${data.id}" data-bs-toggle="modal" data-bs-target="#eventDetailsModal">View</button>
                        <a href="${baseUrl}event/edit/${data.id}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="${baseUrl}event/delete/${data.id}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                        <button class="btn btn-success btn-sm copy-link" data-link="Attendee/register/${data.id}">Copy Link</button>
                    `;

                    if (adminCheck === 1) {
                        actionButtons += `
                            <a href="${baseUrl}attendee/export/${data.id}" class="btn btn-primary btn-sm">Download CSV</a>
                        `;
                    }

                    return actionButtons;
                }
            }
        ],
        "order": [[3, "desc"]],
        "responsive": true
    });

    // Handle click event on "Share Event Link" button
    $(document).on('click', '.copy-link', function () {
        // Get the event link from the data attribute
        const eventLink = $(this).data('link');
        const fullLink = `${baseUrl}${eventLink}`; // Create the full URL

        // Create a temporary input element to copy the link
        const tempInput = $('<input>');
        $('body').append(tempInput);
        tempInput.val(fullLink).select();
        document.execCommand('copy');
        tempInput.remove();

        // Show a success message (optional)
        alert(`Event link copied to clipboard: ${fullLink}`);
    });

    // Handle Event View Modal
    $(document).on('click', '.view-event', function () {
        const eventId = $(this).data('id');

        $.ajax({
            url: `${baseUrl}event/details/${eventId}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#modalEventName').text(response.name);
                    $('#modalEventDescription').text(response.description);
                    $('#modalEventCapacity').text(`${response.current_capacity}/${response.max_capacity}`);
                    $('#modalEventDate').text(new Intl.DateTimeFormat('en-US', {
                        day: '2-digit', 
                        month: 'short', 
                        year: 'numeric', 
                        hour: '2-digit', 
                        minute: '2-digit', 
                        hour12: true
                    }).format(new Date(response.event_date_time)));
                }
            }
        });
    });
});