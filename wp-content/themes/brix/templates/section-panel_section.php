<?php
  $layout = get_sub_field('section_layout')['layout'];
  $img_pos = get_sub_field('section_layout')['image_position'];
  $cta = get_sub_field('cta');
  ?>

<section class="panel-section <?= $layout . ' ' . $img_pos; ?>">
  <div class="content-width horiz x2 <?php if ($layout == 'basic'): echo 'less-wide'; endif; ?>">
    <div class="content-block">
      <h2 class="heading margins-off"><?= get_sub_field('heading'); ?></h2>
      <?php if (get_sub_field('body_copy')): ?>
        <div class="body-copy body"><?= get_sub_field('body_copy'); ?></div>
      <?php endif; ?>
      <?php if (have_rows('list_items_top')): ?>
        <div class="list-container top">
          <ul>
            <?php while(have_rows('list_items_top')): the_row(); ?>
              <li class="list-item body"><?= get_sub_field('list_item'); ?></li>
            <?php endwhile; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if (have_rows('list_items_bottom')): ?>
        <div class="list-container bottom">
          <ul>
            <?php while(have_rows('list_items_bottom')): the_row(); ?>
              <li class="list-item body"><?= get_sub_field('list_item'); ?></li>
            <?php endwhile; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if ($cta): ?>
        <a class="btn uppercase" href="<?= $cta['url']; ?>"><?= $cta['title']; ?></a>
      <?php endif; ?>
    </div>
    <div class="image-block">
      <div class="main-image">
        <img src="<?= wp_get_attachment_image_src( get_sub_field('main_image'), 'large')[0]; ?>" alt="">
      </div>
      <?php if(get_sub_field('secondary_image')): ?>
        <div class="secondary-image">
          <img src="<?= wp_get_attachment_image_src( get_sub_field('secondary_image'), 'large')[0]; ?>" alt="">
        </div>
      <?php endif; ?>
    </div>
  </div>


</section>
