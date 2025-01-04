<?php
// Include database connection
include('php/db_connect.php');

// Initialize error messages
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start a session and store user data
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the home page or dashboard
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sign In - Car Rental System</title>
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
            <h2 class="text-3xl font-bold mb-6 text-center">Sign In</h2>

            <?php
            if (!empty($error)) {
                echo '<div class="text-red-600 mb-4">' . $error . '</div>';
            }
            ?>

            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded mb-4" required>

            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded mb-4" required>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md">Sign In</button>
        </form>
    </main>
</body>
</html>
