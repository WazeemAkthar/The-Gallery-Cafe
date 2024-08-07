<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Card Hover Effect</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .card {
        position: relative;
        width: 300px;
        height: 400px;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s;
    }

    .card-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-details {
        position: absolute;
        bottom: -100%;
        /* Start from below the card */
        left: 0;
        width: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 20px;
        box-sizing: border-box;
        transition: bottom 0.5s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .card:hover .card-details {
        bottom: 0;
        /* Slide up to show the details */
    }
</style>

<body>
    <div class="card-container">
        <div class="card">
            <img src="../menu Images/Italian Pizza.webp" alt="Card Image" class="card-image">
            <div class="card-details">
                <h3>Card Title</h3>
                <p>Some details about the card item.</p>
            </div>
        </div>

        <div class="card">
            <img src="../menu Images/Chinese Noodles.avif" alt="Card Image" class="card-image">
            <div class="card-details">
                <h3>Card Title</h3>
                <p>Some details about the card item.</p>
            </div>
        </div>

        <div class="card">
            <img src="your-image.jpg" alt="Card Image" class="card-image">
            <div class="card-details">
                <h3>Card Title</h3>
                <p>Some details about the card item.</p>
            </div>
        </div>

        <div class="card">
            <img src="your-image.jpg" alt="Card Image" class="card-image">
            <div class="card-details">
                <h3>Card Title</h3>
                <p>Some details about the card item.</p>
            </div>
        </div>
        <!-- Add more cards as needed -->
    </div>
</body>

</html>