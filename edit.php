<?php
    require_once('functions.php');
    $db = createDBConnection();
    $recipes = fetchAllRecipes($db);

    $recipeName = $_POST['edit_recipe'];
    $query = $db->prepare("SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes` WHERE `recipe` = :recipe AND `deleted` = '0';");
    $query->bindParam(':recipe', $recipeName);
    $query->execute();
    $recipe = $query->fetch();
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
            <input name="recipe" type="text" value="<?php echo $recipe['recipe'] ?>">
        </label>
        <label>Cuisine:
            <input name="cuisine" type="text" value="<?php echo $recipe['cuisine'] ?>">
        </label>
        <label>Time (mins):
            <input name="time" type="number" value="<?php echo $recipe['time'] ?>">
        </label>
        <label>Link to recipe:
            <input name="link" type="url" value="<?php echo $recipe['link'] ?>">
        </label>
        <input type="submit">
</form>

</body>
</html>
