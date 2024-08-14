<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../CSS/Home.css" />
  <!-- <link rel="stylesheet" href="../CSS/menu.css" /> -->
  <title>The Gallery Café</title>
</head>

<body>
  <div id="header"></div>

  <section id="home" class="hero"></section>
  <div class="hero-content">
    <h1>Welcome to The Gallery Café
      <?php
      if (isset($_SESSION['name'])) {
        echo $_SESSION['name'];
      } else {
        echo "Guest";
      }
      ?>
      <h2>Discover Our Delicious Menu</h2>
      <p>
        Experience the best dining in Colombo with our diverse cuisine options.
      </p>
      <a href="../Pages/Menu.php" class="btn">Explore Our Menu</a>
  </div>

  <section id="specials">
    <h1>Special food and beverages</h1>
    <div class="card-container">
      <div class="card">
        <img src="../menu Images/image_01.jpg" alt="Card Image" class="card-image">
        <div class="card-details">
          <h3>Processed Fruit, Vegetable and Juice</h3>
          <p>Sri Lanka is blessed with natural resources and climatic conditions from temperate, to tropical to sub
            tropical, suitable for the growing of a wide range of fruits and vegetables.</p>
        </div>
      </div>

      <div class="card">
        <img src="../menu Images/rice-and-cereal-based-products.jpg" alt="Card Image" class="card-image">
        <div class="card-details">
          <h3>Rice and Cereal Based Products</h3>
          <p>Rice and cereals are a preferred option to wheat-based products as they offer higher nutritional value for
            those consumers preferring high fiber foods. For centuries, Sri Lanka’s staple food has been rice, most
            consuming it three times a day. As a result it is said that ancient Sri Lankan kings had giants who “moved
            mountains” in their clans.</p>
        </div>
      </div>

      <div class="card">
        <img src="../menu Images/Bakery.webp" alt="Card Image" class="card-image">
        <div class="card-details">
          <h3>Confectionery and Bakery Products</h3>
          <p>Confectionery and bakery products show a high export growth and an increasing demand across five
            continents.</p>
        </div>
      </div>

      <div class="card">
        <img src="../menu Images/beverages.jpg" alt="Card Image" class="card-image">
        <div class="card-details">
          <h3>Beverages</h3>
          <p>Sri Lankan beverage manufacturers and suppliers export both alcoholic beverages and non- alcoholic
            beverages. Alcoholic beverages such as arrack, a smooth and popular drink and beer are also offered from
            distilleries and breweries manufacturing from centuries ago now adding modern equipment and processes to
            improve quality and volumes.</p>
        </div>
      </div>

      <div class="card">
        <img src="../menu Images/Vegan_biscuts.jpg" alt="Card Image" class="card-image">
        <div class="card-details">
          <h3>Vegan Biscuits</h3>
          <p>These biscuits do not contain any animal products, instead, they are made using vegetables, and certain
            types of grains. It has to be noted that the taste factor of these biscuits are unbelievable while they are
            also present in various flavours with various additives.</p>
        </div>
      </div>

      <div class="card">
        <img src="../menu Images/vegan-curry-noodles.jpg" alt="Card Image" class="card-image">
        <div class="card-details">
          <h3>Vegan Noodles</h3>
          <p>All the ingredients used in the making of these noodles are vegan friendly. This can be enjoyed by both
            vegans and non-vegans.</p>
        </div>
      </div>
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
      <img src="../menu Images/table-capacity.jpg" alt="Table Capacity">
      <div class="info-content">
        <h3>Table Capacities</h3>
        <p>We offer a variety of table sizes to accommodate different group sizes. From intimate tables for two to large
          tables for parties, we have the perfect seating for you.</p>
      </div>
    </div>
    <div class="info-section">
      <img src="../menu Images/parking.jpg" alt="Parking Availability">
      <div class="info-content">
        <h3>Parking Availability</h3>
        <p>Ample parking is available for our guests. We offer both valet and self-parking options to ensure a
          convenient and hassle-free dining experience.</p>
      </div>
    </div>
    <div class="info-section">
      <img src="../menu Images/special-promotions.png" alt="Special Promotions">
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
      loadComponent('../Components/header.html', 'header', '../css/Home.css');
      loadComponent('../Components/footer.html', 'footer', '../css/Home.css');
    });

  </script>

  <script>
    document.addEventListener("DOMContentLoaded", (event) => {
      const currentLocation = location.href;
      const menuItem = document.querySelectorAll("nav ul li a");
      const menuLength = menuItem.length;
      for (let i = 0; i < menuLength; i++) {
        if (menuItem[i].href === currentLocation) {
          menuItem[i].className = "active";
        }
        menuItem[i].addEventListener("click", function () {
          for (let j = 0; j < menuLength; j++) {
            menuItem[j].classList.remove("active");
          }
          this.classList.add("active");
        });
      }
    });
  </scrip >
</body >

</html >