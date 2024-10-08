<?php
session_start();
if (!isset($_SESSION['role_id'])) {
  header("Location: login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./CSS/Home.css" />
  <link rel="stylesheet" href="./CSS/menu.css" />
  <title>The Gallery Café</title>
</head>

<body>
  <div id="header"></div>

  <section id="home" class="hero"></section>
  <div class="hero-content">
    <h1>Welcome to The Gallery Café <?php echo $_SESSION['name']; ?></h1>
    <h2>Discover Our Delicious Menu</h2>
    <p>
      Experience the best dining in Colombo with our diverse cuisine options.
    </p>
    <a href="../Pages/Menu.html" class="btn">Explore Our Menu</a>
  </div>

  <section id="specials">
    <h1>Special food and beverages</h1>
    <div class="menu-grid" id="menuGrid">
      <!-- Special food and beverages items will be inserted here dynamically -->
    </div>
  </section>

  <section id="specials">
    <h2>Special Offers</h2>
    <div class="special">
      <h3>Happy Hour</h3>
      <p>Enjoy 50% off on all drinks every weekday from 5 PM to 7 PM.</p>
    </div>
    <div class="special">
      <h3>Weekend Brunch Combo</h3>
      <p>Get a special brunch combo for two at just $30, available on Saturdays and Sundays.</p>
    </div>
    <div class="special">
      <h3>Seasonal Specials</h3>
      <p>Try our limited-time seasonal dishes and beverages made with the freshest ingredients.</p>
    </div>
    <div class="special">
      <h3>Loyalty Rewards</h3>
      <p>Join our loyalty program and earn points with every purchase to redeem exciting rewards.</p>
    </div>
  </section>

  <section id="events">
    <h1>special events</h1>
    <div class="event">
      <h3>Live Music Night</h3>
      <p>
        Enjoy live performances by local bands every Friday night. Join us for
        an evening of great music and delicious food.
      </p>
    </div>
    <div class="event">
      <h3>Wine Tasting Event</h3>
      <p>
        Sample a variety of exquisite wines from around the world. Our
        sommeliers will guide you through the tasting experience.
      </p>
    </div>
    <div class="event">
      <h3>Cooking Classes</h3>
      <p>
        Learn to cook our signature dishes with our expert chefs. Classes are
        held every Saturday morning.
      </p>
    </div>
    <div class="event">
      <h3>Holiday Specials</h3>
      <p>
        Celebrate the festive season with our special holiday menu. Available
        on Christmas and New Year's Eve.
      </p>
    </div>
  </section>

  <section id="info">
    <h2>Information</h2>
    <div class="info-section">
      <img src="./menu Images/table-capacity.jpg" alt="Table Capacity">
      <div class="info-content">
        <h3>Table Capacities</h3>
        <p>We offer a variety of table sizes to accommodate different group sizes. From intimate tables for two to large
          tables for parties, we have the perfect seating for you.</p>
      </div>
    </div>
    <div class="info-section">
      <img src="./menu Images/parking.jpg" alt="Parking Availability">
      <div class="info-content">
        <h3>Parking Availability</h3>
        <p>Ample parking is available for our guests. We offer both valet and self-parking options to ensure a
          convenient and hassle-free dining experience.</p>
      </div>
    </div>
    <div class="info-section">
      <img src="./menu Images/special-promotions.png" alt="Special Promotions">
      <div class="info-content">
        <h3>Special Promotions</h3>
        <p>Don't miss out on our exclusive promotions. From seasonal discounts to special combo offers, we have a range
          of promotions to enhance your dining experience.</p>
      </div>
    </div>
  </section>

  <div id="footer"></div>

  <script>
    //Home page 
    function loadComponent(componentPath, elementId, cssPath) {
      fetch(componentPath)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.text();
        })
        .then(data => {
          document.getElementById(elementId).innerHTML = data;
          if (cssPath) {
            loadCSS(cssPath);
          }
        })
        .catch(error => console.error('Error loading component:', error));
    }

    function loadCSS(cssPath) {
      let link = document.createElement('link');
      link.rel = 'stylesheet';
      link.href = cssPath;
      document.head.appendChild(link);
    }

    document.addEventListener('DOMContentLoaded', function () {
      loadComponent('./Components/header.html', 'header', './css/Home.css');
      loadComponent('./Components/footer.html', 'footer', './css/Home.css');
      // loadComponent('../Components/sidebar.html', 'sidebar', '../css/styles.css');
    });

  </script>
  <script>
    // Sample menu items data
    const menuItems = [
      {
        id: 1,
        name: "Sri Lankan Curry",
        description: "A delicious blend of spices and herbs.",
        price: "$10",
        image: "./menu Images/Sri_Lankan_Rice_and_Curry.jpg",
      },
      {
        id: 2,
        name: "Chinese Noodles",
        description: "Stir-fried noodles with vegetables and meat.",
        price: "$12",
        image: "./menu Images/Chinese Noodles.avif",
      },
      {
        id: 3,
        name: "Italian Pizza",
        description: "Classic margherita pizza with fresh ingredients.",
        price: "$15",
        image: "./menu Images/Italian Pizza.webp",
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
  </script>
</body>

</html>