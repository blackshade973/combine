<?php 

use PHPUnit\Framework\TestCase;
include("constantes.php");
include("my_db.class.php");
require("deposit.class.php");
include("planet.class.php");

final class planetTest extends TestCase
{
    public function testCreatePlanet(): void
    {
		$planet = new planet();
		$planet->name = "test";
		$planet->size = 2;
		$planet->type = 3;	
        $this->assertTrue($planet->planet_create());
    }

   public function testUpdatePlanet(): void
    {
		$planet = new planet();
		$planet->name = "test2";
		$planet->size = 5;
		$planet->type = 3;	
        $this->assertTrue($planet->planet_update(1));
    }

    public function testDeletePlanet(): void
    {
			$planet = new planet(1);
			$this->assertTrue($planet->planet_delete());
    }
}
?>