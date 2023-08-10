<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.77' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'nouislider', get_stylesheet_directory_uri() . '/css/nouislider.css', array(), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'flaticon', get_stylesheet_directory_uri() . '/css/flaticon.css');
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function custom_scripts() {
	wp_enqueue_script( 'main', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION );
	wp_enqueue_script( 'nouislider', get_stylesheet_directory_uri() . '/js/nouislider.min.js', array('jquery'), CHILD_THEME_ASTRA_CHILD_VERSION );
}
add_action( 'wp_enqueue_scripts', 'custom_scripts');


// -------------------- load more -------------
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');

function load_more_posts()
{
    $page = $_POST['page'];
    // $destinations = array(
    //     'post_type' => 'destination',
    //     'posts_per_page' => 1,
    //     'paged' => $page,
    // );
	$destinations = array(
        'post_type' => 'product',
		'posts_per_page' => 1,
		'paged' => $page,
    );


    $loop = new WP_Query($destinations);
    ob_start();
    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
	<!-- Your post markup here -->

	<div class="product-box">
		<a href="<?= get_permalink() ?>">
			<?php $thumbnail_url =  get_the_post_thumbnail_url(get_the_ID(), 'full');
						?>
			<img src="<?php echo $thumbnail_url; ?>" alt="Featured Image">
			<div class="content-box">
				<div class="place-name">
					<p><?php the_title(); ?></p>
				</div>
				<!-- <div class="content">
					<p><?php include(get_template_directory() . '/content-loop.php'); ?></p>
				</div> -->
			</div>
			<a class="post-link" href="<?= get_permalink()?>">
				<div><img src="<?= get_template_directory_uri()?>/img/icons/botao.png " alt=""></div>
			</a>
		</a>
	</div>

<?php
        }
        wp_reset_postdata();
    }
    $response = ob_get_clean();
    echo $response;
    wp_die();
}