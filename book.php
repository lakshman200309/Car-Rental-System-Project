<?php
include 'php/db_connect.php'; // Include the database connection file

// Initialize variables for car details
$carName = isset($_GET['car']) ? $_GET['car'] : '';
$pricePerDay = isset($_GET['price']) ? (int)$_GET['price'] : 0;
$userId = 1; // Assuming user is logged in and their ID is available. Replace with session/user management logic.

// Insert booking details into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carName = $_POST['carName'];
    $pricePerDay = $_POST['price'];
    $userId = $_POST['userId']; // Assuming you have a user ID from the session

    // Insert query to store booking details
    $query = "INSERT INTO bookings (user_id, car_name, price_per_day, booking_date) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isi", $userId, $carName, $pricePerDay);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Booking was successful
        header("Location: thank-you.html"); // Redirect to a thank-you page or confirmation page
        exit();
    } else {
        // Handle error if booking insertion fails
        echo "Error: Could not save booking details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System - Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="font-roboto bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Car Rental System</h1>
            <nav>
                <a href="index.php" class="ml-4 hover:underline">Home</a>
                <a href="my-bookings.php" class="ml-4 hover:underline">My Bookings</a>
                <a href="contact-us.php" class="ml-4 hover:underline">Contact Us</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Confirm Your Booking</h2>
        <section class="bg-white p-6 rounded shadow-md">
            <h3 class="text-xl font-bold mb-4" id="carName">Car Details</h3>
            <p class="text-gray-700" id="carPrice">Price per day: </p>
            <form method="POST" id="bookingForm">
                <input type="hidden" name="carName" id="carNameInput" value="<?php echo htmlspecialchars($carName); ?>">
                <input type="hidden" name="price" id="priceInput" value="<?php echo htmlspecialchars($pricePerDay); ?>">
                <input type="hidden" name="userId" value="<?php echo $userId; ?>"> <!-- Assume userId comes from session -->

                <button type="submit" class="mt-4 w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700 transition">
                    Proceed to Payment
                </button>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <nav>
                <a href="index.php" class="ml-4 hover:underline">Home</a>
                <a href="my-bookings.php" class="ml-4 hover:underline">My Bookings</a>
                <a href="contact-us.php" class="ml-4 hover:underline">Contact Us</a>
            </nav>
            <p class="mt-4">© 2023 Car Rental System. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Extract URL Parameters
        const params = new URLSearchParams(window.location.search);
        const carName = params.get('car');
        const pricePerDay = parseInt(params.get('price'), 10);

        // Populate Car Details
        document.getElementById('carName').textContent = carName;
        document.getElementById('carPrice').textContent = `Price per day: $${pricePerDay}`;

        // Populate hidden form fields
        document.getElementById('carNameInput').value = carName;
        document.getElementById('priceInput').value = pricePerDay;
    </script>
</body>
</html>
