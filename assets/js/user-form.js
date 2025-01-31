$(document).ready(function () {
    let onSubmissionValid = true;
    // Validate on form submit
    $('#registerForm').on('submit', function (e) {
        console.log(onSubmissionValid);
        // Clear previous error messages
        $('#emailError').text('');
        $('#passwordError').text('');
        $('#firstNameError').text('');
        $('#lastNameError').text('');
        $('#email').removeClass('is-invalid');
        $('#password').removeClass('is-invalid');
        $('#first-name').removeClass('is-invalid');
        $('#last-name').removeClass('is-invalid');

        //First Name validation
        const firstName = $('#first-name').val().trim();
        if (firstName.length === 0) {
            onSubmissionValid = false;
            $('#first-name').addClass('is-invalid');
            $('#firstNameError').text('First Name is Required.');
        }

        //Last Name validation
        const lastName = $('#last-name').val().trim();
        if (lastName.length === 0) {
            onSubmissionValid = false;
            $('#last-name').addClass('is-invalid');
            $('#lastNameError').text('Last Name is Required.');
        }

        //Password validation
        const password = $('#password').val();
        if (password.length === 0) {
            onSubmissionValid = false;
            $('#password').addClass('is-invalid');
        }

        //Confirm Password validation
        const confirmPassword = $('#confirm-password').val();
        if (confirmPassword.length === 0) {
            onSubmissionValid = false;
            $('#confirm-password').addClass('is-invalid');
            $('#confirmPasswordError').text('Confirm Password is Required.');
        }

        // Email validation
        const email = $('#email').val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            onSubmissionValid = false;
            $('#email').addClass('is-invalid');
            $('#emailError').text('Please enter a valid email address.');
        }

        // Prevent form submission if invalid
        if (!onSubmissionValid) {
            e.preventDefault();
        }
    });

    // Real-time email validation
    $('#email').on('input', function () {
        const email = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $(this).addClass('is-invalid');
            $('#emailError').text('Please enter a valid email address.');
        } else {
            $(this).removeClass('is-invalid');
            $('#emailError').text('');
        }
    });

    // Real-time password validation
    $('#password').on('input', function () {
        let isValid = true;
        const password = $(this).val().trim();

        // Clear previous error messages
        $('#passwordError').text('');
        $('#password').removeClass('is-invalid');
        $('#passwordCriteria li').removeClass('text-success');
        $('#passwordCriteria li').addClass('text-danger');

        // Check if password has at least one uppercase letter
        const hasUppercase = /[A-Z]/.test(password);
        if (hasUppercase) {
            $('#uppercaseCriteria').removeClass('text-danger').addClass('text-success');
        } else {
            isValid = false;
        }

        // Check if password has at least one uppercase letter
        const hasLowercase = /[a-z]/.test(password);
        if (hasLowercase) {
            $('#lowercaseCriteria').removeClass('text-danger').addClass('text-success');
        } else {
            isValid = false;
        }

        // Check if password has at least one number
        const hasNumber = /\d/.test(password);
        if (hasNumber) {
            $('#numberCriteria').removeClass('text-danger').addClass('text-success');
        } else {
            isValid = false;
        }

        // Check if password has at least one special character
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        if (hasSpecialChar) {
            $('#specialCharCriteria').removeClass('text-danger').addClass('text-success');
        } else {
            isValid = false;
        }

        // Check if password length is at least 6 characters
        if (password.length >= 6) {
            $('#lengthCriteria').removeClass('text-danger').addClass('text-success');
        } else {
            isValid = false;
        }

        // Update password input validation class based on overall validity
        if (!isValid) {
            onSubmissionValid = false;
            $('#password').addClass('is-invalid');
            $('#passwordError').text('Password does not meet the required criteria.');
        } else {
            onSubmissionValid = true;
            $('#password').removeClass('is-invalid');
        }
    });

    // Real-time Confirm Password validation
    $('#confirm-password').on('input', function () {
        const password = $('#password').val().trim();
        const confirmPassword = $(this).val().trim();

        if (password !== confirmPassword) {
            $(this).addClass('is-invalid');
            $('#confirmPasswordError').text('Passwords do not match.');
        } else {
            $(this).removeClass('is-invalid');
            $('#confirmPasswordError').text('');
        }
    });
});