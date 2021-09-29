<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);

    $error = '';

    if (!empty($_POST['recipe']) && !empty($_POST['cuisine']) && !empty($_POST['time']) && !empty($_POST['link'])) {
        linkValidation($error);

        if ($error === '') {
            $recipe = validateString($_POST['recipe']);
            $cuisine = validateString($_POST['cuisine']);
            $time = $_POST['time'];
            $link = trim($_POST['link']);
            addNewRecipe($db, $recipe, $cuisine, $time, $link);
        }
    } else {
        $error = 'All fields are required';
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
    <form method="post">
        <label>Recipe:
            <input name="recipe" type="text">
        </label>
        <label>Cuisine:
            <input name="cuisine" type="text">
        </label>
        <label>Time (mins):
            <input name="time" type="number">
        </label>
        <label>Link to recipe:
            <input name="link" type="url">
        </label>
        <input type="submit">
    </form>
    <span><?php echo $error ?></span>
</body>
</html>

