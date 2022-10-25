Task 16. Create an authentication form

Authentication form must contain email and password fields. Password typing should be hidden. Enable the submit button only if all fields are filled in together with the correct email. Don't use AJAX to send requests to the back-end.
Authenticate user over the file below:
<?php
declare(strict_types=1);
 
return [
    'user1@test.com' => [
        'name' => 'John',
        'password' => 'your_hash_here1', // use password_hash() to generate password in your code
    ],
    'user2@test.com' => [
        'name' => 'Jane',
        'password' => 'your_hash_here2', // use password_hash() to generate password in your code
    ],
];
 
If the user authenticated successfully, greet him by message 'Welcome back, {user name}!'. If no,
show the message 'Login is incorrect.'.
You should implement this application in OOP. Implement MVC pattern for this application. For the View part you must use the Twig Template Engine, loaded through Composer. Use separate CSS files for styles.
Tags:  PHP, OOP, MVC, Bootstrap, Twig, Composer, HTML, CSS, JS, GIT

This application was developed using PHP 8.1, used to start nginx
Install composer file
