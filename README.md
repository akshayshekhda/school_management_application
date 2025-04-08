*** School Management System ***

## Installation

1. Clone the repository:

2. Install dependencies:

  Laravel version: 12.0 PHP version : 8.3

*** Need to follow this steps: ***

 Step 1: First need to install composer using this command : composer install

 Step 2: First need to Create .env file and paste data on this file .env.example make sure you have to check to .env of your db credentials

Step 3: Database Set Up: -> First create one Database: -> Database name should be school_management -> then after run migration , run this command to terminal: php artisan migrate:fresh --seed

Step 4: Start the queue worker:

  php artisan queue:work --queue=emails

Step 5: Start the development server:

  php artisan serve

------------------- PRACTICAL TASK DETAILS------------------------------

## Practical Task

### Task 1

Admin Login Credentials:

  email: admin@school.com
  password: password

   - Dashboard
   - Students
   - Teachers
   - Parents
   - Announcements
 
    On the admin side, the dashboard displays counts.
    The admin can insert, update, and delete teacher records — same for students, parents, and announcements.

    For announcements, the admin can send emails based on the selected value from a dropdown.
    The announcement will be created, and after that, the email will be sent in the background according to the selected dropdown option.

### Task 2

Teacher Login Credentials:

  email: teacher@school.com
  password: password

 - Dashboard
 - Students
 - Parents
 - Announcements

    On the teacher side, the dashboard displays counts.
    The teacher can insert, update, and delete student records.
    The teacher can insert, update, and delete parent records.
    The teacher can insert, update, and delete announcement records.
    For announcements, the teacher can send emails based on the selected value from a dropdown.
    The announcement will be created, and after that, the email will be sent in the background according to the selected dropdown option.

Note: 
    When I (admin) create an Announcement for students or parents, that record should not be visible to the teacher.
    And when a teacher creates an Announcement, it should be visible to the admin, and also sent to parents and students.

    Emails for Announcements should be sent based on the dropdown selection.
    For example, if only 'Student' is selected, then the email should be sent only to students.

I have shared the ID and password of the mail configuration that I set in the .env file. You can log in and check whether the emails have been received. I have used Mailtrap for this.

email:akshayshekhda@gmail.com
password:205kh)sIc9pz












php artisan queue:work --queue=emails

php artisan migrate:fresh --seed