# IT Helpdesk & Asset Management System

A portfolio project demonstrating an IT support/helpdesk workflow with ticket management, priority-based routing, asset inventory, MySQL reporting, and Excel-compatible CSV export.

## Features

- Create and track IT support tickets
- Ticket categories and priority levels
- Open → In Progress → Resolved → Closed workflow
- Resolution notes and ticket history
- Asset inventory with assignment status
- User/requester records
- Dashboard metrics
- MySQL relational database with foreign keys
- CSV export that opens directly in Microsoft Excel
- Responsive HTML/CSS interface

## Tech Stack

- HTML5
- CSS3
- PHP 8+
- MySQL 8+
- JavaScript
- Git/GitHub
- Microsoft Excel for exported operational reports

## Project Structure

```text
IT-Helpdesk-Asset-Management-System/
├── api.php
├── config.php
├── database.sql
├── index.php
├── script.js
├── style.css
├── .gitignore
└── README.md
```

## Run Locally with XAMPP

1. Install XAMPP and start Apache + MySQL.
2. Copy this folder into `C:/xampp/htdocs/`.
3. Open phpMyAdmin.
4. Create/import the database by importing `database.sql`.
5. Open `config.php` and update the MySQL username/password if required.
6. Visit:
   `http://localhost/IT-Helpdesk-Asset-Management-System/`

## GitHub Upload

Create an empty GitHub repository named `IT-Helpdesk-Asset-Management-System`, then run:

```bash
git init
git branch -M main
git add .
git commit -m "Initial commit - IT Helpdesk and Asset Management System"
git remote add origin https://github.com/YOUR-USERNAME/IT-Helpdesk-Asset-Management-System.git
git push -u origin main
```

## Resume Description

**IT Helpdesk & Asset Management System | PHP, MySQL, HTML, CSS, Excel**

- Built a centralized IT ticketing platform with priority-based routing and ticket lifecycle tracking.
- Designed a MySQL database for users, tickets, and assets with relational constraints.
- Implemented ticket resolution notes, asset assignment, operational dashboard metrics, and Excel-compatible CSV reporting.
- Documented support workflows to improve consistency in issue handling and end-user self-service.

## Interview Explanation

"I built an IT Helpdesk and Asset Management System to simulate a real L1/L2 support environment. Users can create incidents, support staff can prioritize and update tickets through their lifecycle, and IT assets can be assigned to employees. MySQL stores the relational data, while the dashboard provides basic operational metrics. I also added CSV export so ticket data can be opened in Excel for reporting."


