<?php
    /**
    * Creates a connection to the collectorapp database
    */
    function createDBConnection()
    {
        $db = new PDO('mysql:host=db; dbname=collectorapp', 'root', 'password');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    createDBConnection();

    /**
     * A query to the database that fetches the data in all the fields and creates a recipes assoc array
    * @return array
     */
    function fetchAllRecipes(): array {
        $query = $db->prepare('SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes`;');
        $query->execute();
        $recipes = $query->fetchAll();
        return $recipes;
    }

    fetchAllRecipes();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Recipes</title>
</head>
<body>
    <?php
        /**
         * Creates recipe cards which have a name as well as stats on cuisine, time and a link to the recipe
         */
        function createRecipeCards() {
            foreach ($recipes as $recipe) {
                echo '<section class= "recipe_card">';
                echo '<h2>' . $recipe['recipe'] . '<h2>';
                echo '<h3>Cuisine: ' . $recipe['cuisine'] . '</h3>';
                echo '<h3>Time (mins): ' . $recipe['time'] . '</h3>';
                echo '<a href=' . $recipe['link'] . '>Link to recipe</a>';
                echo '</section>';
            }

        createRecipeCards();
        }
    ?>
</body>
</html>

