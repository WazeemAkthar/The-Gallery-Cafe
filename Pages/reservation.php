<?php
session_start();
if (!isset($_SESSION['role_id'])) {
    header("Location: login.html");
    exit();
}

// Set the timezone
date_default_timezone_set('America/New_York');

// Get current date and time
$currentDate = date('Y-m-d');
$currentTime = date('H:i');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/reservation.css">
    <title>Reservation - The Gallery Café</title>
</head>
<style>
    main {
        align-items: center;
        background-color: #000;
        display: flex;
        justify-content: center;
        height: 100vh;
    }

    .form {
        background-color: #15172b;
        border-radius: 20px;
        box-sizing: border-box;
        height: 600px;
        padding: 20px;
        width: 620px;
    }

    .title {
        color: #eee;
        font-family: sans-serif;
        font-size: 36px;
        font-weight: 600;
        margin-top: 30px;
    }

    .subtitle {
        color: #eee;
        font-family: sans-serif;
        font-size: 16px;
        font-weight: 600;
        margin-top: 10px;
    }

    .input-container {
        height: 50px;
        position: relative;
        width: 100%;
    }

    .ic1 {
        margin-top: 40px;
    }

    .ic2 {
        margin-top: 30px;
    }

    .input {
        background-color: #303245;
        border-radius: 12px;
        border: 0;
        box-sizing: border-box;
        color: #eee;
        font-size: 18px;
        height: 100%;
        outline: 0;
        padding: 4px 20px 0;
        width: 100%;
    }

    .cut {
        background-color: #15172b;
        border-radius: 10px;
        height: 20px;
        left: 20px;
        position: absolute;
        top: -20px;
        transform: translateY(0);
        transition: transform 200ms;
        width: 76px;
    }

    .cut-short {
        width: 50px;
    }

    .input:focus~.cut,
    .input:not(:placeholder-shown)~.cut {
        transform: translateY(8px);
    }

    .placeholder {
        color: #65657b;
        font-family: sans-serif;
        left: 20px;
        line-height: 14px;
        pointer-events: none;
        position: absolute;
        transform-origin: 0 50%;
        transition: transform 200ms, color 200ms;
        top: 20px;
    }

    .input:focus~.placeholder,
    .input:not(:placeholder-shown)~.placeholder {
        transform: translateY(-30px) translateX(10px) scale(0.75);
    }

    .input:not(:placeholder-shown)~.placeholder {
        color: #808097;
    }

    .input:focus~.placeholder {
        color: #dc2f55;
    }

    .submit {
        background-color: #08d;
        border-radius: 12px;
        border: 0;
        box-sizing: border-box;
        color: #eee;
        cursor: pointer;
        font-size: 18px;
        height: 50px;
        margin-top: 70px;
        // outline: 0;
        text-align: center;
        width: 100%;
    }

    .submit:active {
        background-color: #06b;
    }

    .form-reserv {
        display: flex;
        justify-content: space-between;
    }

    textarea {
        background-color: #303245;
        border-radius: 12px;
        border: 0;
        box-sizing: border-box;
        color: #eee;
        font-size: 18px;
        outline: 0;
        padding: 4px 20px 0;
        width: 100%;
        margin-bottom: 10px;
    }
</style>

<body>
    <div id="header"></div> <!-- Placeholder for header -->
    <main>
        <form class="form" id="reservationForm" action="../Backend/add_reservation.php" method="post">
            <div class="title">Welcome</div>
            <div class="subtitle">Let's Make a Reservation</div>
            <div class="form-reserv">
                <div>
                    <div class="input-container ic1">
                        <input id="name" class="input" type="text" placeholder=" " name="name" required />
                        <div class="cut"></div>
                        <label for="tname" class="placeholder">Name</label>
                    </div>

                    <div class="input-container ic2">
                        <input id="email" class="input" type="text" placeholder=" " name="email" required />
                        <div class="cut cut-short"></div>
                        <label for="email" class="placeholder">Email</label>
                    </div>

                    <div class="input-container ic2">
                        <input id="phone" class="input" type="tel" placeholder=" " name="phone" required />
                        <div class="cut"></div>
                        <label for="phone" class="placeholder">phone</label>
                    </div>
                </div>

                <div>
                    <div class="input-container ic1">
                        <input id="date" class="input" type="date" placeholder=" " name="date"
                            value="<?php echo $currentDate; ?>" required />
                        <div class="cut"></div>
                        <label for="date" class="placeholder">date</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="time" class="input" type="time" placeholder=" " name="time"
                            value="<?php echo $currentTime; ?>" required />
                        <div class="cut"></div>
                        <label for="time" class="placeholder">Time</label>
                    </div>
                    <div class="input-container ic2">
                        <input id="guests" class="input" type="number" name="guests" placeholder=" " required />
                        <div class="cut cut-short"></div>
                        <label for="guests" class="placeholder">Guests</label>
                    </div>

                </div>


            </div>
            <div class="input-container ic2">
                <div class="cut cut-short"></div>
                <label for="massage" class="placeholder">Special Requests</label>
                <textarea id="message" name="message" rows="4"></textarea>
            </div>

            <button type="text" class="submit">submit</button>
        </form>
    </main>
    <div id="footer"></div> <!-- Placeholder for footer -->

    <script src="../JS/components.js"></script>
    <script src="../JS/scripts.js"></script>
</body>

</html>