<?php
// Include database connection
include('php/db_connect.php');

// Initialize variables
$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form fields
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert the user into the database
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // Display success message
            $message = "Successfully registered!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Car Rental System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-roboto bg-gray-100">
    <!-- Header with Navigation -->
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

    <!-- Main Content -->
    <main class="container mx-auto p-4">
        <form method="POST" class="max-w-md mx-auto bg-white p-6 rounded shadow-md">
            <h2 class="text-3xl font-bold mb-6 text-center">Sign Up</h2>

            <!-- Success or Error Messages -->
            <?php
            if (!empty($message)) {
                echo '<div class="text-green-600 mb-4">' . $message . '</div>';
            }
            if (!empty($error)) {
                echo '<div class="text-red-600 mb-4">' . $error . '</div>';
            }
            ?>

            <label for="username" class="block text-gray-700">Username</label>
            <input type="text" name="username" id="username" class="w-full p-2 border rounded mb-4" required>

            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded mb-4" required>

            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded mb-4" required>

            <label for="confirm_password" class="block text-gray-700">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="w-full p-2 border rounded mb-4" required>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md">Sign Up</button>
        </form>
    </main>
</body>
</html>
