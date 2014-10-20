<?
$testval = "2:34";
$arr = explode(":",$testval);
rsort($arr);
$val = 0;
$i = 0;
print_r($arr);
foreach($arr as $t){
  $val += $t*pow(60,$i++);
}
echo $val;
?>