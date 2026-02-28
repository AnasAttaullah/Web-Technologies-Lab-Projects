# Student Management System - CRUD Application

A modern and clean PHP-based CRUD (Create, Read, Update, Delete) web application for managing student records with MySQL database.

## Features

✨ **Full CRUD Operations**
- ➕ Add new students
- 📋 View all students in a beautiful table
- ✏️ Edit existing student information
- 🗑️ Delete students with confirmation

🎨 **Modern Design**
- Clean and responsive UI
- Gradient color scheme
- Font Awesome icons
- Smooth animations and transitions
- Mobile-friendly design

## Database Schema

The application uses a `students` table with the following fields:
- **id** - Auto-increment primary key
- **name** - Student's full name
- **email** - Email address (unique)
- **phone** - Phone number
- **address** - Physical address
- **course** - Course/Program enrolled
- **created_at** - Timestamp of creation
- **updated_at** - Timestamp of last update

## Installation & Setup

### Prerequisites
- Laragon (or XAMPP/WAMP/MAMP)
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Steps

1. **Import Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Click on "New" to create a database or use SQL tab
   - Import the `database.sql` file or run the SQL queries from it
   - This will create the `student_crud` database and `students` table with sample data

2. **Configure Database Connection**
   - Open `config.php`
   - Update the database credentials if needed (default settings work with Laragon):
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'student_crud');
     ```

3. **Access the Application**
   - Open your browser
   - Navigate to: `http://localhost/CRUD/`
   - Start managing student records!

## File Structure

```
CRUD/
├── config.php          # Database configuration
├── index.php           # Main page (Read - View all students)
├── create.php          # Add new student (Create)
├── update.php          # Edit student (Update)
├── delete.php          # Delete student (Delete)
├── style.css           # Modern CSS styling
├── database.sql        # Database schema and sample data
└── README.md           # This file
```

## Usage

### Viewing Students
- Access `index.php` to see all students in a table format
- Students are ordered by newest first

### Adding a Student
1. Click "Add New Student" button
2. Fill in the required fields (marked with *)
3. Click "Save Student"
4. You'll be redirected to the main page with a success message

### Editing a Student
1. Click the yellow edit icon (✏️) next to any student
2. Modify the information
3. Click "Update Student"
4. Changes will be saved and you'll see a confirmation

### Deleting a Student
1. Click the red delete icon (🗑️) next to any student
2. Confirm the deletion in the popup
3. Student will be removed from the database

## Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3
- **Icons**: Font Awesome 6.0
- **Design**: Custom CSS with gradients and animations

## Security Features

- Prepared statements to prevent SQL injection
- Input validation and sanitization
- HTML special characters encoding
- Email format validation

## Browser Compatibility

- ✅ Chrome
- ✅ Firefox
- ✅ Safari
- ✅ Edge
- ✅ Opera

## Responsive Design

The application is fully responsive and works on:
- 💻 Desktop
- 📱 Tablet
- 📱 Mobile devices

## License

Free to use for personal and educational purposes.

## Author

Created with ❤️ for learning and demonstration purposes.

---

