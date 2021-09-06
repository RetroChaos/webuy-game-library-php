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
    if ($id != null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, 'https://wss2.cex.uk.webuy.io/v3/boxes/' . $id . '/detail');
        $result = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result,false);
        if ($obj != null || $obj->response->ack == "Success") {
            $this->gameName = $obj->response->data->boxDetails[0]->boxName;
            $this->gameSystem = $obj->response->data->boxDetails[0]->categoryFriendlyName;
            $this->gamePrice = $obj->response->data->boxDetails[0]->sellPrice;
            $this->cexID = $obj->response->data->boxDetails[0]->boxId;
        } else {
            echo "No results found!\n";
        }
    } else {
        throw new UnexpectedValueException("Can't create a new Game object! Invalid ID: $id", 1);
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
      } else {
          throw new BadFunctionCallException("No ID given!", 3);
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
      return $this->gameName . "|" . $this->gameSystem . "|" . $this->estimatedValue() . "|" . $this->getBoxArt();
  }

  public static function createHeaders() {
      return "Name|System|Estimated Value|Box Art\n";
  }
}