<?

class Pdrnk{

  private $timeout = 60;
  private $baseurl = "http://rest.pdrnk.murribu.com/";

  function getObjects($args){
    $object = $args['object'];
    if (isset($args['search'])){
      foreach($args['search'] as $key=>$value) {
        $params[] = "$key=" . $value;
      }
      $q = implode('&', $params);
    }
    $pk = $args['pk'];
    if ($pk != ""){
      $url = $this->baseurl.$object."s/".intval($pk);
    }else{
      $url = $this->baseurl.$object."s?".$q;
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $return = curl_exec($ch);
    curl_close($ch);

    return $return;
  }

  function insertObject($args){
    /*
    e.g.
    $args = array(
      'data' = array(
        'po_name' => 'Nerdist',
        'po_feed' => 'http://nerdist.libsyn.com/rss',
        'po_feeddev' => 'http://murribu.com/nerdistrss.xml',
        'po_url' => 'http://nerdist.com'
      ),
      'object' = 'podcast'
    );
    */
    $data = $args['data'];
    $object = $args['object'];
    $url = $this->baseurl.$object;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    $return = curl_exec($ch);
    curl_close($ch);

    return $return;
  }

  function updateObject($args){
    /*
    e.g.
    $args = array(
      'data' => array(
        'po_key' => 1,
        'po_name' => 'Nerdist is awesome',
      ),
      'table' => 'podcast'
    );
    */
    $data = $args['data'];
    $table = $args['table'];
    $url = $this->baseurl.$table;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    $return = curl_exec($ch);
    curl_close($ch);

    return $return;
  }
  function readPodcastFeed($pk){
    $ret = "";
    
    $args = array(
      'object' => 'podcast',
      'pk' => $pk
    );
    
    $podcast = json_decode($this->getObjects($args));

    if ($podcast->po_feeddev != ""){
      $str = file_get_contents($podcast->po_feeddev);
      $str = str_replace("itunes:","itunes_",$str);
      $content = simplexml_load_string($str);
      $episodes = array();
      $ep = array();
      foreach($content->channel->item as $item){
        $guid = (string)$item->guid;
        if ($guid != ""){
          //$exists = $fb->get("episodes/$k/$guid");
          $args = array(
            'object' => 'episode',
            'ep_guid' => $guid,
            'ep_po_key' => $podcast->po_key,
            'search' => array(
              'ep_guid' => $guid
            )
          );
          $exists = $this->getObjects($args);
          if($exists == "[]"){
            $ep["ep_pubdate"] = (string)$item->pubDate;
            $ep["ep_name"] = (string)$item->title;
            $ep["ep_description"] = (string)$item->description;
            $ep["ep_duration"] = (string)$item->itunes_duration;
            $ep["ep_explicit"] = (string)$item->itunes_explicit;
            $ep["ep_link"] = (string)$item->link;
            foreach($item->itunes_image->Attributes() as $key=>$val){
              if ($key == "href")
                $ep["ep_img"] = (string)$val;
            }
            foreach($item->enclosure->Attributes() as $key=>$val){
              if($key == "length")
                $ep["ep_filesize"] = (string)$val;
              if($key == "url")
                $ep["ep_url"] = (string)$val;
            }
            $ep['ep_guid'] = $guid;
            $ep['ep_po_key'] = $podcast->po_key;
            $args = array(
              'data' => $ep,
              'object' => 'episode'
            );
            $ret .= $this->insertObject($args)."\n";
          }else{
            //This will stop the proc from checking once it sees a guid that is already in the db
            break;
          }
        }
      }
    }

    return $ret;
  }

}

?>