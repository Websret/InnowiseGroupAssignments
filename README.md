Task 17. Create a user registration application

Create HTML form with 'First Name', 'Last Name', 'Email', 'Confirm Email', 'Password', 'Confirm Password' fields. Perform client-side validation that Email is valid email. Password should contain at least one small character, at least one capital character, at least one digit, at least one special character and be not less than 6 characters long. 'Confirm Email' and 'Confirm Password' fields should correspond to their parent fields. If a user submits non-valid data, the form should be reloaded, but non-valid fields together with 'Password' and 'Confirm Password' should be cleared.
Create a 'users' table to save new user. Use MySQL database. The table should have following fields:
id - unsigned int, primary index, auto increment;
email - varchar, unique, non-empty;
first_name - varchar, non-empty;
last_name - varchar, non-empty;
password - char. The size is based on hash algorithm that you choose;
created_date - timestamp, current_timestamp;
Use PDO with transactions to interact with the database. If an error occurred when adding a user account to the database, display a message about it to the user interface.
You should implement this application in OOP. Implement MVC pattern for this application. For the View part you must use the Twig Template Engine, loaded through Composer. Use separate CSS files for styles.
Tags:  PHP, OOP, MVC, Bootstrap, Twig, Composer, HTML, CSS, JS, GIT

This application was developed using PHP 8.1, used to start nginx
Create file .env and fill in the keys
Install composer file
