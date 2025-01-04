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
    $car_name = $_POST['car_name'];
    $price_per_day = $_POST['price_per_day'];
    $number_of_days = $_POST['number_of_days'];
    $total_price = $_POST['total_price'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];

    // Insert payment details into the database
    $sql = "INSERT INTO payments (car_name, price_per_day, number_of_days, total_price, card_number, expiry_date, cvv)
            VALUES ('$car_name', '$price_per_day', '$number_of_days', '$total_price', '$card_number', '$expiry_date', '$cvv')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to Thank You page after successful payment
        header('Location: thank-you.html');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
