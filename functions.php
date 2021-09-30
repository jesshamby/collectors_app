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
 * @param PDO $db
 * @return array
 */
    function fetchAllRecipes(PDO $db): array {
        $query = $db->prepare("SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes` WHERE `deleted` = '0';");
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
                $recipeCards .= "<section class='recipe_card'>";
                $recipeCards .= "<h2>{$recipe['recipe']}</h2>";
                $recipeCards .= "<h3>Cuisine: {$recipe['cuisine']}</h3>";
                $recipeCards .= "<h3>Time (mins): {$recipe['time']}</h3>";
                $recipeCards .= "<a href= {$recipe['link']}>Link to recipe</a>";
                $recipeCards .= '</section>';
                $recipeCards .= '<form action="edit.php" method="post">';
                $recipeCards .= "<input type='hidden' value= '{$recipe['recipe']}' name='editRecipe'>";
                $recipeCards .= "<button type='submit' name='edit'>Edit Recipe</button>";
                $recipeCards .= '</form>';
                $recipeCards .= '<form action="delete.php" method="post">';
                $recipeCards .= "<input type='hidden' value='{$recipe['recipe']}' name='deleteRecipe' >";
                $recipeCards .= "<button type='submit' name='delete'>Delete Recipe</button>";
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
 * @param string $link
 */
    function addNewRecipe(PDO $db, string $recipe, string $cuisine, int $time, string $link) {
        $insertNewRecipe = $db->prepare( "INSERT INTO `recipes` (`recipe`, `cuisine`, `time`, `link`, `deleted`) VALUES (:newRecipe, :newCuisine, :newTime, :newLink, 0);");
        $insertNewRecipe-> bindParam(':newRecipe', $recipe);
        $insertNewRecipe-> bindParam(':newCuisine', $cuisine);
        $insertNewRecipe-> bindParam(':newTime', $time);
        $insertNewRecipe-> bindParam(':newLink', $link);
        $insertNewRecipe->execute();
    }