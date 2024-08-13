function loadComponent(componentPath, elementId, cssPath) {
  fetch(componentPath)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      document.getElementById(elementId).innerHTML = data;
      if (cssPath) {
        loadCSS(cssPath);
      }
      if (elementId === "header") {
        // Only add the active state script if the header is loaded
        setActiveState();
      }
    })
    .catch((error) => console.error("Error loading component:", error));
}

function loadCSS(cssPath) {
  let link = document.createElement("link");
  link.rel = "stylesheet";
  link.href = cssPath;
  document.head.appendChild(link);
}

function setActiveState() {
  const currentLocation = location.href.split("#")[0]; // Handle hash in URL
  const menuItem = document.querySelectorAll("nav ul li a");
  const menuLength = menuItem.length;
  for (let i = 0; i < menuLength; i++) {
    const linkHref = menuItem[i].href.split("#")[0]; // Handle hash in URL
    if (
      linkHref === currentLocation ||
      (currentLocation.endsWith("/") &&
        linkHref === currentLocation.slice(0, -1))
    ) {
      menuItem[i].className = "active";
    }
    menuItem[i].addEventListener("click", function () {
      for (let j = 0; j < menuLength; j++) {
        menuItem[j].classList.remove("active");
      }
      this.classList.add("active");
    });
  }
}

document.addEventListener("DOMContentLoaded", function () {
  loadComponent("../Components/header.html", "header", "../css/Home.css");
  loadComponent("../Components/footer.html", "footer", "../css/Home.css");
  loadComponent(
    "../Components/adminNav.html",
    "adminNav",
    "../css/adminNav.css"
  );
  loadComponent("../Components/staffheader.html", "staffheader", "../css/adminNav.css");
});
