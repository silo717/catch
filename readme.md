## Contact

I'am Susilo Giono. E-mail : idsusilo[at]gmail[dot]com

## About this project

This application is using laravel console. You need to run a command to execute the program. I will explain more in the program guide section. The process will start from the Orders.php under app/Console/Commands/Orders.php. Simply I just get the url of jsonl lines, then convert it into correct json format. I store the summary logic in SummaryController.php under Controller folders. For the exporting tools I use Maatwebsite package. Before I exporting to csv, I save the summary data to database first, so You need to configure database (in this case I use MySQL). Finnaly, the CSV files will stoted in storage/app folder after You execute a command:order

# Program Guide

1. composer update (for mac: composer.phar update)
2. copy .env.example to .env (run in terminal : cp .env.example .env)
3. Configure the database. In this case I use MySQL
4. php artisan key:generate
5. php artisan migrate

-----Running a Program-----

6. php artisan command:order

-   point number 4 untll 6 is using terminal command
