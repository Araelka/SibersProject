## Web-based database interface for user management
### Application Description
--- 
This application is a web interface for the administration of records in the database of registered
users of the site.
<br>
The database structure is a table with data about registered users. 
A set of fields in the user table:
- ID (primary key);
- Login (unique field);
- Password;
- Role id (foreign key);
- First name;
- Second name;
- Gender;
- Date of birth.
<br>
The web interface allows you to implement the following functions:
- view the list of registered users (with page-by-page breakdown and sorting);
- view information about the selected user;
- adding a new user record;
- editing a user record;
- deleting a user record.
<br>
The interface is accessible to a user with administrator rights only after authentication.
<br>
### Installation
--- 
System requirements
<br>
During the development, the following were used:
- PHP version 8.3
- PDO extension for php
- mysql version 8.0
<br>
Step 1. Configuring the database configuration
Open up config/database.php and configure the connection settings:
const DB_HOST = '127.0.0.1'; // Database host
const DB_PORT = '3306'; // Port
const DB_NAME = 'sibers'; // Database name
const DB_USER = 'root'; // User
const DB_PASSWORD = '123456'; // Password
const DB_CHARSET = 'utf8mb4'; // Encoding
<br>
Step 2. Creating the database structure
Perform migration to create tables:
php database/migrate.php
<br>
Step 3. Filling in the initial data
Launch the sids to create roles and the first user:
php database/seeds/seed.php
<br>
An administrator user will be created.:
Login: admin. 
Password: admin
<br>
Step 4: Launch the Web Server
Start the built-in PHP server from the root directory of the project:
php -S localhost:3000 -t public/
<br>
I also attach to the project an SQL database dump containing the database structure and several records.
