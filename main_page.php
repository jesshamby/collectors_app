<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);

    $recipeErr = $cuisineErr = $timeErr = $linkErr = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($_POST['recipe'])) {
            $recipeErr = "Recipe name is required";
        } else {
            $recipe = validateString($_POST['recipe']);
        }

        if (empty($_POST['cuisine'])) {
            $cuisineErr = "Cuisine is required";
        } else {
            $cuisine = validateString($_POST['cuisine']);
        }
    }
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
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>
        <label for="recipe">Recipe:</label>
        <input name="recipe" type="text">
        <span class="error"><?php echo $recipeErr ?></span>
        <label for="cuisine">Cuisine:</label>
        <input name="cuisine" type="text">
        <span class="error"><?php echo $cuisineErr ?></span>
        <label for="time">Time (mins):</label>
        <input name="time" type="number">
        <label for="link">Link to recipe:</label>
        <input name="link" type="url">
        <input type="submit">
    </form>
</body>
</html>

