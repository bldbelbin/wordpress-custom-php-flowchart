<?php
/*
* Template Name: Negotiation Status
* description: >- Page with custom fields
*/

get_header(); ?>

<?php $layout_class = shapely_get_layout_class(); ?>
<div class="row">

	<div id="primary" class="col-xs-12 col-sm-9 <?php echo esc_attr( $layout_class ); ?>">

<!-- Entry Title Added in due to Custom Templating -->
		<h1 class="entry-title">
			<?php echo wp_trim_words( get_the_title(), 9 ); ?>
		</h1>

<!-- Custom Field for the text before Custom Fields Diagram -->
		<div class="container-fluid" id="intro">
			<?php the_field('section_intro'); ?>
		</div>

<!-- Diagram Section with SVG -->
<section class="container" id="negotiation">

		<?php if(get_field('negotiation_flow')): ?>

				<?php

				$i = 0;

				//predefined column classes
				$allowed_classnames = array(
					1 => 'main-box',
					2 => 'inner-box',
					3 => 'inner-box-3',
					4 => 'inner-box-2',
				);

				while( has_sub_field('negotiation_flow')): ?>

				<div class="container__sources">

					<?php

					// Counting number or rows to determine which is the last row
					$num_of_rows = count( get_field( 'negotiation_flow' ) );

					// If its the first row then give it class Treaty
					if($i == 0) {

						$classname_to_use = 'treaty';

						// Else assign rotating class names
					} else {

					// set a default classname
					$classname_to_use = $allowed_classnames[1];

					// check if the $number_of_cols exist in the predefined classnames

					$class_num = $i % count($allowed_classnames);

					if($class_num == 0) { $class_num = 4;}

					if ( array_key_exists( $class_num , $allowed_classnames ) ) {
						// set the classname to be used
						$classname_to_use = $allowed_classnames[$class_num];
					}
				}

					if(get_sub_field('section')):

						$x = 0;

						while( has_sub_field('section')):
							$number_of_cols = count( get_sub_field( 'section_text' ) );?>
								<!-- Assign class name for color after sources -->
								<svg class="horizontal-media"<?php if($x == $number_of_cols-1) echo " style='display:none';" ?> viewbox="0 0 10 100">
									<line x1="5" x2="5" y1="0" y2="100"/>
								</svg>
								<svg class="horizontal"<?php if($x == $number_of_cols-1) echo " style='display:none';" ?> viewbox="0 0 30 100">
									<line x1="0" y1="75" x2="100" y2="75" />
								</svg>
							<div class="sources <?php echo esc_attr( $classname_to_use ); ?>">
								<h3><?php the_sub_field('section_text'); ?></h3>
							</div>
						<?php
						$x = $x + 1;
					endwhile; ?>
				<?php endif; ?>
			</div>
			<!-- If its the last row don't display the SVG -->
			<svg <?php if($i == $num_of_rows-1) echo " style='display:none';" ?> viewbox="0 0 10 100">
				<line x1="5" x2="5" y1="0" y2="100"/>
			</svg>
			<!-- Increase to get different rows -->
		<?php $i = $i + 1; endwhile; ?>
<?php endif; ?>

</section>

<!-- Rest of the normal template -->
<?php
while ( have_posts() ) :
	the_post();

	get_template_part( 'template-parts/custom-content', 'negotiation-status' );

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;

endwhile; // End of the loop.

?>
</div><!-- #primary -->

<!-- Aside on the right side -->

<div class="col-xs-12 col-sm-3">
	<aside id="secondary">
		<!-- Image Widget -->

		<?php if (get_field('sidebar_image')): ?>
			<div class="side-image">
				<img src="<?php the_field('sidebar_image'); ?>" />
			</div>

		<?php else: ?>

		<?php endif; ?>

		<?php if ( is_active_sidebar( 'custom_side_widget' ) ) : ?>
			<?php dynamic_sidebar( 'custom_side_widget' ); ?>
		<?php endif; ?>
	</aside>
</div>

<?php
if ( 'sidebar-right' == $layout_class ) :
	get_sidebar();
endif;
?>
</div>
<?php
get_footer();
