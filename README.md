Task 21. Car Showroom Dashboard The dashboard should display the following information:
the average price on cars sold for all time - number
the average price on the cars sold today - number
cars sold last year, divided by day - table
Table format

Date

Number of cars sold

23.04.2022

5

22.04.2022

3

21.04.2022

8 unsold cars, sorted by descending year of manufacture (first priority), by ascending price (second priority) - one
table
Table format

Car model

Year of production

Color

Price

Civic

2021

Red

20000
list of car models currently on sale Important: Only 1 database query must be used to retrieve data for each of the
above items. Manipulations with PHP are not allowed. The structure of the database tables (must be created by yourself)
Vehicle Directory
id
model
year of production Showroom cars
id
vehicle id from the directory
color price
sign sold/not yet sold
date of sale All visual information should be placed on 1 page. Use Tailwind CSS for the visual design of the dashboard.
You should implement this application in OOP. Implement MVC pattern for this application. For the View part you must use
the Twig Template Engine, loaded through Composer. Use separate CSS files for styles.
Tags:PHP, OOP, MVC, MySQL, Tailwind CSS, Twig, Composer, HTML, CSS, JS, GIT

This application was developed using PHP 8.1, used to start nginx. Create file .env and fill in the keys. Install
composer
file and upload DataBase (file car_showroom.sql).