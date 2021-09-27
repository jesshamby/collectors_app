<?php
    require_once('functions.php');
    createDBConnection();
    fetchAllRecipes($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
</head>
<body>
    <?php
        createRecipeCards(array $recipes);
    ?>
</body>
</html>

