<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
  header("Location: login.html");
  exit();
}

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

// Fetch menu data with join
$menu_sql = "SELECT menu.id, menu.item_name, menu.item_description, menu.item_price, food_culture.culture_name AS item_cultures, meal_type.meal_type AS item_type, menu.item_image, menu.created_at 
             FROM menu 
             JOIN food_culture ON menu.item_cultures = food_culture.id
             JOIN meal_type ON menu.item_type = meal_type.id";
$menu_result = $conn->query($menu_sql);

// Fetch food culture data
$culture_sql = "SELECT id, culture_name, created_at FROM food_culture";
$culture_result = $conn->query($culture_sql);

// Fetch meal type data
$meal_type_sql = "SELECT id, meal_type, created_at FROM meal_type";
$meal_type_result = $conn->query($meal_type_sql);

$menu_items = [];
$food_cultures = [];
$meal_types = [];

if ($menu_result->num_rows > 0) {
  while ($row = $menu_result->fetch_assoc()) {
    $menu_items[] = $row;
  }
}

if ($culture_result->num_rows > 0) {
  while ($row = $culture_result->fetch_assoc()) {
    $food_cultures[] = $row;
  }
}

if ($meal_type_result->num_rows > 0) {
  while ($row = $meal_type_result->fetch_assoc()) {
    $meal_types[] = $row;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Menu</title>

</head>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }

  .container {
    max-width: 1200px;
    width: 100%;
    padding: 20px;
  }

  h1 {
    text-align: center;
    margin-bottom: 20px;
  }

  .search-bar {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }

  .search-bar input {
    width: 50%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .filter-buttons {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .filter-buttons h3 {
    margin-bottom: 10px;
  }

  .filter-cultures,
  .filter-meal-types {
    display: flex;
    flex-direction: row;
    align-items: center;
  }

  .filter-btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px 10px 20px;
    margin: 5px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .filter-btn:hover {
    background-color: #0056b3;
  }

  .menu-container {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .meal-type-group {
    display: flex;
    margin-bottom: 20px;
  }

  .meal-type-group h2 {
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 4px;
  }

  .menu-card {
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 250px;
    margin: 15px;
    text-align: left;
    transition: transform 0.3s ease;
  }

  .menu-card:hover {
    transform: scale(1.05);
    cursor: pointer;
  }

  .menu-card img {
    width: 100%;
    height: 150px;
    border-radius: 8px 8px 0 0;
    object-fit: cover;
  }

  .menu-card h3 {
    margin: 10px 0;
    font-size: 1.2em;
  }

  .menu-card p {
    margin: 5px 0;
    color: #555;
  }

  .discription {
    padding: 15px;
  }

  .menu-card p .pricec {
    color: red;
  }
</style>

<body>
  <div id="header"></div>
  <div class="container">
    <h1>Our Menu</h1>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search for food items...">
    </div>
    <div class="filter-buttons">
      <div class="filter-cultures">
        <h3>Food Cultures</h3>
        <button class="filter-btn" onclick="showAllItems()">All</button>
        <!-- Food Culture Buttons -->
        <?php foreach ($food_cultures as $culture): ?>
          <button class="filter-btn" onclick="filterItems('culture', '<?php echo $culture['culture_name']; ?>')">
            <?php echo $culture['culture_name']; ?>
          </button>
        <?php endforeach; ?>
      </div>
      <div class="filter-meal-types">
        <h3>Meal Types</h3>
        <button class="filter-btn" onclick="showAllItems()">All</button>
        <!-- Meal Type Buttons -->
        <?php foreach ($meal_types as $meal_type): ?>
          <button class="filter-btn" onclick="filterItems('meal_type', '<?php echo $meal_type['meal_type']; ?>')">
            <?php echo $meal_type['meal_type']; ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>
    <div id="menuContainer" class="menu-container">
      <!-- Menu items grouped by meal type -->
      <?php foreach ($meal_types as $meal_type): ?>
        <h2><?php echo $meal_type['meal_type']; ?></h2>
        <div class="meal-type-group" data-meal-type="<?php echo $meal_type['meal_type']; ?>">
          <?php foreach ($menu_items as $item): ?>
            <?php if ($item['item_type'] === $meal_type['meal_type']): ?>
              <div class="menu-card" data-culture="<?php echo $item['item_cultures']; ?>"
                data-meal-type="<?php echo $item['item_type']; ?>">
                <img src="<?php echo $item['item_image']; ?>" alt="<?php echo $item['item_name']; ?>">
                <div class="discription">
                  <h3><?php echo $item['item_name']; ?></h3>
                  <p><?php echo $item['item_description']; ?></p>
                  <p>Rs.<?php echo $item['item_price']; ?></p>
                  <p><?php echo $item['item_cultures']; ?></p>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div id="footer"></div>
  <script>document.addEventListener("DOMContentLoaded", function () {
      const searchInput = document.getElementById("searchInput");
      const menuContainer = document.getElementById("menuContainer");
      const menuCards = document.querySelectorAll(".menu-card");

      searchInput.addEventListener("keyup", function () {
        const searchValue = searchInput.value.toLowerCase();
        menuCards.forEach(card => {
          const itemName = card.querySelector("h3").textContent.toLowerCase();
          if (itemName.includes(searchValue)) {
            card.style.display = "";
          } else {
            card.style.display = "none";
          }
        });
      });
    });

    function filterItems(type, value) {
      const menuCards = document.querySelectorAll(".menu-card");
      menuCards.forEach(card => {
        if (card.dataset[type] === value) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
      });
    }

    function showAllItems() {
      const menuCards = document.querySelectorAll(".menu-card");
      menuCards.forEach(card => {
        card.style.display = "";
      });
    }
  </script>
  <script src="../JS/components.js"></script>
</body>

</html>