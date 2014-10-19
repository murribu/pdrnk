<?

class Pdrnk{

  private $timeout = 60;
  private $baseurl = "http://rest.pdrnk.murribu.com/";

  function readPodcastFeed($id){
    //$ch
  }

  function getPodcast($args){
    $url = $this->baseurl."podcasts/".intval($args["po_key"]);

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

  function insertPodcast($data){
    /*
    e.g.
    $data = array(
      'po_name' => 'Nerdist',
      'po_feed' => 'http://nerdist.libsyn.com/rss',
      'po_feeddev' => 'http://murribu.com/nerdistrss.xml',
      'po_url' => 'http://nerdist.com'
    );
    */
    $url = $this->baseurl."podcast";

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

  function updatePodcast($data){
    /*
    e.g.
    $data = array(
      'po_key' => 1,
      'po_name' => 'Nerdist is awesome',
    );
    */
    $url = $this->baseurl."podcast";

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

}

?>