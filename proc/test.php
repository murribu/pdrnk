<?
require_once("firebase-php-master/firebaseLib.php");

$fb = new Firebase('https://pdrnk.firebaseio.com');

//refactor mysql rest

$podcasts = json_decode($fb->get('podcasts/'));

foreach($podcasts as $k=>$p){
  $url = $p->feeddev;
  $str = file_get_contents($url);
  $str = str_replace("itunes:","itunes_",$str);
  $content = simplexml_load_string($str);
  $i = 0;
  $episodes = array();
  foreach($content->channel->item as $item){
    $guid = (string)$item->guid;
    if ($guid != ""){
      $exists = $fb->get("episodes/$k/$guid");
      if($exists == "null"){
        $pod["pubdate"] = (string)$item->pubDate;
        $pod["name"] = (string)$item->title;
        $pod["description"] = (string)$item->description;
        $pod["duration"] = (string)$item->itunes_duration;
        $pod["explicit"] = (string)$item->itunes_explicit;
        $pod["link"] = (string)$item->link;
        foreach($item->itunes_image->Attributes() as $key=>$val){
          if ($key == "href")
            $pod["img"] = (string)$val;
        }
        foreach($item->enclosure->Attributes() as $key=>$val){
          if($key == "length")
            $pod["filesize"] = (string)$val;
          if($key == "url")
            $pod["url"] = (string)$val;
        }
        $episodes[$guid] = $pod;
      }
    }
  }
  
  $fb->update("episodes/$k",$episodes);
}
?>