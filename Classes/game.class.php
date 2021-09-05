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
  public function __construct($id) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://wss2.cex.uk.webuy.io/v3/boxes/' . $id . '/detail');
    $result = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($result,false);
    if ($obj != null) {
        $this->gameName = $obj->response->data->boxDetails[0]->boxName;
        $this->gameSystem = $obj->response->data->boxDetails[0]->categoryFriendlyName;
        $this->gamePrice = $obj->response->data->boxDetails[0]->sellPrice;
        $this->cexID = $obj->response->data->boxDetails[0]->boxId;
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