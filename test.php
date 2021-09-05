<?php
require "Classes\game.class.php";

$games = array("Persona 3 FES", "Clock Tower 3", "Dark Cloud", "Ratchet & Clank PS2", "Resident Evil 3");

foreach ($games as $game) {
    $gameObj = new Game($game);
    $gameObj->downloadBoxArt();
    echo $gameObj->createRow() . "\n";
}