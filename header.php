<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Dessertstorm
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php 
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
$maxheights = json_decode(get_theme_mod('dessertstorm_logo_maxheight'), true);
$maxwidths = json_decode(get_theme_mod('dessertstorm_logo_maxwidth'), true);

$logoMaxWidth = $maxwidths['large'];
if( $logoMaxWidth == '')
{
	$logoMaxWidth = $maxwidths['medium'];
	if( $logoMaxWidth == '')
	{
		$logoMaxWidth = $maxwidths['small'];
		if( $logoMaxWidth == '')
		{
			$logoMaxWidth = '300px';
		}
	}
}
if (substr($logoMaxWidth, -3) === 'rem')
{
	$logoMaxWidth = intval(substr($logoMaxWidth, 0, -3)) * 16; //Convert to px
}
elseif (substr($logoMaxWidth, -2) === 'em')
{
	$logoMaxWidth = intval(substr($logoMaxWidth, 0, -2)) * 16; //Convert to px
}
elseif (substr($logoMaxWidth, -2) === 'px' )
{
	$logoMaxWidth = substr($logoMaxWidth, 0, -2);
}


$logoMaxHeight = $maxheights['large'];
if( $logoMaxHeight  == '')
{
	$logoMaxHeight = $maxheights['medium'];
	if( $logoMaxHeight  == '')
	{
		$logoMaxHeight = $maxheights['small'];
		if( $logoMaxHeight  == '')
		{
			$logoMaxHeight = '300px';
		}
	}
}
if (substr($logoMaxHeight, -3) === 'rem')
{
	$logoMaxHeight = intval(substr($logoMaxHeight, 0, -3)) * 16; //Convert to px
}
elseif (substr($logoMaxHeight, -2) === 'em')
{
	$logoMaxHeight = intval(substr($logoMaxHeight, 0, -2)) * 16; //Convert to px
}
elseif (substr($logoMaxHeight, -2) === 'px' )
{
	$logoMaxHeight = substr($logoMaxHeight, 0, -2);
}

?>
<meta property="og:title" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:description" content="<?php bloginfo( 'description' ); ?>" />
<meta property="og:image" content="<?php echo $image[0]; ?>" />
<meta property="og:image:width" content="<?php echo $logoMaxWidth; ?>">
<meta property="og:image:height" content="<?php echo $logoMaxHeight; ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php echo file_get_contents( get_template_directory() . '/assets/dist/sprite/sprite.svg' ); 


	$fixedBackground = get_theme_mod('austeve_background_fixed', 'fixed');
	$backgrounds = get_theme_mod('austeve_backgrounds', 0);

	if ($fixedBackground == 'fixed') 
	{
	?>


	<div id="background-div" class="fixed">
	<?php
	for ($b = 0; $b < $backgrounds; $b++) {
		echo '<div id="bgImage'.($b+1).'" class="bgImage">&nbsp;</div>';
	}
	?>
	</div>
	
	<div id="page">

<?php 
	}
	else {
		//Scrolling
		?>

	<div id="background-div" class="scrolling">
		<?php
	for ($b = 0; $b < $backgrounds; $b++) {
		echo '<div id="bgImage'.($b+1).'" class="bgImage">&nbsp;</div>';
	}
	?>

		<div id="page">
		<?php
	}

	$menuLayout = get_theme_mod('austeve_menu_layout', 'topbar-right');

	if ($menuLayout == 'topbar-right') 
	{

?>				
		<div data-sticky-container class="header">
			<div class="title-bar" data-sticky data-options="marginTop:0;" style="width:100%">
				<div class="title-bar-left">
					<h1 class="site-title">
						<a href="<?php esc_attr_e( home_url( '/' ) ); ?>" rel="home">
							<?php 
							if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
								the_custom_logo();
							}
							else {
								?>
								<h1>
									<?php
									bloginfo( 'name' );
									?>
								</h1>
								<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
							<?php
							}
			 				?>
						</a>
					</h1>
				</div>

			
				<div class="title-bar-right show-for-medium-only primary-navigation" id="medium-menu-container">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu horizontal' ) ); ?>
				</div>
				<div class="title-bar-right show-for-large primary-navigation" id="large-menu-container">
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu horizontal' ) ); ?>
				</div>
			</div>
		</div>
	    
		<div class="row columns show-for-small-only primary-navigation" id="small-menu-container">
			<ul class="vertical menu" data-accordion-menu>
				<li>
					<a href="#">Menu</a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu vertical' ) ); ?>
				</li>
			</ul>
		</div>
<?php 
	} /* End if ($menuLayout == 'top-bar-right') */
	else if ($menuLayout == 'centered-single')
	{
?>
		<div class="row header centered-layout">
			<div class="small-12 columns">
				<h1 class="site-title">
					<a href="<?php esc_attr_e( home_url( '/' ) ); ?>" rel="home">
						<?php 
						if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
							the_custom_logo();
						}
						else {
							?>
							<h1>
								<?php
								bloginfo( 'name' );
								?>
							</h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<?php
						}
		 				?>
					</a>
				</h1>
			</div>
		</div>
		<div class="row menu-bar centered-layout show-for-medium">
			<div class="small-12 columns">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu horizontal' ) ); ?>
			</div>
		</div>

		<div class="row columns show-for-small-only primary-navigation" id="small-menu-container">
			<ul class="vertical menu" data-accordion-menu>
				<li>
					<a href="#">Menu</a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'menu vertical' ) ); ?>
				</li>
			</ul>
		</div>
<?php 
	} /* End if ($menuLayout == 'centered-single') */
	else if ($menuLayout == 'none')
	{
?>
		<div class="header">
			<div class="title-bar">
				<div class="title-bar-left">
					<h1 class="site-title">
						<a href="<?php esc_attr_e( home_url( '/' ) ); ?>" rel="home">
							<?php 
							if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
								the_custom_logo();
							}
							else {
								?>
								<h1>
									<?php
									bloginfo( 'name' );
									?>
								</h1>
								<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
							<?php
							}
			 				?>
						</a>
					</h1>
				</div>
			</div>
		</div>
<?php		
	}
?>

		<div id="content" class="site-content">
