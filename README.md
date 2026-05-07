"""# SocialNet Project

A custom-built social network application utilizing a LEMP stack (Linux, Nginx, MySQL, PHP). This project includes core user authentication and profile management, along with several advanced features that extend beyond the base requirements.

---

## Advanced Features

In addition to standard user registration, login, and profile descriptions, this application includes:

1. **Profile Picture Uploads:** Users can upload custom images. The application securely handles file transfers, verifies image formats, and stores them in an isolated `uploads/` directory, linking the file path dynamically in the MySQL database.
2. **Friends System:** Implemented a many-to-many relationship using a dedicated `friends` junction table, allowing users to establish connections with other accounts on the network.
3. **Live Feed / Posts:** A fully functional `posts` table allows users to publish text messages that update dynamically on the network's feed, tagged with the author's username and a precise timestamp.

---

## Setup Instructions (For New Environments)

If you are deploying this code on a new Ubuntu server, follow these exact steps to recreate the environment.

### Prerequisites
* **LEMP Stack:** Ensure your server is running **Linux** (Ubuntu), **Nginx**, **MySQL**, and **PHP-FPM**.
* **Git:** To clone this repository.

### Step 1: Download the Application
Clone this repository into your Nginx web directory.

### Step 2: Configure the Database
The repository includes a `db.sql` schema file to instantly recreate the database structure.
1. Log into MySQL: `mysql -u root -p`
2. Run the schema file:

### Step 3: Configure Database Credentials (db.php)
1. Navigate to the main application directory:
cd socialnet/
2. You will see a template file named db.php. Change it with nano or vim:
sudo nano db.php
3. Look for these specific lines and change the placeholders to match your local MySQL server's actual username and password:
$username = "YOUR_DATABASE_USERNAME"; 
$password = "YOUR_DATABASE_PASSWORD";

### Step 4: Configure the Uploads Directory:
For the profile picture feature to work, the web server needs permission to save files.
1. The repository includes an empty socialnet/uploads/ directory (tracked via .gitkeep).
2. Grant Nginx ownership of this folder so PHP can write to it:
sudo chown -R www-data:www-data socialnet/uploads/

### Step 5: Nginx Configuration:
Ensure your Nginx server block is configured to execute PHP files via PHP-FPM. Because the application uses relative links, the directory structure (admin/ and socialnet/) must remain exactly as it is.
