<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Dessertstorm
 */

get_header(); ?>

<div class="row">

	<div class="small-12 medium-8 columns">

		<div id="primary" class="content-area single">
			<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'components/content', 'single' ); ?>

				<?php the_post_navigation(); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // End of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->

	</div><!-- .columns -->

	<div class="small-12 medium-4 columns sidebar">

		<?php get_sidebar(); ?>

	</div><!-- .columns -->

</div><!-- .row -->

<?php get_footer(); ?>
