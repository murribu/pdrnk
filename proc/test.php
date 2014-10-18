<?
$url = "http://rest.pdrnk.murribu.com/podcast";

$data = array('po_name'=>'Nerdist', 'po_feed' => 'http://nerdist.libsyn.com/rss', 'po_feeddev' => 'http://murribu.com/nerdistrss.xml', 'po_url' => 'http://nerdist.com');


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
$return = curl_exec($ch);
curl_close($ch);

echo $return;
?>