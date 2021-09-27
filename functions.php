<?php
    /**
    * Creates a connection to the collectorapp database
    */
    function createDBConnection() :PDO{
        $db = new PDO('mysql:host=db; dbname=collectorapp', 'root', 'password');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }

    /**
    * A query to the database that fetches the data in all the fields and creates a recipes assoc array
    * @return array
    */
    function fetchAllRecipes($db): array {
        $query = $db->prepare('SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes`;');
        $query->execute();
        $recipes = $query->fetchAll();
        return $recipes;
    }

    /**
    * Creates recipe cards which have a name as well as stats on cuisine, time and a link to the recipe
    */
    function createRecipeCards(array $recipes) {
        if (count($recipes)>0) {
            $recipeCards = '';
            foreach ($recipes as $recipe) {
                $recipeCards .= '<section class= "recipe_card">';
                $recipeCards .= "<h2>{$recipe['recipe']}</h2>";
                $recipeCards .= "<h3>Cuisine: {$recipe['cuisine']}</h3>";
                $recipeCards .= "<h3>Time (mins): {$recipe['time']}</h3>";
                $recipeCards .= "<a href= {$recipe['link']}>Link to recipe</a>";
                $recipeCards .= "</section>";
            }
            return $recipeCards;
        } else {
            $noRecipesError = 'No available recipes';
            return $noRecipesError;
        }
    }