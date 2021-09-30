<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);

    $findRecipeEdit = $db->prepare("SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes` WHERE `recipe` = :recipe AND `deleted` = '0';");
    $findRecipeEdit->bindParam(':recipe', $_POST['editRecipe']);
    $findRecipeEdit->execute();
    $recipeEdit = $findRecipeEdit->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe</title>
</head>
<body>
    <form action ="main_page.php" method="post">
        <label>Recipe:
            <input name="editRecipe" type="text" value="<?php echo $recipeEdit['recipe'] ?>">
        </label>
        <label>Cuisine:
            <input name="editCuisine" type="text" value="<?php echo $recipeEdit['cuisine'] ?>">
        </label>
        <label>Time (mins):
            <input name="editTime" type="number" value="<?php echo $recipeEdit['time'] ?>">
        </label>
        <label>Link to recipe:
            <input name="editLink" type="url" value="<?php echo $recipeEdit['link'] ?>">
        </label>
        <input type="submit" name="editedRecipe">
    </form>
</body>
</html>
