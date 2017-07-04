<?php
/**
 * Template Name: Blog Landing Page
 */
?>
<?php include_once 'header.php';?>

<?php $landing_post = $post;?>

<?php include_once 'partial_landing_page_header.php';?>
<div class="bl post-list">
<?php
//GET THE POSTS
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
  'post_type' 		=> 'post',
  'posts_per_page' => 24,
  'paged' => $paged
);
query_posts($args);
while ( have_posts() ) : the_post(); ?>
<?php
if(!has_post_thumbnail()) {
 $class_no_thumbnail = 'no_thumbnail';
}
?>

<article class="<?= $class_no_thumbnail;?> bl post  clearfix">
  <?php
  if(has_post_thumbnail()):?>
  <?php
  $all_images = get_all_image_sizes(get_post_thumbnail_id());
  ?>
  <a class="thumbnail-container" href="<?= get_the_permalink();?>">
    <?php echo postimage_shortcode(array(
      'type' => 'normal',
      'id' => get_post_thumbnail_id()
    ));?>
  </a>
  <?php endif; ?>
  <a class="copy no-underline <?= $class_no_thumbnail;?>" href="<?= get_the_permalink();?>">
    <h1 class="title"><?= get_the_title();?></h1>
    <div class="excerpt type-smaller"><?= get_the_excerpt();?></div>
    <div class="date meta">Published on <?= get_the_date('M j Y'); ?></div>
  </a>

</article>


<?php endwhile;?>
</div>

<?php include_once 'partial_landing_page_pagination.php';?>


<?php include_once 'footer.php';?>
