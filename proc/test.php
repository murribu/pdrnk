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
$args = array(
  'data' => $data,
  'object' => 'podcast'
);
$ret = $pdrnk->insertObject($args);
echo $ret;
*/
//Update a podcast example...
/*$pdrnk = new Pdrnk();

$data = array(
  'po_key' => 1,
  'po_name' => 'Nerdist isn\'t awesome'
);
$args = array(
  'data' => $data,
  'object' => 'podcast'
);
$ret = $pdrnk->updatePodcast($args);
echo $ret;
*/

//Insert an episode example
/*
$pdrnk = new Pdrnk();
$episode = array(
    'ep_name' => 'Test episode',
    'ep_description' => 'This episode was about testing. It was quite boring.',
    'ep_duration' => '1:09:14',
    'ep_explicit' => 'yes',
    'ep_filesize' => '123456789',
    'ep_link' => 'http://murribu.com/episode/1',
    'ep_pubdate' => 'Wed, 02 May 2012 07:00:00 +0000',
    'ep_url' => 'http://www.podtrac.com/pts/redirect.mp3/traffic.libsyn.com/nerdist/Nerdist_201_-_Seth_Green.mp3',
    'ep_po_key' => 1
  );
$args = array(
  'data' => $episode,
  'object' => 'episode'
);
$ret = $pdrnk->insertObject($args);
echo $ret;
*/

//Read a podcast's feed example
/**/
$pdrnk = new Pdrnk();
echo $pdrnk->readPodcastFeed(1);
exit;

$str = "a1:a00:a04";
$arr = explode(":",$str);
print_r($arr);
rsort($arr);
print_r($arr);
$val = 0;
$i = 0;
foreach($arr as $t){
  $t = substr($t,1);
  $val += $t*pow(60,$i++);
  echo $t."\n";
}

echo $val;

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