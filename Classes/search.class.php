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
        if (count($this->searchJSON->response->data->boxes) == 1) {
            return $this->searchJSON->response->data->boxes[0]->boxId;
        } else {
            echo "\n-- Warning! Mutliple Products returned! Select the correct one from the array:\n";
            foreach ($this->searchJSON->response->data->boxes as $key => $value) {
                $reponse_name = $value->boxName;
                $reponse_console = $value->categoryFriendlyName;
                echo "[$key] $reponse_name - $reponse_console\n";
            }
            $which_game = (int)readline("Enter the correct product: ");
            while ($which_game > count($this->searchJSON->response->data->boxes) || $which_game < 0 || gettype($which_game) != "integer") {
                echo "Error: Unrecognised entry. Please enter a number corrisponding to the correct product.\n";
                $which_game = (int)readline("Enter the correct product: ");
                if ($which_game <= count($this->searchJSON->response->data->boxes) && $which_game >= 0 && gettype($which_game) == "integer") {
                    break;
                }
            }
            return $this->searchJSON->response->data->boxes[$which_game]->boxId;
        }
    } else {
        echo "No results found!";
    }
  }

}