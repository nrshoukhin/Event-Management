# Event Management System

## Project Overview
This Event Management System is a web-based platform designed to efficiently handle event creation, attendee registration, and reporting. Built with a custom framework developed in pure PHP. This platform supports both admins and regular users, providing secure authentication, AJAX-powered tables, and responsive user interfaces.

---

## Features

### User Management:
- **User Authentication**: Secure login and registration with password hashing.
- **Role-based Access**: Separate access for Admins and Regular Users.

### Event Management:
- **Create Events**: Add event details such as name, description, max capacity, and date-time.
- **Edit and Delete Events**: Modify or remove existing events.
- **Event Listings**: View events in a sortable and searchable table with server-side pagination.
- **Copy Event Registration Link**: Easily copy the registration link to share the event registration form for a specific event.

### Attendee Management:
- **Register for Events**: Users can register for events via a form.
- **Capacity Validation**: Prevent over-registration if the maximum capacity is reached.
- **Duplicate Check**: Validate unique registrations by email.
- **Export Attendees**: Admins can download attendee lists in CSV format for a particular event.

### Unified Search:
- Search for attendees and events using a single search box, spanning across all events and attendees.

### Dashboard:
- **Key Metrics**: View total events, total attendees, and upcoming events.
- **Displayed in a sortable and searchable table**: Events are shown in a table using DataTables, sorted by event date and time in descending order.

### Dynamic Features:
- **AJAX Integration**: For faster, smoother table updates.
- **AJAX-Based Form Submission**: Event registration form submission is handled via AJAX for a seamless user experience.
- **JSON API Endpoint**: Provides programmatic access to event details for integration with other systems.
- **Responsive UI**: Built using Bootstrap for optimal display across devices.

### API Security:
- **JWT Authentication**: The API uses JSON Web Tokens (JWT) for secure access.
- **Token Validity**: Tokens are valid for 1 hour. After expiration, a new token must be generated.

---

## Installation Instructions

### Prerequisites:
1. **Web Server**: Apache or Nginx.
2. **PHP**: Version 7.4 or above.
3. **Database**: MySQL 5.7 or above.

### Installation Steps:
1. **Clone the Repository:**
   ```bash
   git clone https://github.com/nrshoukhin/Event-Management.git
   ```

2. **Set Up the Database:**
   - Import the `database.sql` file into your MySQL database.

3. **Configure the Application:**
   - Open the `system\config\config.php` file and set your database credentials:
     ```php
     $host = 'localhost';
     $dbname = 'your_database_name';

     define('DSN', "mysql:host=$host;dbname=$dbname;charset=utf8");
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');

     // Dynamically configure BASE_URL and BASE_PATH
     $baseUrl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
     $basePath = trim(parse_url($baseUrl, PHP_URL_PATH), '/');

     define('BASE_URL', rtrim($baseUrl, '/') . '/');
     define('BASE_PATH', $basePath !== '' ? '/' . $basePath . '/' : '/');
     ```

4. **Start the Development Server:** Start the server that you are using (e.g., Apache, Nginx)

5. **Access the Application:** Open your browser and navigate to your hosting domain where you configured the system.

---

## Testing Login Credentials

### Admin Login:
- **Email:** admin@mail.com
- **Password:** `Admin123@`

### Regular User Login:
- A regular user can register themselves using the form.

---

## How to Use the API

### 1. Generate a Token
The first step is to get a valid JWT token by calling the `generate_token` endpoint with this secret key: `f9a8e17b6c58d3f2e739b5c6e2a4e9b67f1c3d8a76e2b3c49d5e0a3f2b6c9d2e`. This token will be used for authentication in subsequent API requests.

#### Request:
```http
GET https://example.com/api/generate_token?secretKey=f9a8e17b6c58d3f2e739b5c6e2a4e9b67f1c3d8a76e2b3c49d5e0a3f2b6c9d2e
```

