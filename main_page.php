<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
</head>
<body>
    <?php
        echo createRecipeCards($recipes);
    ?>
    <form method="post">
        <label for="recipe">Recipe:</label>
        <input name="recipe" type="text">
        <label for="cuisine">Cuisine:</label>
        <input name="cuisine" type="text">
        <label for="time">Time (mins):</label>
        <input name="time" type="number">
        <label for="link">Link to recipe:</label>
        <input name="link" type="url">
        <input type="submit">
    </form>
</body>
</html>

