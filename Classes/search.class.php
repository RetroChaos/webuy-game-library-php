<?php
class Search {

  // Properties
  private $searchJSON;

  // Methods
  public function __construct($query) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://wss2.cex.uk.webuy.io/v3/boxes?q='. urlencode($query) . '&sortBy=relevance&sortOrder=desc');
    $result = curl_exec($ch);
    curl_close($ch);
    $this->searchJSON = json_decode($result,false);
  }

  public function getID() {
    if ($this->searchJSON->response->data != null) {
        $tmp_gaming_arr = array();
        foreach ($this->searchJSON->response->data->boxes as $key => $value) { 
            if($value->superCatId == 1) {
                array_push($tmp_gaming_arr, $this->searchJSON->response->data->boxes[$key]);
            }
        }
        if (count($tmp_gaming_arr) == 1) {
            return $tmp_gaming_arr[0]->boxId;
        } else {
            echo "\n-- Warning! Mutliple Products returned! Select the correct one from the array:\n";
            foreach ($tmp_gaming_arr as $key => $value) {
                $reponse_name = $value->boxName;
                $reponse_console = $value->categoryFriendlyName;
                echo "[$key] $reponse_name - $reponse_console\n";
            }
            $which_game = readline("Enter the correct product: ");
            while ($which_game > count($tmp_gaming_arr) || $which_game < 0 || is_numeric($which_game) === false) {
                echo "Error: Unrecognised entry. Please enter a number corrisponding to the correct product.\n";
                $which_game = readline("Enter the correct product: ");
                if ($which_game <= count($tmp_gaming_arr) && $which_game >= 0 && is_numeric($which_game) === true) {
                    break;
                }
            }
            return $tmp_gaming_arr[$which_game]->boxId;
        }
    } else {
        throw new BadFunctionCallException("No ID Found!", 2);
    }
  }

}