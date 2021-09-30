<?php
    require_once('functions.php');
    $db = createDBConnection();
    if (isset($_POST['deleteRecipe'])) {
        $id = $_POST['deleteRecipe'];
        $recipeToDelete = findrecipeName($db, $id);
        $recipeName = $recipeToDelete['recipe'];
    }
    if (isset($_POST['yesDelete'])) {
        $id = $_POST['yesDelete'];
        $deletedRecipe = deleteRecipe($db, $id);
        if ($deletedRecipe) {
            header("Location: main_page.php");
            exit;
        }
    } elseif (isset($_POST['noDelete'])) {
        header("Location: main_page.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Recipe</title>
</head>
<body>
    <p>Are you sure you want to permanently delete the recipe: <?php echo $recipeName ?></p>
    <form action="delete.php" method="post">
        <button type="submit" name="yesDelete" value= "<?php echo $_POST['deleteRecipe'] ?>">Yes</button>
        <button type="submit" name="noDelete">No</button>
    </form>
</body>
</html>


