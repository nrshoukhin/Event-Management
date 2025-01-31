$(document).ready(function () {
    $('#attendeeForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission behavior

        // Collect form data
        const formData = {
            name: $('#name').val().trim(),
            email: $('#email').val().trim(),
            event_id: $('#event-id').val()
        };

        // Client-side validation
        if (!formData.name) {
            showAlert('Name is required.', 'danger');
            return;
        }
        if (!formData.email || !validateEmail(formData.email)) {
            showAlert('Please enter a valid email address.', 'danger');
            return;
        }

        $("#register-btn").LoadingOverlay("show");
        // AJAX request to submit the form
        $.ajax({
            url: `${baseUrl}attendee/submit_registration`, // Update the URL as needed
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                $("#register-btn").LoadingOverlay("hide");
                if (response.success) {
                    showAlert(response.message, 'success');
                    $('#attendeeForm')[0].reset(); // Reset the form
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function (xhr, status, error) {
                $("#register-btn").LoadingOverlay("hide");
                showAlert('An error occurred while processing your request. Please try again.', 'danger');
            }
        });
    });

    // Utility function to validate email
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Utility function to show alert messages
    function showAlert(message, type) {
        // Create the alert box HTML
        const alertBox = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                            ${message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>`;
        
        // Prepend the alert box to the register card
        $('.register-card').prepend(alertBox);

        // Select the alert box
        const alertBoxSelector = document.querySelector('.alert');

        if (alertBoxSelector) {
            // Automatically fade out the alert after 5 seconds
            setTimeout(() => {
                alertBoxSelector.classList.add('fade');
                alertBoxSelector.classList.remove('show');

                // Wait for the fade-out transition to complete, then remove the element
                setTimeout(() => {
                    alertBoxSelector.remove();
                }, 150); // Match Bootstrap's fade-out transition duration (150ms)
            }, 5000);
        }
    }
});