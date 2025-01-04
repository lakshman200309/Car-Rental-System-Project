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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $car_id = $_POST['car_id'];
    $booking_date = $_POST['booking_date'];
    $return_date = $_POST['return_date'];

    // Calculate total price
    $sql_car = "SELECT price_per_day FROM cars WHERE id = $car_id";
    $result = $conn->query($sql_car);
    $car = $result->fetch_assoc();

    $price_per_day = $car['price_per_day'];
    $days = (strtotime($return_date) - strtotime($booking_date)) / (60 * 60 * 24);
    $total_price = $days * $price_per_day;

    // Insert booking into the database
    $sql = "INSERT INTO bookings (user_name, user_email, car_id, booking_date, return_date, total_price)
            VALUES ('$user_name', '$user_email', '$car_id', '$booking_date', '$return_date', '$total_price')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Booking Successful! You will be redirected to the Thank You page.";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
