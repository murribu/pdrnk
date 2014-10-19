<?
require_once("pdrnk.php");

/*
//Insert a podcast example...
$pdrnk = new Pdrnk();
$data = array(
  'po_name' => 'Nerdist',
  'po_feed' => 'http://nerdist.libsyn.com/rss',
  'po_feeddev' => 'http://murribu.com/nerdistrss.xml',
  'po_url' => 'http://nerdist.com'
);
$ret = $pdrnk->insertPodcast($data);
echo $ret;
*/

//Read a podcast's feed example


//Update a podcast example...
/*$pdrnk = new Pdrnk();

$data = array(
  'po_key' => 1,
  'po_name' => 'Nerdist isn\'t awesome'
);

$ret = $pdrnk->updatePodcast($data);
echo $ret;
*/

//Insert an episode example

exit;

	$settings = array(
		'oauth_access_token' => $r["mt_twitter_oauth_token"],
		'oauth_access_token_secret' => $r["mt_twitter_oauth_token_secret"],
		'consumer_key' => CONSUMER_KEY,
		'consumer_secret' => CONSUMER_SECRET
	);
	$twitter = new TwitterAPIExchange($settings);



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