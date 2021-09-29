<?php
/**
 * Creates a connection to the collectorapp database
 *
 * @return PDO
 */
    function createDBConnection(): PDO {
        $db = new PDO('mysql:host=db; dbname=collectorapp', 'root', 'password');
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }

/**
 * A query to the database that fetches the data in all the fields and creates a recipes assoc array
 *
 * @param $db
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
 *
 * @param array $recipes
 * @return string
 */
    function createRecipeCards(array $recipes): string {
        if (count($recipes)>0) {
            $recipeCards = '';
            foreach ($recipes as $recipe) {
                $recipeCards .= "<section class= 'recipe_card'>";
                $recipeCards .= "<h2>{$recipe['recipe']}</h2>";
                $recipeCards .= "<h3>Cuisine: {$recipe['cuisine']}</h3>";
                $recipeCards .= "<h3>Time (mins): {$recipe['time']}</h3>";
                $recipeCards .= "<a href= {$recipe['link']}>Link to recipe</a>";
                $recipeCards .= '</section>';
                $recipeCards .= "<form action=edit.php>";
                $recipeCards .= '<button type="button" name= "$recipe">Edit Recipe</button>';
                $recipeCards .= '</form>';
                $recipeCards .= "<form action=delete.php>";
                $recipeCards .= '<button type="button" name= "$recipe">Delete Recipe</button>';
                $recipeCards .= '</form>';
            }
            return $recipeCards;
        } else {
            return 'No available recipes';
        }
    }

/**
 * Takes an inputted link and checks it is valid, if not it returns an error.
 *
 * @param string $error
 * @return string
 */
function linkValidation(string $error): string {
    if (!filter_var($_POST['link'], FILTER_VALIDATE_URL)) {
        $error = 'Invalid link';
    }
    return $error;
}

 /**
  * Takes a string and removes any whitespace either side, removes black slashes
  *
 * @param string $stringInput
 * @return string
 */
    function validateString(string $stringInput): string {
        $stringInput = trim($stringInput);
        $stringInput = stripslashes($stringInput);
        return $stringInput;
    }

/**
 * Adds a new recipe, with all the inputted stats, to the db
 *
 * @param PDO $db
 * @param string $recipe
 * @param string $cuisine
 * @param int $time
 * @param $link
 */
    function addNewRecipe(PDO $db, string $recipe, string $cuisine, int $time, $link) {
        $insertNewRecipe = $db->prepare( "INSERT INTO `recipes` (`recipe`, `cuisine`, `time`, `link`) VALUES (:newRecipe, :newCuisine, :newTime, :newLink);");
        $insertNewRecipe-> bindParam(':newRecipe', $recipe);
        $insertNewRecipe-> bindParam(':newCuisine', $cuisine);
        $insertNewRecipe-> bindParam(':newTime', $time);
        $insertNewRecipe-> bindParam(':newLink', $link);
        $insertNewRecipe->execute();
    }