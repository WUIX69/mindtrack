# Authentication Flow - MindTrack

## 🔐 Modern AJAX-Based Authentication

MindTrack uses a **server-driven routing** approach where the backend determines the redirect route based on user role, and the frontend handles the actual redirect via AJAX.

---

## 🔄 Complete Flow

### 1. User Visits Landing Page

```
http://localhost/mindtrack/
    ↓
index.php (redirects)
    ↓
app/landing/index.php
```

### 2. User Clicks Login

```
Landing Page
    ↓
app/auth/index.php (Login Form)
```

### 3. User Submits Credentials

```javascript
// Frontend: app/auth/index.php
$("#loginForm").form({
  onSuccess: function (event, fields) {
    $.ajax({
      url: apiURL("auth") + "login.php",
      method: "POST",
      data: fields, // { username, password }
      success: function (response) {
        if (response.success) {
          // Server tells us where to go
          window.location.replace(response.data.route);
        }
      },
    });
  },
});
```

### 4. Server Validates & Returns Route

```php
// Backend: features/auth/servers/login.php

// Validate credentials
if ($username === 'admin' && $password === 'admin1234') {
    // Set session
    $_SESSION['logged_in'] = true;
    $_SESSION['role'] = 'admin';

    // Return success with route
    $response = [
        'success' => true,
        'message' => 'Welcome admin!',
        'data' => [
            'route' => app('patients'),  // Server determines route
            'user' => [...]
        ]
    ];
}
```

### 5. Frontend Redirects to Route

```javascript
// Redirect to route from server response
window.location.replace(response.data.route);
    ↓
app/patients/index.php (Patient Dashboard)
// OR
app/doctors/index.php (Doctor Dashboard)
```

---

## 📋 Authentication Server API

**Endpoint:** `features/auth/servers/login.php`

### Request

```javascript
POST /features/auth/servers/login.php
Content-Type: application/x-www-form-urlencoded

{
    "username": "admin",
    "password": "admin1234"
}
```

### Response Format

```json
{
  "success": true,
  "message": "Welcome admin!",
  "data": {
    "route": "/mindtrack/app/patients/index.php",
    "user": {
      "id": 1,
      "username": "admin",
      "role": "admin"
    }
  }
}
```

### Error Response

```json
{
  "success": false,
  "message": "Invalid username and/or password!",
  "data": null
}
```

---

## 👥 User Roles & Routes

### Admin

```php
// Credentials: admin / admin1234
'role' => 'admin'
'route' => app('patients')  // Redirects to patient dashboard
```

### Doctor

```php
// Credentials: doctor / doctor1234
'role' => 'doctor'
'route' => app('doctors')  // Redirects to doctor dashboard
```

### Patient

```php
// Credentials: patient / patient1234
'role' => 'patient'
'route' => app('patients')  // Redirects to patient dashboard
```

---

## 🔧 Implementation Details

### Frontend (app/auth/index.php)

**Key Features:**

- Fomantic UI form validation
- AJAX submission
- Loading states
- Success/error message display
- Server-driven redirect

**Code:**

```javascript
$.ajax({
  url: apiURL("auth") + "login.php",
  method: "POST",
  data: fields,
  dataType: "json",
  timeout: 5000,
  beforeSend: function () {
    $submitBtn.addClass("loading"); // Show loading
  },
  success: function (response) {
    if (response.success) {
      // Show success message
      $("#successMessage").show();

      // Redirect to server-provided route
      window.location.replace(response.data.route);
    } else {
      // Show error message
      $("#errorMessage").show();
    }
  },
  complete: function () {
    $submitBtn.removeClass("loading"); // Hide loading
  },
});
```

### Backend (features/auth/servers/login.php)

**Key Features:**

- API headers (JSON response)
- Request method validation
- Credential validation
- Session management
- Role-based routing
- Global `$response` array

**Code:**

