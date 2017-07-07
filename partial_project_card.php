
<article class="project-card above-line drop-shadow">
  //If you DO want an image
  <?php if($hide_image !== true):?>

  <a href="<?=get_the_permalink($pid);?>" class="poster-image-container preload-image-container">
    <?php
    include 'partial_lazy_load_img.php';
   ?>

  </a>
  
  <?php endif;?> <!-- HIDE IMAGE --> 

  <h3>
  <a href="<?=get_the_permalink($pid);?>">
    <div class="callout ">
      <?php if($card_meta):?>
      <span class="meta"><?= $card_meta;?></span>
      <?php endif;?>
      <span class="title"><?= get_the_title($pid);?></span>
      <span class="tagline font-serif"><?= get_post_meta( $pid, 'tagline', true );?></span>
    </div>
  </a>
</h3>
</article>
