<?php
    if (isset($_POST['noDelete'], $_POST['yesDelete'])) {
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
    <p>Are you sure you want to permanently delete the recipe: <?php echo $_POST['delete_recipe'] ?></p>
    <form method="post">
        <button type="submit" name="yesDelete" value= "<?php echo $_POST['delete_recipe']?>">Yes</button>
        <button type="submit" name="noDelete">No</button>
    </form>
</body>
</html>


