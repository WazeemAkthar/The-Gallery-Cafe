<?php
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

//Fetch data
$sql = "SELECT id, item_name, item_description, item_price, item_cultures, item_type, item_image, created_at FROM menu";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../CSS/menu.css" />
  <title>Menu - The Gallery Café</title>
</head>

<body>
  <div id="header"></div>
  <!-- Placeholder for header -->

  <div class="menu-container">
    <div class="menu-search">
      <input type="text" id="searchBar" placeholder="Search by cuisine type..." />
    </div>

    <div class="menu-grid" id="menuGrid">

    </div>

    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='menu-grid' id='menuGrid'>";
        echo "<div class='menu-item'>";
        echo "<img src='" . $row["item_image"] . "' alt='Item Image'>";
        echo "<h3>" . $row["item_name"] . "</h3>";
        echo "<p>" . $row["item_description"] . "</p>";
        echo "<p class='price'>" . $row["item_price"] . "</p>";
        echo "</div>";
        echo "</div>";
      }
    } else {
      echo "<div>No items found</div>";
    }
    $conn->close();
    ?>

  </div>
  <div id="footer"></div>
  <!-- Placeholder for footer -->

  <script src="../JS/components.js"></script>
  <!-- <script>
    Sample menu items data
    const menuItems = [
      {
        id: 1,
        name: "Sri Lankan Curry",
        description: "A delicious blend of spices and herbs.",
        price: "$10",
        image: "../menu Images/Sri_Lankan_Rice_and_Curry.jpg",
      },
      {
        id: 2,
        name: "Chinese Noodles",
        description: "Stir-fried noodles with vegetables and meat.",
        price: "$12",
        image: "../menu Images/Chinese Noodles.avif",
      },
      {
        id: 3,
        name: "Italian Pizza",
        description: "Classic margherita pizza with fresh ingredients.",
        price: "$15",
        image: "../menu Images/Italian Pizza.webp",
      },
      // { id: 4, name: 'Sri Lankan Curry', description: 'A delicious blend of spices and herbs.', price: '$10', image: '../menu Images/Sri_Lankan_Rice_and_Curry.jpg' },
      // { id: 5, name: 'Chinese Noodles', description: 'Stir-fried noodles with vegetables and meat.', price: '$12', image: '../menu Images/Chinese Noodles.avif' },
      // { id: 6, name: 'Italian Pizza', description: 'Classic margherita pizza with fresh ingredients.', price: '$15', image: '../menu Images/Italian Pizza.webp' },
      // Add more menu items as needed
    ];

    // Function to display menu items
    function displayMenuItems(items) {
      const menuGrid = document.getElementById("menuGrid");
      menuGrid.innerHTML = ""; // Clear the grid
      items.forEach((item) => {
        const menuItem = document.createElement("div");
        menuItem.className = "menu-item";
        menuItem.innerHTML = `
                  <img src="${item.image}" alt="${item.name}">
                  <h3>${item.name}</h3>
                  <p>${item.description}</p>
                  <p class="price">${item.price}</p>
              `;
        menuGrid.appendChild(menuItem);
      });
    }

    // Initial display of all menu items
    displayMenuItems(menuItems);

    // Search functionality
    document
      .getElementById("searchBar")
      .addEventListener("input", function (event) {
        const searchText = event.target.value.toLowerCase();
        const filteredItems = menuItems.filter((item) =>
          item.name.toLowerCase().includes(searchText)
        );
        displayMenuItems(filteredItems);
      });
  </script> -->
</body>

</html>