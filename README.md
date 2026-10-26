# Drainage System Revitalization Portal 🌊

A full-stack civic complaint-management portal for reporting drainage and sanitation issues, then moving each report through an authority-side review workflow.

## Why this project

Blocked drains and water overflow need a clear path from citizen report to action. This project models that workflow in a web application: a user submits an issue, the report is stored in MySQL, and an authority-facing workflow can review and track it.

## Features

- Submit drainage, overflow, and sanitation complaints
- Capture issue and location-related details
- Store and retrieve complaint records through a database-backed flow
- Track complaint progress
- Authority-side review workflow
- Responsive web interface
- Alerts and notification-oriented user experience

## Tech stack

| Layer | Technology |
| --- | --- |
| Frontend | HTML, CSS, Tailwind CSS, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Local development | XAMPP |

## Local setup

1. Install and start **XAMPP** (Apache and MySQL).
2. Clone this repository into the XAMPP `htdocs` directory.
3. Import the included SQL database file into MySQL/phpMyAdmin, if provided in the project.
4. Update database credentials in the PHP configuration file if your local MySQL settings differ.
5. Open the application through `http://localhost/<project-folder>`.

## Engineering concepts demonstrated

- CRUD-style complaint management
- Form validation and server-side handling
- Relational database integration
- User and authority workflow separation
- Responsive frontend development

## Roadmap

- Add image attachments and GPS location capture
- Build a dedicated analytics dashboard for authorities
- Add email/SMS status notifications
- Prioritize urgent reports with data-driven rules

## Team

Built by **Jahnavi Gajjala, Nanditha, Sravani, Charmi, and Harshitha**.