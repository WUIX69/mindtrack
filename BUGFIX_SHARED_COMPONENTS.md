# Shared Components Bugfix

## 🐛 Issue

When visiting the landing page (`app/landing/index.php`), shared components were not loading properly.

---

## 🔍 Root Causes

### 1. Incorrect Path Resolution in `includeFileHelper()`

**Location:** `utils/functions.php`

**Problem:**

```php
// BEFORE - INCORRECT
$dir_path = dirname(dirname(__DIR__)) . '/' . $dir . '/';
```

This was going **one level too high**:

- `__DIR__` = `/utils/`
- `dirname(__DIR__)` = `/` (project root) ✅
- `dirname(dirname(__DIR__))` = parent of project (WRONG!) ❌

**Solution:**

```php
// AFTER - CORRECT
global $config;
$root_path = $config['root_path'] ?? dirname(__DIR__);
$dir_path = $root_path . '/' . ($dir ? $dir . '/' : '');
```

Now uses the `root_path` from config for accurate path resolution.

---

### 2. Incorrect `root_path` in Config

**Location:** `core/config.php`

**Problem:**

```php
// BEFORE - INCORRECT
'root_path' => $_SERVER['DOCUMENT_ROOT'],  // C:\xampp\htdocs
```

This pointed to the web server's document root, not the project root!

**Solution:**

```php
// AFTER - CORRECT
'root_path' => __DIR__ . '/../',  // Project root: C:\xampp\htdocs\mindtrack
```

Now correctly points to the MindTrack project root directory.

---

### 3. Missing Font Awesome

**Location:** `components/elements/styles.php`

**Problem:**
The landing page uses Font Awesome icons (`fas fa-heartbeat`, etc.) but Font Awesome CSS wasn't being loaded.

**Solution:**
Added Font Awesome CDN:

```php
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">';
```

---

### 4. Environment Variable Fallbacks

**Location:** `core/config.php`

**Problem:**
If `.env` file doesn't exist or variables aren't set, the app would fail.

**Solution:**
Added fallback defaults:

```php
'app' => [
    'base_url' => $_ENV['APP_URL'] ?? 'http://localhost/mindtrack',
    'name' => $_ENV['APP_NAME'] ?? 'MindTrack',
],
'db' => [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'name' => $_ENV['DB_DATABASE'] ?? 'mindtrack',
    // ... etc
],
```

---

## ✅ Fixes Applied

### 1. Updated `utils/functions.php`

```php
function includeFileHelper($dir, $file)
{
    global $config;

    // Use the root_path from config for accurate path resolution
    $root_path = $config['root_path'] ?? dirname(__DIR__);

    // Build the directory path
    $dir_path = $root_path . '/' . ($dir ? $dir . '/' : '');

    // Construct the full path to the file
    $file_path = $dir_path . $file . '.php';

    try {
        if (!file_exists($file_path)) {
            throw new Exception("File not found: $file_path");
        }
        include $file_path;
    } catch (Exception $e) {
        error_log("Shared file Error: " . $e->getMessage());
        error_log("Attempted path: " . $file_path);
    }
}
```

### 2. Updated `core/config.php`

```php
$config = [
    'sub_folder' => 'mindtrack',
    'root_path' => __DIR__ . '/../',  // Correct project root
    'uri_path' => $_SERVER['REQUEST_URI'],
    'app' => [
        'base_url' => $_ENV['APP_URL'] ?? 'http://localhost/mindtrack',
        'assets_url' => '/assets',
        'name' => $_ENV['APP_NAME'] ?? 'MindTrack',
    ],
    // ... with fallbacks for all env variables
];
```

### 3. Updated `components/elements/styles.php`

```php
<?php
global $config;

// Include jQuery 3.4+ before Fomantic
echo '<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>';

// Include Font Awesome ← NEW!
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">';

// Include Fomantic UI CSS
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.9.4/dist/semantic.min.css">';

// Include Tailwind CSS
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4">';
```

---

## 🧪 Testing

### Test the Landing Page

1. **Visit:** `http://localhost/mindtrack/`
2. **Expected:** Should redirect to landing page with:
   - ✅ Proper styling (Tailwind CSS)
   - ✅ Font Awesome icons visible
   - ✅ Fomantic UI buttons working
   - ✅ No console errors

### Test Other Pages

All pages using `shared()` should now work:

- `app/auth/index.php` (Login page)
- `app/patients/index.php` (Patient dashboard)
- `app/doctors/index.php` (Doctor dashboard)
- Any other page that includes components

---

## 📋 What Was Fixed

| Issue                                       | Status |
| ------------------------------------------- | ------ |
| ✅ Path resolution in `includeFileHelper()` | Fixed  |
| ✅ Correct `root_path` in config            | Fixed  |
| ✅ Font Awesome icons loading               | Fixed  |
| ✅ Environment variable fallbacks           | Fixed  |
| ✅ Global config access in styles.php       | Fixed  |

---

## 🎯 Impact

**Before:**

- Landing page: Broken styles and missing icons
- Shared components: Not loading from `app/landing/`
- Error logs: "File not found" errors

**After:**

- ✅ All pages load properly
- ✅ Shared components work from any directory level
- ✅ Font Awesome icons display correctly
- ✅ Fallback defaults prevent crashes

---

## 💡 Key Learnings

1. **Always use `$config['root_path']`** instead of calculating paths with `dirname()`
2. **Set `root_path` to actual project root**, not web server document root
3. **Include all required CSS/JS libraries** in shared components
4. **Use fallback defaults** for environment variables to prevent crashes

---

---

## 🔧 Additional Fixes (Follow-up)

### 5. Missing Slash in `baseURL()`

**Problem:**

```
URL generated: http://localhost/mindtrackassets/js/middlewares.js
Expected:      http://localhost/mindtrack/assets/js/middlewares.js
```

The `baseURL()` function wasn't adding a trailing slash after the subfolder, causing URLs to concatenate incorrectly.

**Solution:**

```php
// BEFORE
$baseUrl = $protocol . '://' . $host . '/' . $config['sub_folder'];
return $baseUrl . ltrim($path, '/');  // mindtrack + assets = mindtrackassets ❌

// AFTER
$baseUrl = $protocol . '://' . $host . '/' . $config['sub_folder'] . '/';
return $baseUrl . ltrim($path, '/');  // mindtrack/ + assets = mindtrack/assets ✅
```

### 6. Tailwind CSS MIME Type Issue

**Problem:**

```
The resource from "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" was blocked
due to MIME type ("application/javascript") mismatch
```

Tailwind v4 browser version had MIME type issues.

**Solution:**
Changed to stable Tailwind v3 CDN:

```php
// BEFORE
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4">';

// AFTER
echo '<script src="https://cdn.tailwindcss.com"></script>';
```

---

## ✅ Verification Checklist

- [x] Landing page loads without errors
- [x] Font Awesome icons visible
- [x] Tailwind CSS styles applied
- [x] Fomantic UI components working
- [x] Shared components load from any directory
- [x] No linter errors
- [x] Error logging improved for debugging
- [x] Asset URLs generate correctly with proper slashes
- [x] No MIME type blocking issues

**Status: All Fixed! 🎉**
