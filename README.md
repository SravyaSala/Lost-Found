# 📦 Lost & Found – Campus Item Management System

Lost & Found is a web-based application that enables users to report lost or found items and helps reconnect them with their rightful owners. The system provides user authentication, item posting, item searching, and a personalized dashboard for managing reports.

---

## ✨ Key Features

- **🧭 Intro Page**
  - Landing page that guides users to report either a lost or found item.

- **🏠 User Dashboard**
  - Displays relevant information and provides quick access to application features.

- **📝 Item Posting**
  - Allows users to submit reports for lost or found items.

- **🔍 Item Search**
  - Enables users to search for matching lost or found items.

- **📁 My Posts**
  - Displays all reports created by the logged-in user.

---

## 🧰 Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Local Server:** XAMPP

---

## 📁 Project Structure

```text
Lost_and_Found/
├── introPage.html
├── login2.php
├── homePage.php
├── postPage.php
├── searchPage.php
├── myposts.php
└── README.md
```

---

## 🧪 Run Locally

### 1. Clone the Repository

```bash
git clone https://github.com/SravyaSala/Lost_and_Found.git
cd Lost_and_Found
```

> **Note:** Replace the repository URL above with your own repository URL if it is different.

### 2. Set Up the Project

- Install **XAMPP** (or any PHP server).
- Start **Apache** and **MySQL**.
- Copy the project folder into the `htdocs` directory.

### 3. Configure the Database

- Import the database if available.
- Otherwise, create a MySQL database based on the fields used in the project forms.
- Update the database connection details in the PHP files.

### 4. Run the Application

Open your browser and visit:

```text
http://localhost/your-project-folder/introPage.html
```

---

## 📌 Notes

- Ensure the database connection is configured correctly before running the application.
- Use PHP sessions for user authentication and login persistence.
- Input validation and sanitization are recommended before deploying the application.

---