```php
<?php
require_once __DIR__ . '/../../../core/app.php';
apiHeaders();

try {
    // Validate request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $response['message'] = 'Invalid request method';
        echo json_encode($response);
        exit;
    }

    // Get credentials
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate credentials (TODO: Replace with database)
    if ($username === 'admin' && $password === 'admin1234') {
        // Set session
        $_SESSION['logged_in'] = true;
        $_SESSION['role'] = 'admin';
        session_write_close();

        // Return success with route
        $response = array_merge($response, [
            'success' => true,
            'message' => 'Welcome admin!',
            'data' => [
                'route' => app('patients'),
                'user' => [...]
            ]
        ]);
    } else {
        $response['message'] = 'Invalid credentials!';
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    $response['message'] = 'Login error';
}

echo json_encode($response);
exit;
```

---

## 🎯 Benefits of This Approach

### 1. **Server Controls Navigation**

- Backend determines where user should go
- Frontend doesn't need to know routing logic
- Easy to change routes without touching frontend

### 2. **No Intermediate Redirects**

- Old way: Login → mindtrack.php → Dashboard (2 redirects)
- New way: Login → Dashboard (1 redirect)
- Faster and cleaner

### 3. **Better UX**

- AJAX submission (no page reload)
- Loading states
- Inline error messages
- Smooth transitions

### 4. **Consistent API Pattern**

- All server responses follow same format
- Easy to add more features
- Predictable error handling

### 5. **Separation of Concerns**

- Frontend: UI and user interaction
- Backend: Business logic and routing
- Clear boundaries

---

## 🔒 Security Considerations

### 1. Session Management

```php
// Set session variables
$_SESSION['logged_in'] = true;
$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];
$_SESSION['login_time'] = time();

// Write and close session
session_write_close();
```

### 2. Password Verification

```php
// TODO: Use password_verify() with hashed passwords
if (password_verify($password, $user['password'])) {
    // Login successful
}
```

### 3. HTTPS

- Use HTTPS in production
- Secure session cookies
- CSRF protection

### 4. Rate Limiting

- Implement login attempt limits
- Prevent brute force attacks

---

## 📝 TODO: Database Integration

Replace hardcoded credentials with database queries:

```php
// Current (hardcoded)
if ($username === 'admin' && $password === 'admin1234') {
    // ...
}

// TODO: Database authentication
use MindTrack\Models\Users;

$user = Users::singleWhereUsername($username);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    $route = match($user['role']) {
        'admin' => app('patients'),
        'doctor' => app('doctors'),
        'patient' => app('patients'),
        default => app('auth')
    };

    $response = array_merge($response, [
        'success' => true,
        'message' => "Welcome {$user['name']}!",
        'data' => [
            'route' => $route,
            'user' => [
                'id' => $user['id'],
                'name' => $user['name'],
                'role' => $user['role']
            ]
        ]
    ]);
}
```

---

## 🧪 Testing

### Test Login Flow

**Admin:**

- Username: `admin`
- Password: `admin1234`
- Expected: Redirect to `/app/patients/index.php`

**Doctor:**

- Username: `doctor`
- Password: `doctor1234`
- Expected: Redirect to `/app/doctors/index.php`

**Patient:**

- Username: `patient`
- Password: `patient1234`
- Expected: Redirect to `/app/patients/index.php`

**Invalid:**

- Username: `invalid`
- Password: `invalid`
- Expected: Error message "Invalid username and/or password!"

---

## ✅ Summary

**Old Flow:**

```
Login Form → POST → Login Script → mindtrack.php → Check Role → Redirect
```

**New Flow:**

```
Login Form → AJAX → Server (determines route) → JSON Response → Frontend Redirect
```

**Key Improvements:**

- ✅ Server-driven routing
- ✅ AJAX-based (no page reload)
- ✅ Consistent API pattern
- ✅ Better error handling
- ✅ Cleaner code
- ✅ Faster redirects

This is the modern, professional way to handle authentication! 🚀
