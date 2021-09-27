<?php
$db = new PDO('mysql:host=db; dbname=collectorapp', 'root', 'password');
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

//Select all the field in my recipes table and fetch-all to create an assoc array
$query = $db->prepare('SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes`;');
$query->execute();
$recipes = $query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
</head>
<body>
    <?php
        foreach ($recipes as $recipe) {
            echo '<section class= "recipe_card">';
            echo '<h2>' . $recipe['recipe'] . '<h2>';
            echo '<h3>Cuisine: ' . $recipe['cuisine'] . '</h3>';
            echo '<h3>Time (mins): ' . $recipe['time'] . '</h3>';
            echo '<a href=' . $recipe['link'] .'>Link to recipe</a>';
            echo '</section>';
        }
    ?>
</body>
</html>

