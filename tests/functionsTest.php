<?php

require '../functions.php';

use PHPUnit\Framework\TestCase;

class functionsTest extends TestCase
{
    function testSuccessCreateRecipeCards()
    {
$expected = "<section class= 'recipe_card'><h2>eggs</h2><h3>Cuisine: all</h3><h3>Time (mins): 1</h3><a href= https://www.google.com/>Link to recipe</a></section>";

        $inputa = [['recipe' => 'eggs', 'cuisine' => 'all', 'time' => '1', 'link' => 'https://www.google.com/']];

        $case = createRecipeCards($inputa);

        $this->assertEquals($expected, $case);
    }

    function testSuccessCreateRecipeCards2()
    {
        $expected = 'No available recipes';

        $inputa = [];

        $case = createRecipeCards($inputa);

        $this->assertEquals($expected, $case);
    }

    function testMalformedCreateRecipeCards()
    {
        $inputa = 'hello';

        $this->expectException(TypeError::class);

        $case = createRecipeCards($inputa);
    }

    function testSuccessLinkValidation()
    {
        $expected = 'ah';

        $inputa = '     \ah\     ';

        $case = linkValidation($inputa);

        $this->assertEquals($expected, $case);
    }
}
