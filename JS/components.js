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

document.addEventListener('DOMContentLoaded', function() {
    loadComponent('../Components/header.html', 'header', '../css/Home.css');
    loadComponent('../Components/footer.html', 'footer', '../css/Home.css');
    // loadComponent('../Components/sidebar.html', 'sidebar', '../css/styles.css');
});
