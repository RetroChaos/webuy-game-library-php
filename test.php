<?php
require "Classes\game.class.php";
require "Classes\search.class.php";

$file_path = "input\input.csv";
if (!file_exists('output')) {
    mkdir('output', 0777, true);
}
$output_filename = "output\output.csv";
$err_count = 0;
$err_lines = "";
$output = "";

if (($handle = fopen($file_path, "r")) !== FALSE) {
    $output .= Game::createHeaders();
    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
        foreach ($data as $game) {
            try {
                $searchObj = new Search($game);
                $gameObj = new Game($searchObj->getID());
                $output .= $gameObj->createRow() . "\n";
                try {
                    $gameObj->downloadBoxArt();
                } catch (BadFunctionCallException $e) { $err_count++;}
            } catch (BadFunctionCallException $e) {
                $err_count++;
                $err_lines .= " - $game\n";
            }
        }
    }
    fclose($handle);
}

file_put_contents($output_filename, $output);


if ($err_count > 0) {
    echo "\nNumber of errors: $err_count\n";
    echo "Erroring lines:\n$err_lines";
}