#### Response:
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2V4YW1wbGUuY29tIiwiaWF0IjoxNjg3Mzg2NjIwLCJleHAiOjE2ODczOTAyMjAsInVzZXJfaWQiOjF9.0zxKGHhUIpyr3zLEhzEaC4pmO61Ehv9akMs0pQblgCY"
}
```

### 2. Use the Token to Access Secure Endpoints
To access secure endpoints like `event_details`, include the token in the `Authorization` header as a Bearer token.

#### Request:
```http
GET https://example.com/api/event_details/<event_id>
-H "Authorization: Bearer <your_generated_token>"
```

Put the token you got in Step 1 where it says `<your_generated_token>`. Then, replace `<event_id>` with the ID of the event you want to get details for.

#### Example Response (Success):
```json
{
    "id": 1,
    "name": "Annual Tech Conference",
    "description": "A conference for tech enthusiasts.",
    "max_capacity": 500,
    "current_capacity": 320,
    "event_date_time": "2025-12-01 10:00:00"
}
```

#### Example Response (Unauthorized):
```json
{
    "error": "Invalid or expired token."
}
```

---

## Framework Overview
This system is built using a custom PHP framework developed specifically for this project. Key features of the framework include:

1. **MVC Architecture:**
   - Separation of concerns with Models, Views, and Controllers.

2. **Routing System:**
   - Clean URLs with dynamic routing.
   - Automatic mapping of controllers and methods.

3. **Database Handling:**
   - PDO for secure database operations.
   - Prepared statements to prevent SQL injection.

4. **Session Management:**
   - Built-in session handling for user authentication.

5. **Custom Helpers:**
   - Utility functions for sanitization and redirection.

6. **Dynamic Configuration:**
   - BASE_URL and BASE_PATH are dynamically configured based on the server environment, ensuring flexibility and compatibility across different setups.

This lightweight framework provides ease of development while avoiding the complexity and overhead of traditional frameworks like Laravel or CodeIgniter.

## **Database Schema**

This database is designed for the **event management system**. It consists of multiple tables that store information related to **users, events, attendees, and other relevant entities**.

### **Tables Overview:**

#### **`attendees`**

This table stores attendee registration details for various events.

- `id` (int) - Unique identifier for each attendee.
- `event_id` (int) - References the event the attendee registered for.
- `attendee_name` (varchar(100)) - Name of the attendee.
- `attendee_email` (varchar(100)) - Email of the attendee.
- `registered_at` (timestamp) - Timestamp of when the attendee registered.

#### **`events`**

This table stores event details.

- `id` (int) - Unique identifier for each event.
- `name` (varchar(100)) - Name of the event.
- `description` (text) - Description of the event.
- `max_capacity` (int) - Maximum number of attendees allowed.
- `current_capacity` (int) - Current number of registered attendees.
- `event_date_time` (timestamp) - Scheduled date and time of the event.
- `created_by` (int) - User ID of the event creator.\*\*


- `created_at` (timestamp) - Timestamp when the event was created.

#### **`users`**

This table stores user account details.

- `id` (int) - Unique identifier for each user.
- `first_name` (varchar(80)) - First name of the user.
- `last_name` (varchar(80)) - Last name of the user.
- `email` (varchar(50)) - User’s email (used for login).
- `password` (varchar(255)) - Hashed password for authentication.
- `is_admin` (tinyint(1)) - Determines if the user has admin privileges (1 = Admin, 0 = Regular user).
- `created_at` (timestamp) - Timestamp when the user account was created.

---

### **Relational Integrity**

- The **`attendees`** table references **`events`** through `event_id`, ensuring that attendees are always linked to an existing event.
- The **`events`** table references **`users`** through `created_by`, ensuring only registered users can create events.
- The **`users`** table maintains account credentials and permissions for different types of users (Admin/Regular).

This schema ensures **efficient storage and retrieval of event-related data** while maintaining **relational integrity**.
