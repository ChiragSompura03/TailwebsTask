# Teacher Portal Setup Guide

This guide provides step-by-step instructions on how to set up and run the Teacher Portal application locally using XAMPP.

## Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) (Apache and MySQL)
- Web browser
- GitHub account to download the repository

## Steps to Run the Code Locally

### 1. Download XAMPP

Download and install XAMPP from the [official website](https://www.apachefriends.org/index.html).

### 2. Start the Apache Web Server and MySQL Database

- Open the XAMPP Control Panel.
- Start **Apache** and **MySQL** by clicking the **Start** buttons next to each.

### 3. Set Up the Project Files

1. Download the project repository from GitHub.
2. Extract the downloaded folder.
3. Copy the extracted folder into the `htdocs` directory of your XAMPP installation.
   - The path is typically `C:\xampp\htdocs` on Windows.

### 4. Set Up the Database

You can set up the database using one of the following methods:

#### Method 1: Import SQL File

1. Open [phpMyAdmin](http://localhost/phpmyadmin) in your browser.
2. Click on **Import**.
3. Select the provided SQL file (`teacher_portal.sql`) from the GitHub repository.
4. Click **Go** to import the database.

#### Method 2: Manual Setup

1. Open [phpMyAdmin](http://localhost/phpmyadmin) in your browser.
2. Create a new database named `teacher_portal`.
3. Run the following SQL queries to create the required tables:

```sql
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    marks INT NOT NULL,
    UNIQUE KEY unique_student_subject (name, subject)
);
```


### 5. Access the Application
1) Open your web browser.
2) Enter the following URL: http://localhost/[folder_name]/registerform.php

Note:-  If you have not changed the folder name, it will be http://localhost/TailwebsTask/registerform.php.

3) Register a new teacher account.
4) Log in with the registered credentials.
5)You can now add, edit, delete, and view student data inline.

