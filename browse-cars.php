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

// Fetch cars from the database
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

// Check if there are cars
$cars = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cars[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Cars - Car Rental System</title>
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
                    <li><a class="hover:underline" href="browse-cars.php">Browse Cars</a></li>
                    <li><a class="hover:underline" href="my-bookings.html">My Bookings</a></li>
                    <li><a class="hover:underline" href="contact-us.html">Contact Us</a></li>
                    <li><a class="hover:underline" href="sign-up.html">Sign Up</a></li>
                    <li><a class="hover:underline" href="sign-in.html">Sign In</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4">
        <!-- Search Section -->
        <section class="mb-8">
            <h2 class="text-3xl font-bold mb-4">Search Cars</h2>
            <div class="flex flex-col md:flex-row gap-4">
                <input 
                    type="text" 
                    id="searchBrand" 
                    class="p-2 border rounded-md flex-1" 
                    placeholder="Search by brand (e.g., SUV, Sedan, Sports)">
                <input 
                    type="number" 
                    id="minPrice" 
                    class="p-2 border rounded-md flex-1" 
                    placeholder="Min Price">
                <input 
                    type="number" 
                    id="maxPrice" 
                    class="p-2 border rounded-md flex-1" 
                    placeholder="Max Price">
                <button 
                    class="bg-blue-600 text-white py-2 px-4 rounded-md" 
                    onclick="filterCars()">Search</button>
            </div>
        </section>
        <!-- Cars List -->
        <section id="carsList" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php foreach($cars as $car): ?>
            <div class="car-item bg-white p-4 rounded shadow-md" data-brand="<?= htmlspecialchars($car['brand']) ?>" data-price="<?= htmlspecialchars($car['price']) ?>">
                <img alt="<?= htmlspecialchars($car['name']) ?>" class="w-full h-48 object-cover rounded-md mb-4" src="<?= htmlspecialchars($car['image_url']) ?>">
                <h3 class="text-lg font-bold"><?= htmlspecialchars($car['name']) ?></h3>
                <p class="text-gray-700">Price: $<?= htmlspecialchars($car['price']) ?>/day</p>
                <button class="mt-2 w-full bg-blue-600 text-white py-2 rounded-md" onclick="redirectToPayment('<?= htmlspecialchars($car['name']) ?>', <?= htmlspecialchars($car['price']) ?>)">Book Now</button>
            </div>
            <?php endforeach; ?>
        </section>
    </main>
    <footer class="bg-blue-600 text-white p-4">
        <div class="container mx-auto text-center">
            <p>© 2023 Car Rental System. All rights reserved.</p>
        </div>
    </footer>
    <script>
        // Redirect to Payment Page
        function redirectToPayment(carName, pricePerDay) {
            const url = `book.html?car=${encodeURIComponent(carName)}&price=${encodeURIComponent(pricePerDay)}`;
            window.location.href = url;
        }

        // Filter Cars by Brand and Price
        function filterCars() {
            const brand = document.getElementById('searchBrand').value.toLowerCase();
            const minPrice = parseInt(document.getElementById('minPrice').value) || 0;
            const maxPrice = parseInt(document.getElementById('maxPrice').value) || Infinity;

            const cars = document.querySelectorAll('.car-item');
            cars.forEach(car => {
                const carBrand = car.getAttribute('data-brand').toLowerCase();
                const carPrice = parseInt(car.getAttribute('data-price'));

                if (
                    (!brand || carBrand.includes(brand)) &&
                    carPrice >= minPrice &&
                    carPrice <= maxPrice
                ) {
                    car.style.display = 'block';
                } else {
                    car.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
