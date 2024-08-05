<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; // or your database username
$password = ""; // or your database password
$dbname = "thegallerycafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from menu table
$menu_sql = "SELECT * FROM menu";
$menu_result = $conn->query($menu_sql);
$menu_items = array();
if ($menu_result->num_rows > 0) {
    while($row = $menu_result->fetch_assoc()) {
        $menu_items[] = $row;
    }
}

// Fetch data from food_culture table
$culture_sql = "SELECT * FROM food_culture";
$culture_result = $conn->query($culture_sql);
$food_cultures = array();
if ($culture_result->num_rows > 0) {
    while($row = $culture_result->fetch_assoc()) {
        $food_cultures[] = $row;
    }
}

// Fetch data from meal_type table
$meal_type_sql = "SELECT * FROM meal_type";
$meal_type_result = $conn->query($meal_type_sql);
$meal_types = array();
if ($meal_type_result->num_rows > 0) {
    while($row = $meal_type_result->fetch_assoc()) {
        $meal_types[] = $row;
    }
}

$conn->close();

$response = array(
    "menu_items" => $menu_items,
    "food_cultures" => $food_cultures,
    "meal_types" => $meal_types
);

header('Content-Type: application/json');
echo json_encode($response);
?>
