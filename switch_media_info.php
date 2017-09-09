<?php

function artistNames($i) {

 if(count($i) === 1) {
  return '<span class="name">'.$i[0].'</span>';
 }
 $string = '';
 foreach($i as $k => $n) {
  $sep = ', ';
  if($k === 0) {
   $sep = '';
  }
  if($k === count($i) - 1) {
   $sep = ' & ';
  }
  $string .= $sep.'<span class="name">'.$n."</span>";
 }
 return $string;
}

function title_formatter($title,$classString ='') {
 if(strlen($title) >= 40) {
  $long_title = 'long-title';
  $title = substr($title,0,30).'...';
 }
 if(strlen($title) < 18) {
  $long_title = 'short-title';
 }
 return '<h2 class="'.$long_title.' '.$classString.'">'.$title.'</h2>';

}

function book_status_maker($i) {
 if(!empty($i['percent'])) {
  return 'Finished '.$i['percent'].'%';
 }
 if($i['status'] === 'read') {
  return 'Finished reading';
 }
 if($i['status'] === 'currently-reading') {
  return 'Started reading';
 }

}

function switch_media_info($i) {
 switch($i['type']):
  case 'movie':
  ?> <div class="extra font-sans">Watched</div> <?php
 echo title_formatter($i['title']);

  break;

  case 'episode':
  ?> <div class="extra font-sans">Watched</div> <?php
  echo title_formatter( $i['title'],'single');
  ?>
  <div class="show-title font-sans"><?= $i['show']['title']; ?></div>
  <?php
  break;

  case 'show':
  ?>
  <div class="extra font-sans">Watched <?= $i['bingeCount'];?> episodes</div>
  <?php
  echo title_formatter($i['show']['title']);
  break;

  case 'album':
  ?> <div class="extra font-sans">Listened to</div> <?php
   echo title_formatter($i['album']['title']);
   ?>
   <h3 class="byline"><?=  'by '.artistNames($i['album']['artists']);?></h3>
   <?php
  break;

  case 'track':

  ?>
<?php
 if($i['listenCount'] > 1) {
  if($i['listenCount'] > 3) {
   $s = 's';
  }
  ?>
 <div class="extra font-sans">
 <?= $i['listenCount']-1;?> repeat<?= $s;?>
 </div>

  <?php
} else {
  ?> <div class="extra font-sans">Listened to</div> <?php
}
   echo title_formatter($i['title'], 'single');
   ?>
   <h3 class="byline"><?=  'by '.artistNames($i['album']['artists']);?></h3>
   <?php
 break;

 case 'book':
 ?>


<div class="extra font-sans"><?= book_status_maker($i);?></div>
<?= title_formatter($i['title']);?>
<h3 class="byline"><?=  'by '.artistNames($i['authors']);?></h3>

<?php

 endswitch;
}



?>
