<?php
// Database connection
$servername = "localhost";
$username = "root";  // Default XAMPP MySQL username
$password = "";  // Default XAMPP MySQL password (empty)
$dbname = "car_rental_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message
$message = '';

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $message_content = $_POST['message'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_us (full_name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $message_content);

    // Execute the query
    if ($stmt->execute()) {
        $message = "Thank you for contacting us! We will get back to you soon.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System - Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="font-roboto bg-gray-100">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Car Rental System</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a class="hover:underline" href="index.html">Home</a></li>
                    <li><a class="hover:underline" href="browse-cars.html">Browse Cars</a></li>
                    <li><a class="hover:underline" href="my-bookings.html">My Bookings</a></li>
                    <li><a class="hover:underline" href="contact-us.php">Contact Us</a></li>
                    <li><a class="hover:underline" href="sign-up.html">Sign Up</a></li>
                    <li><a class="hover:underline" href="sign-in.html">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <h2 class="text-3xl font-bold mb-6 text-center">Contact Us</h2>
        <p class="text-gray-700 text-center mb-4">Have a question or need assistance? Fill out the form below, and our team will get back to you as soon as possible.</p>
        
        <?php if ($message): ?>
        <div class="bg-green-200 text-green-800 p-4 rounded-md mb-4 text-center"><?= $message ?></div>
        <?php endif; ?>

        <form action="contact-us.php" method="POST" class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Full Name</label>
                <input id="name" name="name" type="text" placeholder="Enter your full name" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-bold mb-2">Email Address</label>
                <input id="email" name="email" type="email" placeholder="Enter your email" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-gray-700 font-bold mb-2">Message</label>
                <textarea id="message" name="message" placeholder="Write your message here" class="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600" rows="5" required></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700 transition">Submit</button>
        </form>

        <div class="mt-8 text-center">
            <h3 class="text-xl font-bold mb-2">Contact Information</h3>
            <p class="text-gray-700"><i class="fas fa-phone mr-2"></i>+1 (555) 123-4567</p>
            <p class="text-gray-700"><i class="fas fa-envelope mr-2"></i>support@carrentalsystem.com</p>
            <p class="text-gray-700"><i class="fas fa-map-marker-alt mr-2"></i>123 Car Rental Ave, City, State, ZIP</p>
        </div>
    </main>
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>© 2023 Car Rental System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
