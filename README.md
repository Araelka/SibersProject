## Web-based database interface for user management
### Application Description
--- 
This application is a web interface for the administration of records in the database of registered
users of the site.

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

The web interface allows you to implement the following functions:
- view the list of registered users (with page-by-page breakdown and sorting);
- view information about the selected user;
- adding a new user record;
- editing a user record;
- deleting a user record.

The interface is accessible to a user with administrator rights only after authentication.

### Installation
--- 
System requirements
<br>
During the development, the following were used:
- PHP version 8.3
- PDO extension for php
- mysql version 8.0

Step 1. Configuring the database configuration <br>
Open up config/database.php and configure the connection settings: <br>
const DB_HOST = '127.0.0.1'; // Database host <br>
const DB_PORT = '3306'; // Port <br>
const DB_NAME = 'sibers'; // Database name <br>
const DB_USER = 'root'; // User <br>
const DB_PASSWORD = '123456'; // Password <br>
const DB_CHARSET = 'utf8mb4'; // Encoding <br>

Step 2. Creating the database structure
Perform migration to create tables:
php database/migrate.php

Step 3. Filling in the initial data
Launch the sids to create roles and the first user:
php database/seeds/seed.php

An administrator user will be created:
Login: admin. 
Password: admin

Step 4: Launch the Web Server
Start the built-in PHP server from the root directory of the project:
php -S localhost:3000 -t public/

I also attach to the project an SQL database dump containing the database structure and several records.

### Description of methods and classes
--- 
The database <br>
The DBConfig class. <br>
Contains information about the database configuration.  <br>

DB class. <br>
Managing the database connection. Allows you to provide only one connection to the database. <br>

The Migration class. <br>
Allows you to manage the database schema, create and delete tables. <br>

Authentication <br>
The Auth class. <br>
Provides user authentication and session management. <br>
Methods: <br>
- login($login, $password) - authenticates user credentials <br>
- logout() - ends the user's session <br>
- user() - returns the data of the current user <br>
- check() - checks the authentication status <br>

The AuthController class. <br>
Endpoints: <br>
Methods: <br>
- showLoginForm() - displays the login page <br>
- login() - processes the submission of the login form <br>
- logout() - processes the user's logout <br>

User Management System <br>
The User model <br>
Provides access to data for user transactions <br>
Getting data: <br>
- findByLogin($login) - find the user by login <br>
- findById($id) - find the user by ID <br>
- findAll() - get all users <br>
- getAllUsersWithRoles() - get users with information about roles (with sorting/pagination) <br>

Data manipulation: <br>
- create($data) - create a new user <br>
- update($id, $data) - update an existing user <br>
- delete($id) - delete the user <br>

Auxiliary methods: <br>
- getTotalUsersCount() - count the total number of users <br>
- getALlRoles() - get available roles <br>
- isAdmin($id) - check if the user has administrator rights <br>
- existByLogin($login, $id) - check the uniqueness of the login <br>

The UserController class.  <br>
Read operations:  <br>
- index() - displays a list of users with pagination/sorting <br>
- showCreateForm() - shows the user creation form <br>
- showEditForm($id) - shows the user's edit form <br>

Recording operations:  <br>
- create() - processes user creation <br>
- edit($id) - handles user updates <br>
- destroy() - handles user deletion <br>
