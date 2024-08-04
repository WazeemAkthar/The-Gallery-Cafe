<?php
session_start();
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
  header("Location: login.html");
  exit();
}

// Fetch data
$sql = "SELECT id, item_name, item_description, item_price, item_cultures, item_type, item_image, created_at FROM menu";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - The Gallery Café</title>
  <style>
    .Dashbord-Container {
      display: none;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f8f8;
      margin: 0;
      padding: 20px;
      text-align: center;
    }

    button {
      background-color: #5bc0de;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 10px 20px;
      margin: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #31b0d5;
    }

    /* .form-container {
      display: none;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 20px auto;
      padding: 20px;
      text-align: left;
      z-index: 1001;
    } */

    .form-container {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      padding: 20px;
      text-align: left;
      z-index: 1001;
    }

    h3 {
      font-size: 24px;
      color: #333;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-size: 14px;
      color: #555;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
      width: calc(100% - 20px);
      padding: 8px 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    button[type="submit"] {
      display: block;
      width: 100%;
      padding: 10px;
      background-color: #d9534f;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #c9302c;
    }

    .form-container.active {
      display: block;
    }

    .form-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      z-index: 1000;
    }

    .form-overlay.active {
      display: block;
    }
  </style>
</head>

<body>
  <div id="header"></div>

  <h1>Welcome, Admin <?php echo $_SESSION['name']; ?></h1>

  <button onclick="showDashboard('dashboard1')">Manage Reservations</button>
  <button onclick="showDashboard('dashboard2')">Manage Menu Foods and Drinks</button>
  <button onclick="showDashboard('dashboard3')">Create Staff or Admin Account</button>
  <button onclick="showDashboard('dashboard4')">View Users</button>

  <!----------------------------------------------- Manage Reservations ----------------------------------------------->
  <div id="dashboard1" class="Dashbord-Container">
    <button onclick="showForm('form4')">Add a New Reservations</button>

    <div id="form4" class="form-container">
      <h3>Form 4</h3>
      <form>
        <div class="form-group">
          <label for="form1-item-name">Item Name:</label>
          <input type="text" id="form1-item-name" name="item_name" />
        </div>
        <div class="form-group">
          <label for="form1-item-description">Description:</label>
          <input type="text" id="form1-item-description" name="item_description" />
        </div>
        <button type="submit">Submit Form 4</button>
      </form>
    </div>
  </div>

  <!----------------------------------------------- Manage Menu Foods and Drinks ----------------------------------------------->
  <div id="dashboard2" class="Dashbord-Container">
    <button onclick="showForm('form1')">Add a New Food culture</button>
    <button onclick="showForm('form2')">Add New Meal Type</button>
    <button onclick="showForm('form3')">Add New Food or Drinks Item</button>
    <!-- Add a New Food culture -->
    <div id="form1" class="form-container">
      <h3>Add a New Food culture</h3>
      <form action="../Backend/add_food_culture.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="item-name">Food culture:</label>
          <input type="text" id="item-name" name="item-name" required />
        </div>
        <button type="submit">Add Food culture</button>
      </form>
    </div>

    <!-- Add New Meal Type -->
    <div id="form2" class="form-container">
      <h3>Add New Meal Type</h3>
      <form action="../Backend/add_meal_type.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="item-name">Meal Type:</label>
          <input type="text" id="item-name" name="item-name" required />
        </div>
        <button type="submit">Add Meal Type</button>
      </form>
    </div>

    <!-- Add New Food or Drinks Item -->
    <div id="form3" class="form-container">
      <h3>Add Menu Item</h3>
      <form action="../Backend/add_menu_item.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="item-name">Item Name:</label>
          <input type="text" id="item-name" name="item_name" required />
        </div>
        <div class="form-group">
          <label for="item-description">Description:</label>
          <input type="text" id="item-description" name="item_description" required />
        </div>
        <div class="form-group">
          <label for="item-price">Price:</label>
          <input type="number" id="item-price" name="item_price" step="0.01" required />
        </div>
        <div class="form-group">
          <label for="item-cultures">Food Cultures:</label>
          <input type="text" id="item-cultures" name="item_cultures" required />
        </div>
        <div class="form-group">
          <label for="item-type">Meal Type:</label>
          <input type="text" id="item-type" name="item_type" required />
        </div>
        <div class="form-group">
          <label for="item-image">Image:</label>
          <input type="file" id="item-image" name="item_image" required />
        </div>
        <button type="submit">Add Item</button>
      </form>
    </div>
  </div>

  <!----------------------------------------------- Create Staff or Admin Account ----------------------------------------------->
  <div id="dashboard3" class="Dashbord-Container">
    <button onclick="showForm('form5')">Create a Staff or Admin Account</button>
    <div id="form5" class="form-container">
      <h3>Form 3</h3>
      <form>
        <div class="form-group">
          <label for="form3-item-name">Item Name:</label>
          <input type="text" id="form3-item-name" name="item_name" />
        </div>
        <div class="form-group">
          <label for="form3-item-description">Description:</label>
          <input type="text" id="form3-item-description" name="item_description" />
        </div>
        <button type="submit">Submit Form 3</button>
      </form>
    </div>
  </div>
  <!----------------------------------------------- View Users ----------------------------------------------->
  <div id="dashboard4" class="Dashbord-Container">
    <button onclick="showForm('form6')">Add a New Reservations</button>
    <div id="form6" class="form-container">
      <h3>Form 4</h3>
      <form>
        <div class="form-group">
          <label for="form4-item-name">Item Name:</label>
          <input type="text" id="form4-item-name" name="item_name" />
        </div>
        <div class="form-group">
          <label for="form4-item-description">Description:</label>
          <input type="text" id="form4-item-description" name="item_description" />
        </div>
        <button type="submit">Submit Form 4</button>
      </form>
    </div>
  </div>
  <div id="formOverlay" class="form-overlay"></div>

  <script>
    function showDashboard(dashboardId) {
      var forms = document.getElementsByClassName("Dashbord-Container");
      for (var i = 0; i < forms.length; i++) {
        forms[i].style.display = "none";
      }
      document.getElementById(dashboardId).style.display = "block";
    }

    function showForm(formId) {
      document.getElementById('form1').classList.remove('active');
      document.getElementById('form2').classList.remove('active');
      document.getElementById('form3').classList.remove('active');
      document.getElementById('form4').classList.remove('active');
      document.getElementById('form5').classList.remove('active');
      document.getElementById('form6').classList.remove('active');
      document.getElementById('formOverlay').classList.remove('active');
      if (formId) {
        document.getElementById(formId).classList.add('active');
        document.getElementById('formOverlay').classList.add('active');
      }
    }

    showForm(null);

    document.getElementById('formOverlay').addEventListener('click', function () {
      showForm(null);
    });
    // function showForm(formId) {
    //   var forms = document.getElementsByClassName("form-container");
    //   for (var i = 0; i < forms.length; i++) {
    //     forms[i].style.display = "none";
    //   }
    //   document.getElementById(formId).style.display = "block";
    // }
  </script>

  <script src="../JS/components.js"></script>
  <script src="../JS/scripts.js"></script>
</body>

</html>