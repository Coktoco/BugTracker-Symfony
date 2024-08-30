# Bug Tracker Application

## Overview

The **Bug Tracker** application is a web-based tool designed to help teams manage and track bugs and errors efficiently. It provides a simple, minimalistic interface focused on usability and user experience.

**Important**: Application is available in polish.

## Features

- **Admin Management**: Administrators can add, edit, and delete bug reports, each containing the bug's name and a description.
- **Categorization**: Bugs can be organized into categories, which can also be managed by administrators.
- **Status Tracking**: Bugs can be assigned statuses to reflect their current progress:
  - `Fixed` (Naprawione)
  - `Work in Progress (WIP)` (W trakcie naprawy)
  - `In Queue` (Informacja o błędzie dotarła do zespołu, czeka na naprawę)
  - `Not Fixed` (Nie naprawione)
- **User Access**: Non-administrative users can view bug reports in a read-only mode.
- **Pagination and Filtering**: Bug reports are displayed with pagination (10 per page) and can be filtered by category or status.

## Installation

To install the Bug Tracker application, follow these steps:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Coktoco/BugTracker-Symfony.git
   cd bug-tracker
   
2. **Install dependencies**:
   ```bash
   composer install
   npm install
   npm run build
   
3. **Configure environment**:
   - copy .env.example to .env
   ```bash
   cp .env.example .env

4. **Run database migrations**:
   ```bash
   php bin/console doctrine:migrations:migrate

The application will be accessible at http://127.0.0.1:8000.

## Usage

### Admin Panel

- **Create Bug**: Admins can navigate to the “Create Bug” page to add new bugs with a name, description, category, and status.
- **Edit Bug**: Admins can edit existing bugs by navigating to the “Edit Bug” page.
- **Delete Bug**: Admins can delete bugs through the “Delete Bug” page.
- **Manage Categories**: Admins can create, edit, or delete categories used for organizing bug reports.

### User Access

- **View Bugs**: Users can view all bugs, filter by category or status, and browse through paginated results.

## Technologies Used

- **Symfony**: PHP framework for building web applications.
- **Twig**: Templating engine for rendering views.
- **Doctrine ORM**: Object-Relational Mapper for database management.
- **Bootstrap**: CSS framework for responsive and simple front-end design.

## Contributing

Contributions are welcome! If you have suggestions or new features in mind, please open an issue or submit a pull request. For major changes, it’s recommended to start a discussion first to ensure alignment.

## License

This project is licensed under the MIT License.

## Contact

For any questions or more information, feel free to contact me via email or LinkedIn.

## Screenshots

Below are some screenshots of the working project:

### Homepage - normal user:
<img width="1512" alt="Zrzut ekranu 2024-08-30 o 11 50 33" src="https://github.com/user-attachments/assets/3f438ed3-24da-47b6-80a0-bd550bec8f8c">

### Homepage - admin:
<img width="1512" alt="Zrzut ekranu 2024-08-30 o 11 54 05" src="https://github.com/user-attachments/assets/fcd980d2-f63c-4854-a483-22ea4ffe3e01">

### Adding new bug info: 
<img width="1512" alt="Zrzut ekranu 2024-08-30 o 11 55 27" src="https://github.com/user-attachments/assets/43f46ae4-d89b-40b5-937a-d78c5c8e9c05">

### Updating the Bug info:
<img width="1512" alt="Zrzut ekranu 2024-08-30 o 11 56 00" src="https://github.com/user-attachments/assets/5a725072-d58c-4ea0-987d-39f484774074">








   
