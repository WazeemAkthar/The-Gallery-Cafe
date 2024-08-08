<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar with Underline</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .navbar {
        position: relative;
    }

    .nav-list {
        display: flex;
        justify-content: space-between;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .nav-item {
        margin: 20px;
        width: 25%;
    }

    .nav-link {
        text-decoration: none;
        color: #000;
        padding: 10px 0;
        position: relative;
        width: 25%;
    }

    .nav-link:hover {
        background-color: #007bff;
    }

    .underline {
        position: absolute;
        bottom: 0;
        left: 0;
        margin-top: 2px;
        height: 4px;
        width: 0;
        background-color: #007bf2;
        transition: left 0.3s, width 0.3s;
    }

    .nav-link.active~.underline {
        width: 100%;
    }

    .nav-link:hover~.underline {
        width: 100%;
    }

    .nav-link.active {
        font-weight: bold;
    }
</style>

<body>
    <nav class="navbar">
        <ul class="nav-list">
            <a href="#" class="nav-link" id="es6">
                <li class="nav-item">ES6</li>
            </a>
            <a href="#" class="nav-link" id="flexbox">
                <li class="nav-item">Flexbox</li>
            </a>
            <a href="#" class="nav-link" id="react">
                <li class="nav-item">React</li>
            </a>
            <a href="#" class="nav-link" id="angular">
                <li class="nav-item">Angular</li>
            </a>
            <a href="#" class="nav-link" id="other">
                <li class="nav-item">Other</li>
            </a>
        </ul>
        <div class="underline"></div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.nav-link');
            const underline = document.querySelector('.underline');

            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function () {
                    const { left, width } = this.getBoundingClientRect();
                    const { left: containerLeft } = this.closest('.navbar').getBoundingClientRect();
                    underline.style.left = `${left - containerLeft}px`;
                    underline.style.width = `${width}px`;
                });

                link.addEventListener('mouseleave', function () {
                    underline.style.width = '0';
                });

                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    navLinks.forEach(link => link.classList.remove('active'));
                    this.classList.add('active');
                    const { left, width } = this.getBoundingClientRect();
                    const { left: containerLeft } = this.closest('.navbar').getBoundingClientRect();
                    underline.style.left = `${left - containerLeft}px`;
                    underline.style.width = `${width}px`;
                });
            });

            // Set initial active link and underline position
            const activeLink = document.querySelector('.nav-link.active');
            if (activeLink) {
                const { left, width } = activeLink.getBoundingClientRect();
                const { left: containerLeft } = activeLink.closest('.navbar').getBoundingClientRect();
                underline.style.left = `${left - containerLeft}px`;
                underline.style.width = `${width}px`;
            }
        });

    </script>
</body>

</html>