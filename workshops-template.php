<?php
/**
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
Template Name: Workshops Page
 */
?>

<?php get_header(); ?>
<div class="container cf">
<div class="main_content">
<?php // echo $wp_query->post->post_title; ?>

<h1 class="workshop-page-title">Upcoming Workshops</h1>
<?php  $paged = ( get_query_var('page') ) ? get_query_var('page') : 2; ?>
<?php

	/**
	 * The WordPress Query class.
	 * @link http://codex.wordpress.org/Function_Reference/WP_Query
	 *
	 */
	$args = array(

		
		//Type & Status Parameters
		'post_type'   => 'workshop',


		//Pagination Parameters
		'posts_per_page'         => 3,
		'paged'                  => $paged,
	);

$query = new WP_Query( $args );
?>

<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
	<div class="workshop-div">
	<span class="workshop-meta-data cf">
		<h1 class="workshop-title"><a class="workshop-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<p><?php echo get_the_date(); ?></p>
	</span>
	<div class="workshop-img-div"><?php the_post_thumbnail( array('640', '500') ); ?></div>
	<div class="workshop_info">
		<h3>Date: </h3>
		<h3>Time: </h3>
		<h3>Place: </h3>
		<h3>Audience: </h3>
		<h3>Speakers: </h3>
		<h3>Contact: </h3>
	</div>


	<div class="workshop-user-links">
		<a href="<?php bloginfo('url'); ?>/register">Register</a>
		<a href="<?php bloginfo('url'); ?>/volunteer">Volunteer</a>
		<a href="<?php bloginfo('url'); ?>/register#atendees">Atendees</a>
		<?php if(true) echo '<a class="sponsors-link" href="#">Sponsors</a>'; ?>
	</div>
	</div>
<?php endwhile; ?>
	<?php
	if( $query->max_num_pages > 1 ){ ?>
		<span class="next-link"><?php next_posts_link( ); ?></span>
		<span class="next-link"><?php echo get_next_posts_link( ); ?></span>
		<?php echo get_previous_posts_link();
	}
	?>
<?php endif; ?>
<div class="pag">
<?php
bm_numeric_pagination();
?>
   <?php var_dump($paged); ?>
	
</div>
</div>
</div>
<?php get_footer('workshops'); ?>


