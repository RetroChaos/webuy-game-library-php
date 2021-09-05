<?php
require "Classes\game.class.php";
require "Classes\search.class.php";

$file_path = "input\input.csv";
$err_count = 0;

if (($handle = fopen($file_path, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
        foreach ($data as $game) {
            try {
                $searchObj = new Search($game);
                $gameObj = new Game($searchObj->getID());
                echo $gameObj->createRow() . "\n";
            }
            catch (BadFunctionCallException $e) {$err_count++;}
        }
    }
    fclose($handle);
}

if ($err_count > 0) {
    echo "Number of errors: $err_count";
}