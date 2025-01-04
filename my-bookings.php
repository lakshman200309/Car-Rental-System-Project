<?php
// Include database connection
include('php/db_connect.php');

// Get the user ID from session (assuming user is logged in)
session_start();
$user_id = $_SESSION['user_id'];  // Ensure user_id is stored in session after login

// Fetch the bookings for the logged-in user
$query = "SELECT bookings.id, cars.car_name, bookings.booking_date, bookings.return_date, bookings.total_price, bookings.status 
          FROM bookings 
          JOIN cars ON bookings.car_id = cars.id 
          WHERE bookings.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System - My Bookings</title>
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
                    <li><a class="hover:underline" href="my-bookings.php">My Bookings</a></li>
                    <li><a class="hover:underline" href="contact-us.html">Contact Us</a></li>
                    <li><a class="hover:underline" href="sign-up.html">Sign Up</a></li>
                    <li><a class="hover:underline" href="sign-in.html">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <h2 class="text-3xl font-bold mb-6 text-center">My Bookings</h2>
        <div class="bg-white p-6 rounded shadow-md">
            <h3 class="text-xl font-bold mb-4">Your Upcoming Bookings</h3>
            <div id="booking-list" class="space-y-4">
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="booking p-4 bg-gray-100 rounded shadow-md" data-status="<?= $row['status'] ?>">
                        <h4 class="text-lg font-bold"><?= htmlspecialchars($row['car_name']) ?></h4>
                        <p class="text-gray-700">Booking Date: <?= htmlspecialchars($row['booking_date']) ?></p>
                        <p class="text-gray-700">Return Date: <?= htmlspecialchars($row['return_date']) ?></p>
                        <p class="text-gray-700">Total Price: $<?= htmlspecialchars($row['total_price']) ?></p>
                        <?php if ($row['status'] === 'paid'): ?>
                            <button class="mt-2 bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 transition cancel-button">Cancel Booking</button>
                        <?php else: ?>
                            <button class="mt-2 bg-gray-400 text-white py-2 px-4 rounded-md cursor-not-allowed" disabled>Cancel Booking</button>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>© 2025 Car Rental System. All rights reserved.</p> 
        </div>
    </footer>

    <script>
        // Cancel booking functionality (you can enhance this based on your backend logic)
        const cancelButtons = document.querySelectorAll('.cancel-button');
        
        cancelButtons.forEach(button => {
            const booking = button.closest('.booking');
            const status = booking.getAttribute('data-status');
            
            if (status !== 'paid') {
                button.disabled = true;
            }
            
            button.addEventListener('click', () => {
                // Here, you can implement an AJAX request to cancel the booking in the database.
                // For now, just remove the booking from the DOM as an example.
                booking.remove();
            });
        });
    </script>
</body>
</html>

<?php
// Close the database connection
$stmt->close();
$conn->close();
?>
