<script>
    function sendToConsole(text) {
        console.log(text);
    }
</script>

<?php
include("config.php");

function sendToConsole($text)
{
    echo '<script type="text/javascript">', 'sendToConsole("', $text, '");', '</script>';
}

function createDB($servername, $username, $password, $dbname)
{
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Create database
    $sql = "CREATE DATABASE " . $dbname;
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Database created successfully");
    } else {
        sendToConsole("Error creating database: " . $conn->error);
    }
}

function createTables($servername, $username, $password, $dbname)
{
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // sql to create table
    $sql = "CREATE TABLE `User` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` TEXT(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
        `last_name` TEXT(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
        `email` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `password` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `company_id` INT zerofill DEFAULT NULL,
        `permission_level` INT(2) NOT NULL DEFAULT '0',
        `ticket_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
        `project_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
        PRIMARY KEY (`id`)
    );";
    
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table User created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }
    
    $sql = "CREATE TABLE `Company` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `admin` INT NOT NULL,
        `employees_id` BLOB NOT NULL,
        `project_id` BLOB,
        `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    );";
    
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table Company created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }
    
    $sql = "CREATE TABLE `Project` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` TEXT NOT NULL,
        `description` TEXT NOT NULL,
        `ticket_id` BLOB,
        `company_id` BLOB NOT NULL,
        `created_by` INT NOT NULL,
        `status` BLOB NOT NULL,
        `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `finished_on` DATETIME,
        `deadline` DATETIME,
        PRIMARY KEY (`id`)
    );";
    
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table Project created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }
 
    $sql = "CREATE TABLE `Ticket` (
        `id` INT NOT NULL AUTO_INCREMENT,
        `name` TEXT NOT NULL,
        `description` TEXT,
        `img` BLOB,
        `created_on` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `conpleated_on` DATETIME,
        `deadline` DATETIME,
        `completed_by` TEXT,
        `created_by` TEXT NOT NULL,
        `assigned_to` BLOB,
        `status` TEXT NOT NULL,
        `importance` INT(1) NOT NULL,
        `project_id` INT NOT NULL,
        `estimated_time_needed` TIME,
        PRIMARY KEY (`id`)
    );";

    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table Ticket created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }

    $conn->close();
}
?>