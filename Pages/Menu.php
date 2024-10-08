<?php
session_start();

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
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
      flex-direction: row;
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
      background-color: #48AF90;
      color: white;
      padding: 10px 20px;
      margin: 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
    }

    .filter-btn:hover {
      background-color: #5adbb5;
    }

    .menu-container {
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .meal-type-group {
      display: flex;
      flex-wrap: wrap;
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
      height: 100%;
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

    .description {
      padding: 15px;
    }

    .menu-card p .price {
      color: red;
    }

    .cart-link {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 3px;
    }

    .cart-link i {}

    .cart-link .cart-count {
      background-color: red;
      color: white;
      padding: 2px 8px;
      border-radius: 50%;
      font-size: 0.8em;
      margin-left: 5px;
    }

    .buttons {
      display: flex;
      gap: 3px;
    }

    .order-btn {
      background-color: #5dbea3;
      color: white;
      padding: 10px;
      margin: 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    .Add-btn {
      background-color: #5783db;
      color: white;
      padding: 10px;
      margin: 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      display: flex;
      gap: 3px;
    }

    .menu-card {
      position: relative;
      overflow: hidden;
      height: 400px;
      /* Existing styles */
    }

    .details-overlay {
      position: absolute;
      bottom: -100%;
      left: 0;
      right: 0;
      background: rgba(255, 255, 255, 0.9);
      padding: 15px;
      text-align: left;
      transition: bottom 0.3s ease;
    }

    .menu-card:hover .details-overlay {
      bottom: 0;
    }

    /* Overlay for background blur */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(5px);
      justify-content: center;
      align-items: center;
    }

    /* Modal Content */
    .modal-content {
      background-color: white;
      margin: auto;
      padding: 20px;
      border: 1px solid #888;
      width: 300px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.5);
    }

    /* Buttons in Modal */
    .modal-buttons {
      display: flex;
      justify-content: space-evenly;
      margin-top: 20px;
    }

    .process-btn,
    .cancel-btn {
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      color: white;
    }

    .process-btn {
      background-color: #28a745;
    }

    .cancel-btn {
      background-color: #dc3545;
    }

    .process-btn:hover {
      background-color: #218838;
    }

    .cancel-btn:hover {
      background-color: #c82333;
    }
  </style>
</head>

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

      <div class="cart-link">
        <a href="cart.php" class="filter-btn">
          <i class="fas fa-shopping-cart"></i> View Cart
          <?php if (isset($_SESSION['cart'])): ?>
            <span class="cart-count"><?php echo count($_SESSION['cart']); ?></span>
          <?php endif; ?>
        </a>
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
                <div class="details-overlay">
                  <h3><?php echo $item['item_name']; ?></h3>
                  <p><?php echo $item['item_description']; ?></p>
                  <p>Rs.<?php echo $item['item_price']; ?></p>
                  <p><?php echo $item['item_cultures']; ?></p>
                  <div class="buttons">
                    <button class="order-btn" onclick="buyItem(<?php echo $item['id']; ?>)">Order Now</button>
                    <button class="Add-btn" onclick="addToCart(<?php echo $item['id']; ?>)"><i
                        class="fas fa-shopping-cart"></i>Add to Cart</button>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Order Modal -->
    <div id="orderModal" class="modal">
      <div class="modal-content">
        <h2>Order Item</h2>
        <p>How many items would you like to order?</p>
        <form id="orderForm" action="../Backend/process_buy.php" method="GET">
          <input type="hidden" name="id" id="itemIdInput">
          <label for="quantity">Quantity:</label>
          <input type="number" id="quantity" name="count" value="1" min="1" required>
          <div class="modal-buttons">
            <button type="submit" class="process-btn">Process to Pay</button>
            <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
          </div>
        </form>
      </div>
    </div>


  </div>
  <div id="footer"></div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const searchInput = document.getElementById("searchInput");
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
        if (card.dataset[type].toLowerCase() === value.toLowerCase()) {
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

    function buyItem(id) {
      <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = 'login.html';
      <?php else: ?>
        // Continue with ordering process
        const userCount = prompt("How many users are going to order?");
        if (userCount !== null) {
          window.location.href = '../Backend/process_buy.php?id=' + id + '&count=' + userCount;
        }
      <?php endif; ?>
    }


    function addToCart(id) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "../Backend/add_to_cart.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          alert(xhr.responseText);
          updateCartCount();
        }
      };
      xhr.send("id=" + id);
    }

    function updateCartCount() {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "../Backend/cart_count.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const cartCount = document.querySelector(".cart-count");
          cartCount.textContent = xhr.responseText;
        }
      };
      xhr.send();
    }

    function buyItem(id) {
      <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = 'login.html';
      <?php else: ?>
        // Display the modal with item ID pre-filled
        document.getElementById('itemIdInput').value = id;
        document.getElementById('orderModal').style.display = 'flex';
      <?php endif; ?>
    }

    function closeModal() {
      document.getElementById('orderModal').style.display = 'none';
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function (event) {
      const modal = document.getElementById('orderModal');
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    };

  </script>
  <script src="../JS/components.js"></script>
</body>

</html>