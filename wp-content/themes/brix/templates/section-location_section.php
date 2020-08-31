<?php
  $cta = get_sub_field('cta_button');
?>

<section class="location-section">
  <div class="horiz">
    <figure class="map-image">
      <img src="<?= wp_get_attachment_image_src( get_sub_field('map_image'), 'large')[0]; ?>" alt="">
    </figure>
    <article class="content container">
      <h2><?= get_sub_field('heading'); ?></h2>
      <p class="body-copy body"><?= get_sub_field('body_copy'); ?></p>
      <?php if ($cta): ?>
        <a class="btn uppercase" href="<?= $cta['url']; ?>"><?= $cta['title']; ?></a>
      <?php endif; ?>
    </article>
  </div>
</section>
