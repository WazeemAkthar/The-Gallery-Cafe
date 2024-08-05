document.addEventListener("DOMContentLoaded", function () {
  // JavaScript code for interactivity
  console.log("The Gallery Café website is ready.");
});

let fetchedData = {
  menuItems: [],
  foodCultures: [],
  mealTypes: [],
};

document.addEventListener("DOMContentLoaded", function () {
  fetchData();
});

function fetchData() {
  fetch("Pages/fetch_all_data.php") // Adjust path if necessary
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.json();
    })
    .then((data) => {
      fetchedData.menuItems = data.menu_items;
      fetchedData.foodCultures = data.food_cultures;
      fetchedData.mealTypes = data.meal_types;

      const foodCultureMap = {};
      fetchedData.foodCultures.forEach((culture) => {
        foodCultureMap[culture.id] = culture.culture_name;
      });

      const mealTypeMap = {};
      fetchedData.mealTypes.forEach((mealType) => {
        mealTypeMap[mealType.id] = mealType.meal_type;
      });

      populateTable(fetchedData.menuItems, foodCultureMap, mealTypeMap);
    })
    .catch((error) => console.error("Error fetching data:", error));
}

function populateTable(menuItems, foodCultureMap, mealTypeMap) {
  const tableBody = document.querySelector("#menu-table tbody");
  menuItems.forEach((item) => {
    const row = document.createElement("tr");
    row.innerHTML = `
          <td>${item.id}</td>
          <td>${item.item_name}</td>
          <td>${item.item_description}</td>
          <td>${item.item_price}</td>
          <td>${foodCultureMap[item.item_cultures]}</td>
          <td>${mealTypeMap[item.item_type]}</td>
          <td><img src="${
            item.item_image
          }" alt="Item Image" style="width:100px;height:100px;"></td>
          <td>${item.created_at}</td>
      `;
    tableBody.appendChild(row);
  });
}

// Example of how to use fetched data in another function
function logMenuItems() {
  console.log(fetchedData.menuItems);
}

// Call logMenuItems after data is fetched
document.addEventListener("DOMContentLoaded", function () {
  fetchData().then(() => {
    logMenuItems(); // This will log the menu items to the console
  });
});
