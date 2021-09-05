<?php
require "Classes\game.class.php";
require "Classes\search.class.php";

$games = array("Persona 3 FES", "Clock Tower 3", "Dark Cloud", "Ratchet & Clank PS2", "Resident Evil 3");

foreach ($games as $game) {
    $searchObj = new Search($game);
    $gameObj = new Game($searchObj->getID());
    echo $gameObj->createRow() . "\n";
}