<?php
class Game {

  // Properties
  public $gameName;
  public $gameSystem;
  public $gamePrice;
  public $gameRating;
  public $gamePublisher;
  protected $cexID;
  protected $gameBoxArt;

  // Methods
  public function __construct($query) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://wss2.cex.uk.webuy.io/v3/boxes?q='. urlencode($query) . '&sortBy=relevance&sortOrder=desc');
    $result = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($result,false);
    if ($obj->response->data != null) {
        if (count($obj->response->data->boxes) == 1) {
            $box = $obj->response->data->boxes[0];
            $this->gameName = $box->boxName;
            $this->gameSystem = $box->categoryFriendlyName;
            $this->gamePrice = $box->sellPrice;
            $this->cexID = $box->boxId;
            $this->gameBoxArt = $box->imageUrls->large;
        } else {
            echo "\n-- Warning! Mutliple Products returned! Select the correct one from the array:\n";
            foreach ($obj->response->data->boxes as $key => $value) {
                $reponse_name = $value->boxName;
                $reponse_console = $value->categoryFriendlyName;
                echo "[$key] $reponse_name - $reponse_console\n";
            }
            $which_game = (int)readline("Enter the correct product: ");
            while ($which_game > count($obj->response->data->boxes) || $which_game < 0 || gettype($which_game) != "integer") {
                echo "Error: Unrecognised entry. Please enter a number corrisponding to the correct product.\n";
                $which_game = (int)readline("Enter the correct product: ");
                if ($which_game <= count($obj->response->data->boxes) && $which_game >= 0 && gettype($which_game) == "integer") {
                    break;
                }
            }
            $box = $obj->response->data->boxes[$which_game];
            $this->gameName = $box->boxName;
            $this->gameSystem = $box->categoryFriendlyName;
            $this->gamePrice = $box->sellPrice;
            $this->cexID = $box->boxId;
            $this->gameBoxArt = $box->imageUrls->large;
        }
    } else {
        echo "No results found!";
    }
  }

  public function downloadBoxArt() {
      if ($this->cexID != null) {
        $ch = curl_init($this->gameBoxArt);
        $fp = fopen('img/' . $this->cexID . '.jpg', 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
      }
  }

  public function getBoxArt() {
      return "img/" . $this->cexID . ".jpg";
  }

  public function estimatedValue() {
      $est = $this->gamePrice * 1.25;
      $est = number_format($est, 2);
      $est = "£".$est;
      return $est;
  }

  public function createRow(){
      return $this->gameName . "," . $this->gameSystem . "," . $this->estimatedValue() . "," . $this->getBoxArt();
  }
}