<?php
// dashboard.php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user bookings
$stmt = $pdo->prepare("SELECT * FROM bookings WHERE user_id = ?");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>

<h2>Your Bookings</h2>
<?php foreach ($bookings as $booking): ?>
    <p>Car: <?= htmlspecialchars($booking['car_name']) ?></p>
    <p>Booking Date: <?= htmlspecialchars($booking['booking_date']) ?></p>
    <p>Return Date: <?= htmlspecialchars($booking['return_date']) ?></p>
    <p>Status: <?= htmlspecialchars($booking['status']) ?></p>
    <form action="cancel-booking.php" method="POST">
        <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
        <button type="submit">Cancel Booking</button>
    </form>
<?php endforeach; ?>
