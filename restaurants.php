<?php
include 'conf.php'; // DB connection

$query = mysqli_query($conn, "SELECT * FROM restaurant");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Restaurants - BiteBuzz</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Explore Restaurants</h1>
    <div class="restaurant-container">
    <?php while($row = mysqli_fetch_assoc($query)) { ?>
        <div class="restaurant-card">
            <img src="<?php echo $row['image_url']; ?>" alt="Image" width="200">
            <h3><?php echo $row['name']; ?></h3>
            <p><?php echo $row['location']; ?></p>
            <a href="menu1.php?restaurant_id=<?php echo $row['restaurant_id']; ?>">View Menu</a>
        </div>
    <?php } ?>
    </div>
</body>
</html>
