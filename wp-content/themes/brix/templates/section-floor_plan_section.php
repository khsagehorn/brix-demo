<?php
  $details = $images = '';
  $i = 0;
  $cta = get_sub_field('cta_button');
  while(have_rows('floor_plans')){
    the_row();
    $details .= '<li id="plan-detail-'. $i .'" class="plan-details">'. get_sub_field('plan_details'). '</li>';
    $images .= '<figure id="plan-image-'. $i .'" class="plan-image"><img src="'. wp_get_attachment_image_src( get_sub_field('plan_image'), 'large')[0]. '"></figure>';
  }

 ?>

<section class="floor-plan-section">
  <div class="content-width horiz x2">
    <div class="content">
      <h2 class="text-left"><?= get_sub_field('heading'); ?></h2>
      <?php if(have_rows('floor_plans')): ?>
        <ul id="details" class="layouts">
          <?= $details; ?>
        </ul>
      <?php endif; ?>
      <?php if ($cta): ?>
        <a class="btn secondary uppercase" href="<?= $cta['url']; ?>"><?= $cta['title']; ?></a>
      <?php endif; ?>
    </div>
    <div class="images margins-off">
      <?php if(have_rows('floor_plans')): ?>
        <div id="images" class="image-container">
          <?= $images; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
