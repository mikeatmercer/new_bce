<?php
chdir(dirname(__FILE__));
/*REMOVE IN DEV*/
if( php_sapi_name() !== 'cli' ){die();}
/*END REMOVE IN DEV*/

date_default_timezone_set('UTC');


$current_time = date('c');

$month_ago = date('c',strtotime('-2 months'));

require_once("../../../wp-load.php");
require_once get_template_directory().'/partial_api_key_generator.php';

$wp_base = ABSPATH;

if(file_exists($wp_base.'wp-content/feed_dump/trakt.json')) {
  $old_data = json_decode(file_get_contents($wp_base.'wp-content/feed_dump/trakt.json'),true);

  $start_time = $old_data['last_run'];
  $old_array = $old_data['items'];
} else {
  $old_array = [];
  $start_time = $month_ago;
}

$keys = api_key_generator();
if( !isset($keys['trakt']) || !isset($keys['trakt_username'])) {
  die();
}




$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.trakt.tv/users/".$keys['trakt_username']."/history/?start_at=".urlencode($start_time).'&end_at='.urlencode($current_time).'&limit=50');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "trakt-api-version: 2",
  "trakt-api-key: ".$keys['trakt']
));

$output = curl_exec($ch);

if ($output === FALSE) {
  echo "cURL Error: " . curl_error($ch);
  die();
}
curl_close($ch);

$items = json_decode($output, true);


$items = array_map(function($i){
  if($i['type'] === 'movie') {
    return array(
      'title' => $i['movie']['title'],
      'ID' => $i['movie']['ids']['tmdb'],
      'type' => 'movie',
      'timestamp' => strtotime($i['watched_at']),
      'has_img' => false
    );
  }
  if($i['type'] === 'episode') {
    return array(
      'type' => 'show',
      'title' => $i['episode']['title'],
      'ID' => $i['episode']['ids']['tmdb'],
      'timestamp' => strtotime($i['watched_at']),
      'season' => $i['episode']['season'],
      'number' => $i['episode']['number'],
      'tvdb_ID' => $i['episode']['ids']['tvdb'],
      'show' => array(
        'title' => $i['show']['title'],
        'ID' => $i['show']['ids']['tmdb'],
        'tvdb_ID' => $i['show']['ids']['tvdb']
      ),
      'has_img' => false

    );
  }

},$items);

$items = array_reverse($items);
foreach($items as $t) {
  array_unshift($old_array,$t);
}


$new_array = [];
foreach($old_array as $i) {
  if($i['timestamp'] >= strtotime('-2 months')) {
    $new_array[] = $i;
  }
}

$traktObject = array(
  'last_run' => $current_time,
  'items' => $new_array
);
//echo(json_encode($traktObject));
//var_dump($traktObject);
//die();
if(!file_exists($wp_base.'wp-content/feed_dump/')) {
  mkdir($wp_base.'wp-content/feed_dump', 0777);
}
file_put_contents($wp_base.'wp-content/feed_dump/trakt.json', json_encode($traktObject));
die();

?>
