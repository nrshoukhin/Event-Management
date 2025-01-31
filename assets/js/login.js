$(document).ready(function () {
    // Validate on form submit
    $('#loginForm').on('submit', function (e) {
        let isValid = true;

        // Clear previous error messages
        $('#emailError').text('');
        $('#passwordError').text('');
        $('#email').removeClass('is-invalid');
        $('#password').removeClass('is-invalid');

        // Email validation
        const email = $('#email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            isValid = false;
            $('#email').addClass('is-invalid');
            $('#emailError').text('Please enter a valid email address.');
        }

        // Password validation
        const password = $('#password').val().trim();
        if (password.length === 0) {
            isValid = false;
            $('#password').addClass('is-invalid');
            $('#passwordError').text('Password is required.');
        }

        // Prevent form submission if invalid
        if (!isValid) {
            e.preventDefault();
        }
    });
});