# Where to Find Controllers

## 📁 Location

**All controllers are in:**
```
app/Http/Controllers/
```

---

## 📂 Current Controllers Structure

```
app/Http/Controllers/
├── Controller.php                    (Base controller - all controllers extend this)
├── ProfileController.php             (User profile management)
└── Auth/                             (Authentication controllers)
    ├── AuthenticatedSessionController.php    (Login/Logout)
    ├── RegisteredUserController.php          (Registration)
    ├── PasswordResetLinkController.php       (Forgot password)
    ├── NewPasswordController.php             (Reset password)
    ├── PasswordController.php                (Update password)
    ├── ConfirmablePasswordController.php     (Confirm password)
    ├── EmailVerificationPromptController.php (Email verification)
    ├── EmailVerificationNotificationController.php (Resend verification)
    └── VerifyEmailController.php             (Verify email)
```

---

## 🔍 How to Access Controllers

### In Your Code Editor:
1. Open: `app/Http/Controllers/`
2. See all controllers listed
3. `Auth/` folder contains authentication controllers

### In File Explorer:
```
C:\Users\hagar\OneDrive\Desktop\Event-Bulletin-Board\app\Http\Controllers\
```

---

## 📝 Controller Files Explained

### Main Controllers:

#### `Controller.php`
- **Purpose:** Base controller class
- **What it does:** All other controllers extend this
- **Location:** `app/Http/Controllers/Controller.php`

#### `ProfileController.php`
- **Purpose:** Handles user profile operations
- **Methods:**
  - `edit()` - Show edit profile page
  - `update()` - Update profile information
  - `destroy()` - Delete user account
- **Location:** `app/Http/Controllers/ProfileController.php`

---

### Authentication Controllers (`Auth/` folder):

#### `AuthenticatedSessionController.php`
- **Purpose:** Handles login and logout
- **Methods:**
  - `create()` - Show login page
  - `store()` - Process login
  - `destroy()` - Logout user
- **Location:** `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

#### `RegisteredUserController.php`
- **Purpose:** Handles user registration
- **Methods:**
  - `create()` - Show registration page
  - `store()` - Create new user account
- **Location:** `app/Http/Controllers/Auth/RegisteredUserController.php`

#### `PasswordResetLinkController.php`
- **Purpose:** Handles "forgot password" requests
- **Methods:**
  - `create()` - Show forgot password page
  - `store()` - Send password reset email
- **Location:** `app/Http/Controllers/Auth/PasswordResetLinkController.php`

#### `NewPasswordController.php`
- **Purpose:** Handles password reset
- **Methods:**
  - `create()` - Show reset password page
  - `store()` - Update password
- **Location:** `app/Http/Controllers/Auth/NewPasswordController.php`

---

## 🎯 Quick Reference

| Controller | Purpose | Location |
|------------|---------|----------|
| `AuthenticatedSessionController` | Login/Logout | `app/Http/Controllers/Auth/` |
| `RegisteredUserController` | Registration | `app/Http/Controllers/Auth/` |
| `ProfileController` | Profile management | `app/Http/Controllers/` |
| `PasswordResetLinkController` | Forgot password | `app/Http/Controllers/Auth/` |
| `NewPasswordController` | Reset password | `app/Http/Controllers/Auth/` |

---

## 🚀 When We Build Events Feature

We'll create:
```
app/Http/Controllers/
└── EventController.php    (New - we'll create this!)
```

**Command to create it:**
```cmd
php artisan make:controller EventController --resource
```

This will create `app/Http/Controllers/EventController.php` with all CRUD methods!

---

## 💡 Tips

### To view a controller:
1. Navigate to: `app/Http/Controllers/`
2. Open the controller file you want
3. See the methods (functions) inside

### To create a new controller:
```cmd
php artisan make:controller YourControllerName
```

### To create controller with resource methods:
```cmd
php artisan make:controller YourControllerName --resource
```

---

## 📍 Full Path

**Windows:**
```
C:\Users\hagar\OneDrive\Desktop\Event-Bulletin-Board\app\Http\Controllers\
```

**In your project:**
```
app/Http/Controllers/
```

---

**That's where all controllers live!** 🎯

