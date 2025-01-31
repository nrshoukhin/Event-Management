<?php

class Auth extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email']);
            $password = sanitize($_POST['password']);
            $errors = [];

            // Server-side validation
            if (empty($email)) {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format.';
            }

            if (empty($password)) {
                $errors[] = 'Password is required.';
            }

            if (!empty($errors)) {
                $this->view('auth/login', ['error' => implode('<br>', $errors)]);
                return;
            }

            $userModel = $this->model('UserModel');
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Start session and set user data
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['is_admin'] = $user['is_admin'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];

                redirect(BASE_URL . 'dashboard');
            } else {
                $this->view('auth/login', ['error' => 'Invalid email or password.']);
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email']);
            $first_name = sanitize($_POST['first_name']);
            $last_name = sanitize($_POST['last_name']);
            $password = $_POST['password'];
            $confirm_password  = $_POST['confirm_password'];
            $errors = [];

            // Server-side validation
            if (empty($email)) {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format.';
            }

            if (empty($password)) {
                $errors[] = 'Password is required.';
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/', $password)) {
                $errors[] = 'Password must be at least 6 characters long, include one uppercase letter, one lowercase letter, one number, and one special character.';
            }

            // Confirm Password validation
            if ($password !== $confirm_password) {
                $errors[] = 'Passwords do not match.';
            }

            $userModel = $this->model('UserModel');

            // Check if email already exists
            if (empty($errors) && $userModel->getUserByEmail($email)) {
                $errors[] = 'Email is already registered.';
            }

            if (!empty($errors)) {
                $this->view('auth/register', ['error' => implode('<br>', $errors)]);
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Create the user
                if ($userModel->createUser($email, $hashedPassword, $first_name, $last_name)) {
                    // Set a success flash message in the session
                    $_SESSION['success_message'] = 'Registration successful! Please login to continue.';
                    redirect(BASE_URL . 'auth/login');
                } else {
                    $this->view('auth/register', ['error' => 'Unable to register. Please try again.']);
                }
            }
        } else {
            $this->view('auth/register');
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        redirect(BASE_URL . 'auth/login');
    }
}
