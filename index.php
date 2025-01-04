<?php
include 'php/db_connect.php'; // Include database connection file

// Fetch cars from the database for display
$carQuery = "SELECT * FROM cars LIMIT 3"; // Adjust the query to fit your database structure
$carResults = $conn->query($carQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Car Rental System - Home</title>
    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }
        .blinking-text {
            animation: blink 1s infinite;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
</head>
<body class="font-roboto bg-gray-100">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Car Rental System</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a class="hover:underline" href="index.php">Home</a></li>
                    <li><a class="hover:underline" href="browse-cars.php">Browse Cars</a></li>
                    <li><a class="hover:underline" href="my-bookings.php">My Bookings</a></li>
                    <li><a class="hover:underline" href="contact-us.php">Contact Us</a></li>
                    <li><a class="hover:underline" href="sign-up.php">Sign Up</a></li>
                    <li><a class="hover:underline" href="sign-in.php">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <section class="mb-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Welcome to Car Rental System</h2>
            <marquee scroll="left">
                <p class="text-lg text-gray-700 mb-4">
                    Your one-stop solution for renting cars. We offer a wide range of vehicles to suit your needs, whether it's for a day, a week, or a month.
                </p>
            </marquee>
            <p class="blinking-text">Enjoy flexible rental plans, 24/7 customer support, and a seamless booking experience.</p>
            <img alt="A welcoming image of a car rental service with various cars in the background" 
                 class="w-full h-64 object-cover rounded-md mb-4" 
                 src="https://storage.googleapis.com/a1aa/image/Z33MSxrgCFaOINvQKv6TNVzLcTuMaUfk8EDnoQekIrdBETBUA.jpg" />
        </section>
        <section class="mb-8">
            <h2 class="text-xl font-bold mb-4">Top Luxurious Cars</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php
                if ($carResults->num_rows > 0) {
                    while ($car = $carResults->fetch_assoc()) {
                        echo '<div class="bg-white p-4 rounded shadow-md">';
                        echo '<img alt="' . htmlspecialchars($car['name']) . '" class="w-full h-48 object-cover rounded-md mb-4" src="' . htmlspecialchars($car['image_url']) . '" />';
                        echo '<h3 class="text-lg font-bold">' . htmlspecialchars($car['name']) . '</h3>';
                        echo '<p class="text-gray-700">Price: $' . htmlspecialchars($car['price_per_day']) . '/day</p>';
                        echo '<p class="text-gray-700">Features: ' . htmlspecialchars($car['features']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-gray-700">No cars available.</p>';
                }
                ?>
            </div>
        </section>
        <section class="mb-8">
            <h2 class="text-xl font-bold mb-4">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded shadow-md">
                    <h3 class="text-lg font-bold">24/7 Customer Support</h3>
                    <p class="text-gray-700">We offer round-the-clock customer support to assist you with any queries or issues.</p>
                </div>
                <div class="bg-white p-4 rounded shadow-md">
                    <h3 class="text-lg font-bold">Flexible Rental Plans</h3>
                    <p class="text-gray-700">Choose from a variety of rental plans that suit your needs, whether it's for a day, a week, or a month.</p>
                </div>
                <div class="bg-white p-4 rounded shadow-md">
                    <h3 class="text-lg font-bold">Wide Range of Vehicles</h3>
                    <p class="text-gray-700">From compact cars to luxury SUVs, we have a wide range of vehicles to choose from.</p>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>© 2025 Car Rental System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
