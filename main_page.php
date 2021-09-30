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
    if (isset($_POST['yesDelete'])) {
        $recipeName = $_POST['yesDelete'];
        $recipeDelete = $db->prepare("SELECT `id` FROM `recipes` WHERE `recipe` = :recipe AND `deleted` = '0' LIMIT 1;");
        $recipeDelete->bindParam(':recipe', $recipeName);
        $recipeDelete->execute();
        $idToDelete = $recipeToDelete->fetch();
        $query = $db->prepare("UPDATE `recipes` SET `deleted` = '1' WHERE `id` = '{$idToDelete['id']}';");
        $query->execute();
    } elseif (isset($_POST['editedRecipe'])) {
        $recipeEdits = ['recipe' => $_POST['editRecipe'], 'cuisine' => $_POST['editCuisine'], 'time' => $_POST['editTime'], 'link' => $_POST['editLink']];
        $query = $db->prepare("UPDATE `recipes` SET `recipe` = :recipe, `cuisine` = :cuisine, `time` = :time, `link` = :link WHERE `recipe` = :recipe LIMIT 1");
        $query-> bindParam(':recipe', $recipeEdits['recipe']);
        $query-> bindParam(':cuisine', $recipeEdits['cuisine']);
        $query-> bindParam(':time', $recipeEdits['time']);
        $query-> bindParam(':link', $recipeEdits['link']);
        $query->execute();
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

