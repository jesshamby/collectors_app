<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);
    if (isset($_POST['editRecipe'])) {
        $id = $_POST['editRecipe'];
        $recipeToEdit = findRecipe($db, $id);
        if (isset($_POST['editedRecipe'])) {
            $editRecipe = editRecipe($db, $recipeToEdit);
            if ($editRecipe) {
                header("Location: main_page.php");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Recipe</title>
</head>
<body>
    <form action ="edit.php" method="post">
        <label>Recipe:
            <input name="editRecipe" type="text" value="<?php echo $recipeToEdit['recipe'] ?>">
        </label>
        <label>Cuisine:
            <input name="editCuisine" type="text" value="<?php echo $recipeToEdit['cuisine'] ?>">
        </label>
        <label>Time (mins):
            <input name="editTime" type="number" value="<?php echo $recipeToEdit['time'] ?>">
        </label>
        <label>Link to recipe:
            <input name="editLink" type="url" value="<?php echo $recipeToEdit['link'] ?>">
        </label>
        <input type="submit" name="editedRecipe">
    </form>
</body>
</html>
