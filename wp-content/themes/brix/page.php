<?php
get_header();

if ( !post_password_required() ){
	if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<main class="site-main" role="main">
			<?php the_content(); ?>
			<?php if (get_field('hero_section')): ?>
					<?= get_template_part('templates/hero_section'); ?>
			<?php endif; ?>
			<?php if (have_rows('page_sections')) : ?>
				<?php while (have_rows('page_sections')) : the_row(); ?>
					<?php get_template_part('templates/section', get_row_layout()); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</main>

	<?php endwhile;
} else {
	echo get_the_password_form();
}

get_footer(); ?>
