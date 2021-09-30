<?php
/**
 * Creates a connection to the collectorApp database
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
        $query = $db->prepare('SELECT `recipe`, `cuisine`, `time`, `link`, `id` FROM `recipes` WHERE `deleted` = 0;');
        $query->execute();
        return $query->fetchAll();
    }

/**
 * Creates recipe cards which have a name as well as stats on cuisine, time and a link to the recipe as wll as and edit
 * and delete button which takes the user to a new page
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
                $recipeCards .= "<form action='edit.php' method='post'>";
                $recipeCards .= "<input type='hidden' value='{$recipe['id']}' name='editRecipe'>";
                $recipeCards .= "<button type='submit' name='edit'>Edit Recipe</button>";
                $recipeCards .= '</form>';
                $recipeCards .= "<form action='delete.php' method='post'>";
                $recipeCards .= "<input type='hidden' value='{$recipe['id']}' name='deleteRecipe'>";
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
    if (!filter_var($_POST['addLink'], FILTER_VALIDATE_URL)) {
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
        return stripslashes($stringInput);
    }

/**
 * Adds a new recipe, with all the inputted stats, to the db
 *
 * @param PDO $db
 * @param string $recipe
 * @param string $cuisine
 * @param int $time
 * @param string $link
 * @return void
 */
    function addNewRecipe(PDO $db, string $recipe, string $cuisine, int $time, string $link): void {
        $insertNewRecipe = $db->prepare( "INSERT INTO `recipes` (`recipe`, `cuisine`, `time`, `link`, `deleted`) VALUES (:newRecipe, :newCuisine, :newTime, :newLink, 0);");
        $insertNewRecipe-> bindParam(':newRecipe', $recipe);
        $insertNewRecipe-> bindParam(':newCuisine', $cuisine);
        $insertNewRecipe-> bindParam(':newTime', $time);
        $insertNewRecipe-> bindParam(':newLink', $link);
        $insertNewRecipe->execute();
    }

/**
 * Finds the recipe in the db that the user wants to edit
 *
 * @param PDO $db
 * @return array
 */
    function findRecipe(PDO $db, $id): array {
        $findRecipeEdit = $db->prepare('SELECT `recipe`, `cuisine`, `time`, `link` FROM `recipes` WHERE `id` = :id AND `deleted` = 0;');
        $findRecipeEdit->bindParam(':id', $id);
        $findRecipeEdit->execute();
        return $findRecipeEdit->fetch();
    }

/**
 * Updates the db to edit the recipe the user has clicked on
 *
 * @param PDO $db
 * @param array $recipeToEdit
 * @return bool
 */
    function editRecipe(PDO $db, array $recipeToEdit): bool {
            $editRecipe = $db->prepare("UPDATE `recipes` SET `recipe` = :editRecipe, `cuisine` = :editCuisine, `time` = :editTime, `link` = :editLink WHERE `recipe` = :oldRecipe LIMIT 1;");
            $editRecipe->bindParam(':oldRecipe', $recipeToEdit['recipe']);
            $editRecipe->bindParam(':editRecipe', $_POST['editRecipe']);
            $editRecipe->bindParam(':editCuisine', $_POST['editCuisine']);
            $editRecipe->bindParam(':editTime', $_POST['editTime']);
            $editRecipe->bindParam(':editLink', $_POST['editLink']);
            return $editRecipe->execute();
    }

/**
 * Updates the db to set the deleted flag and remove the recipe from users screen
 *
 * @param PDO $db
 */
    function deleteRecipe(PDO $db, $id) {
            $deleteRecipe = $db->prepare("UPDATE `recipes` SET `deleted` = 1 WHERE `id` = :id;");
            $deleteRecipe->bindParam(':id', $id);
            return $deleteRecipe->execute();
    }

    function findRecipeName(PDO $db, $id) {
        $findRecipeName = $db->prepare("SELECT `recipe` FROM `recipes` WHERE `id` = :id");
        $findRecipeName->bindParam(':id', $id);
        $findRecipeName->execute();
        return $findRecipeName->fetch();
    }