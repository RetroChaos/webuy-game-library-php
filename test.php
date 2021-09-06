<?php
require "Classes\game.class.php";
require "Classes\search.class.php";

$file_path = "input\input.csv";
$output_filename = "output\output.csv";
$err_count = 0;
$output = "";

if (($handle = fopen($file_path, "r")) !== FALSE) {
    $output .= Game::createHeaders();
    while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
        foreach ($data as $game) {
            try {
                $searchObj = new Search($game);
                $gameObj = new Game($searchObj->getID());
                $output .= $gameObj->createRow() . "\n";
                try {
                    $gameObj->downloadBoxArt();
                } catch (BadFunctionCallException $e) { $err_count++;}
            } catch (BadFunctionCallException $e) {$err_count++;}
        }
    }
    fclose($handle);
}

file_put_contents($output_filename, $output);


if ($err_count > 0) {
    echo "Number of errors: $err_count";
}