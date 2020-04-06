<script>
    function sendToConsole(text) {
        console.log(text);
    }
</script>

<?php
include("sql_data/sql_login.php");

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
        `ID` INT NOT NULL AUTO_INCREMENT,
        `Name` TEXT(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
        `Last_name` TEXT(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
        `Email` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `Password` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `Company_ID` INT zerofill DEFAULT NULL,
        `Permission_level` INT(2) NOT NULL DEFAULT '0',
        `Ticket_ID` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
        `Project_ID` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
        PRIMARY KEY (`ID`)
    );";
    
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table User created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }
    
    $sql = "CREATE TABLE `Company` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `Name` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `Admin` INT NOT NULL,
        `Employees_ID` BLOB NOT NULL,
        `Project_ID` BLOB,
        `Created_on` DATE NOT NULL,
        PRIMARY KEY (`ID`)
    );";
    
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table Company created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }
    
    $sql = "CREATE TABLE `Project` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `Name` TEXT NOT NULL,
        `Description` TEXT NOT NULL,
        `Ticket_ID` BLOB,
        `Company_ID` BLOB NOT NULL,
        `Created_by` INT NOT NULL,
        `Status` BLOB NOT NULL,
        `Created_on` DATE,
        `Finished_on` DATE,
        `Deadline` DATE,
        PRIMARY KEY (`ID`)
    );";
    
    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table Project created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }
 
    $sql = "CREATE TABLE `Ticket` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `Name` TEXT NOT NULL,
        `Description` TEXT,
        `Img` BLOB,
        `Created_on` DATE NOT NULL,
        `Conpleated_on` DATE,
        `Deadline` DATE,
        `Conpleated_by` TEXT,
        `Created_by` TEXT NOT NULL,
        `Assigned_to` BLOB,
        `Status` TEXT NOT NULL,
        `Importance` INT(1) NOT NULL,
        `Project_ID` INT NOT NULL,
        `Estimated_time_needed` TIME,
        PRIMARY KEY (`ID`)
    );";

    if ($conn->query($sql) === TRUE) {
        sendToConsole("Table Ticket created successfully");
    } else {
        sendToConsole("Error creating table: " . $conn->error);
    }

    $conn->close();
}
?>