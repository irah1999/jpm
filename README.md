# 💎 Jewellery Product Management - CodeIgniter 4

A clean, secure, and responsive web application built using **CodeIgniter 4**, **Bootstrap 5.3**, and **jQuery**.  
This app provides user authentication and CRUD operations for jewellery products, with image upload & resizing and DataTables server-side pagination.

---

## 🚀 Features

- User Login / Logout (Session-based authentication)
- Add / Edit / Delete Jewellery Products
- Product image upload with resizing (500x500)
- Category assignment
- Server-side pagination with DataTables
- Responsive UI using Bootstrap 5.3
- Clean code following MVC and best practices

---

## 🛠️ Tech Stack

- **Backend:** CodeIgniter 4
- **Frontend:** Bootstrap 5.3 + jQuery (latest)
- **Image Resize:** CodeIgniter Image Manipulation
- **Database:** MySQL
- **Datatables:** Server-side processing

---
### 1. **Clone the repo**

```bash
git clone https://github.com/irah1999/jpm.git
cd jpm
```

### 2.Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp env.example .env
```

### 4. Update .env file with your database details:

```env
mysql

database.default.hostname = localhost
database.default.database = jewellery
database.default.username = root
database.default.password = yourpassword

encryption.key = 'your encryption key'

```

### 5. Create the writable folder

```
project-root/
├── app/
├── public/
├── writable/
│   ├── cache/        ← required for framework caching
│   ├── debugbar/     ← for CI4 Debug Toolbar (if enabled)
│   ├── logs/         ← to store logs
│   ├── session/      ← to store session files (when using file-based session driver)
│   └── uploads/ 
```

### 6. Run Migrations & Seed (optional)

```bash
php spark migrate
php spark seed
```

### 7. Start the server

```
php spark serve
```

### 8. Visit the application in your browser
```bash
http://localhost:8000
```


