<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);
    if (isset($_POST['edit'])) {
        header("Locations: edit.php");
        exit;
    } elseif (isset($_POST['delete'])) {
        header("Locations: delete.php");
        exit;
    }

    $error = '';

    if (!empty($_POST['addRecipe']) && !empty($_POST['addCuisine']) && !empty($_POST['addTime']) && !empty($_POST['addLink'])) {
        linkValidation($error);

        if ($error === '') {
            $recipe = validateString($_POST['addRecipe']);
            $cuisine = validateString($_POST['addCuisine']);
            $time = $_POST['addTime'];
            $link = trim($_POST['addLink']);
            addNewRecipe($db, $recipe, $cuisine, $time, $link);
        }
    } elseif (!empty($_POST['addRecipe']) Xor !empty($_POST['addCuisine']) Xor !empty($_POST['addTime']) Xor !empty($_POST['addLink'])) {
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
            <input name="addRecipe" type="text">
        </label>
        <label>Cuisine:
            <input name="addCuisine" type="text">
        </label>
        <label>Time (mins):
            <input name="addTime" type="number">
        </label>
        <label>Link to recipe:
            <input name="addLink" type="url">
        </label>
        <input type="submit">
    </form>
    <span><?php echo $error ?></span>
</body>
</html>

