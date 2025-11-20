# no-name-1

## Requirements

Make sure the following are installed:

- PHP ≥ 8.1  
- Composer  
- MySQL Server  
- Laravel CLI  
- Postman (for testing)

---

## Installation

### 1. Clone the repository
```
git clone git@github.com:mnhaqq/no-name-1.git
cd no-name-1
```

### 2. Install dependencies

```
composer install
```

### 3. Create your `.env` file

```
cp .env.example .env
```

### 4. Generate application key

```
php artisan key:generate
```

---

## Database Setup

### 1. Create a MySQL database

Login to MySQL:

```
mysql -u root -p
```

Create a database:

```
CREATE DATABASE laravel_api;
EXIT;
```

### 2. Update `.env` with DB credentials

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Run migrations

```
php artisan migrate
```


## OTP Configuration

Create a config file:

`config/auth_otp.php`

```
return [
    'enabled' => true
];
```

Clear config cache:

```
php artisan config:clear
```

---

## Start the Server

```
php artisan serve
```

Base API URL:

```
http://127.0.0.1:8000/api
```

---

# 📘 API Endpoints

---

## **1. Register User**

**POST** `/register`

### Request Body:

```
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123",
  "password_confirmation": "secret123"
}
```

### Response:

```
{
  "user": { ... },
  "token": "your_token_here"
}
```

---

## **2. Login**

**POST** `/login`

### Request Body:

```
{
  "email": "john@example.com",
  "password": "secret123"
}
```

### If OTP is required:

```
{
  "message": "OTP required",
  "user_id": 1
}
```

### If OTP is disabled:

```
{
  "message": "Login successful",
  "token": "your_token",
  "user": { ... }
}
```

---

## **3. Verify OTP**

**POST** `/verify-otp`

### Request Body:

```
{
  "user_id": 1,
  "otp": "123456"
}
```

### Response:

```
{
  "message": "OTP verified successfully",
  "token": "your_token",
  "user": { ... }
}
```

---

## **4. Logout**

**POST** `/api/logout`

### Headers:

```
Authorization: Bearer your_token
```

### Response:

```
{
  "message": "You are logged out"
}
```

---

# Testing Guide (Postman)

1. **Register a user** → `/register`
2. **Login** → `/login`

   * If OTP enabled → Get `user_id`
3. **Verify OTP** → `/verify-otp`
4. Use returned token for authenticated endpoints
5. **Logout** → `/logout`

---
