$(document).ready(function() {
    const $searchInput = $("#searchInput");
    const $searchResults = $("#searchResults");

    // Handle input event for live search
    $searchInput.on("input", function () {
        const query = $(this).val().trim();

        if (query.length > 2) {
            // Show loader or clear previous results
            $searchResults.show().html('<p class="text-muted">Searching...</p>');

            // Perform Ajax request
            $.ajax({
                url: `${baseUrl}search/liveSearch`,
                type: "GET",
                data: { query: query },
                dataType: "json",
                success: function (data) {
                    const results = data.results;
                    const hasMore = data.hasMore;

                    if (results.length > 0) {
                        // Populate results dynamically
                        let resultsHtml = results.map(item => `
                            <a href="javascript:void(0)" data-id="${item.id}" data-type="${item.link}" class="dropdown-item view-details">
                                ${item.label}
                            </a>
                        `).join('');

                        // Add "View More" link if there are more results
                        if (hasMore) {
                            resultsHtml += `
                                <a href="${baseUrl}search/searchResults?query=${query}" class="dropdown-item text-primary">
                                    View More Results
                                </a>
                            `;
                        }

                        $searchResults.html(resultsHtml);
                    } else {
                        $searchResults.html('<p class="text-muted">No results found.</p>');
                    }
                },
                error: function () {
                    $searchResults.html('<p class="text-danger">Error fetching results. Please try again.</p>');
                }
            });
        } else {
            $searchResults.hide(); // Hide results if query length is too short
        }
    });

    // Prevent search input from losing focus when clicking on the dropdown
    $searchResults.on("mousedown", function (e) {
        e.preventDefault(); // Prevent input blur
    });

    // Hide search results when clicking outside the form
    $(document).on("click", function (e) {
        if (!$("#searchForm").has(e.target).length) {
            $searchResults.hide();
        }
    });

    // Handle click event on "View" buttons
    $(document).on('click', '.view-details', function () {
        const id = $(this).data('id');
        const type = $(this).data('type');

        // Show the modal
        $('#detailsModal').modal('show');

        // Update modal title
        const modalTitle = type === 'event' ? 'Event Details' : 'Attendee Details';
        $('#detailsModalLabel').text(modalTitle);

        // Show loading indicator
        $('#detailsContent').html('<p>Loading...</p>');

        // Fetch details via AJAX
        $.ajax({
            url: `${baseUrl}search/getDetails`,
            type: 'GET',
            data: { id: id, type: type },
            success: function (response) {
                // Populate modal content
                $('#detailsContent').html(response);
            },
            error: function () {
                $('#detailsContent').html('<p class="text-danger">Error loading details. Please try again.</p>');
            }
        });
    });
});