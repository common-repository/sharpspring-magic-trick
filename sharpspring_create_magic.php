<?php
/*
Plugin Name: SharpSpring Magic Trick
Plugin URI: https://sharpspring.com/blog/pick-a-card-a-magic-trick-demonstrating-behavioral-based-marketing-automation/
Description: A plugin that creates the pages you will need to have the Magic Trick on your own site!
Version: 1.0
Author: SharpSpring, Chris Sharp
Author URI: http://sharpspring.com
License: GPL2v2 or later
*/

//Security check
defined( 'ABSPATH' ) or die( 'Direct access to plugin blocked.' );

//Function to execute when plugin is activated
//Creates the magic trick pages
//Stores the ID of those pages in the sharpspring_create_magic_pages WordPress Option
function sharpspring_create_magic_activate() {
	//Check to see if the options table already exists
	//This would happen if the plugin was deactivated then reactivated
	//If it exists, don't recreate the pages
	$sharpspring_pages = get_option('sharpspring_create_magic_pages');

	//SharpSpring base Magic-Trick Page, make the page if it doesn't exist or is in the trash
	if ((get_post_status($sharpspring_pages['magic-trick']) == FALSE) || (get_post_status($sharpspring_pages['magic-trick']) == 'trash')) {
		$page = array(
		'post_author' => 'SharpSpring',
		'post_title' => 'magic-trick',
		'post_content' => '<p>Use this page to place your opt-in email Form from SharpSpring.<br />You can make it look like ours if you want: <a href="https://sharpspring.com/crazy-egg/">https://sharpspring.com/crazy-egg/</a></p><p>After filling out the form, you should direct them to the Suit page either directly or by an email. The important piece is that the Suit page is only accessible to known, tracked leads in SharpSpring.</p><p>Also, make sure that you have your Tracking Code for this site set up correctly. In your SharpSpring app, go to Settings -> Sites to get the tracking code, or use the SharpSpring Connecter WordPress plugin to place the tracking code on your site.</p>',
		'post_status' => 'publish',
		'post_type' => 'page',
		'post_parent' => 0,
		);

		//Create the page, and get the id of this new page so it can parent the next page
		$magicID = wp_insert_post( $page );
	} else {	 		
		//if the page already exists, just get the ID
		$magicID = $sharpspring_pages['magic-trick'];
	}

	//SharpSpring Suit Page
	if ((get_post_status($sharpspring_pages['suit']) == FALSE) || (get_post_status($sharpspring_pages['suit']) == 'trash')) {
		$imgpath = plugins_url('sharpspring-magic-trick/images/','__FILE__');
		$page_content = '
		    <div class="sharpspring_magic_row">
		        <div class="large-12 columns headers">
		            <h1>Choose A Suit</h1>
		        </div>
		    </div>

			<div class="sharpspring_magic_row">
		        <div class="sharpspring_magic_large-3" style="text-align:center;">
		            <a href="' . home_url('/magic-trick/rank?suit=diamond') . '" style="text-decoration: none !important;"><img src="' . $imgpath . 'diamond.gif"></a>
		        </div>
		        <div class="sharpspring_magic_large-3" style="text-align:center;">
		            <a href="' . home_url('/magic-trick/rank?suit=club') . '" style="text-decoration: none !important;"><img src="' . $imgpath . 'club.gif"</a>
		        </div>
		        <div class="sharpspring_magic_large-3" style="text-align:center;">
		            <a href="' . home_url('/magic-trick/rank?suit=heart') . '" style="text-decoration: none !important;"><img src="' . $imgpath . 'heart.gif"></a>
		        </div>
		        <div class="sharpspring_magic_large-3" style="text-align:center;">
		            <a href="' . home_url('/magic-trick/rank?suit=spade') . '" style="text-decoration: none !important;"><img src="' . $imgpath . 'spade.gif"></a>
	       		</div>
	    	</div>';

		//Create the magic-trick/suit page
		$page = array(
			'post_author' => 'SharpSpring',
			'post_title' => 'suit',
			'post_content' => $page_content,
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_parent' => $magicID,
			);
	
		//Create the page, and get the id of this new page so it can parent the next page
		$suitID = wp_insert_post( $page );
	} else {
		//if the page already exists, just get the ID
		$suitID = $sharpspring_pages['suit'];
	}

	//SharpSpring Rank Page
	if ((get_post_status($sharpspring_pages['rank']) == FALSE) || (get_post_status($sharpspring_pages['rank']) == 'trash')) {
		$page_content ='
	    <div class="sharpspring_magic_row">
	        <div class="large-12 columns headers">
	            <h1>Choose A Rank</h1>
	        </div>
	    </div>

		<div class="sharpspring_magic_row">
	        <div class="large-3 columns" style="text-align:center;">
	            <a href="' . home_url('/magic-trick/thanks?face=jack') . '" style="text-decoration: none !important;" class="sharpspring_magic_rank">J</a>
	        </div>
	        <div class="large-3 columns" style="text-align:center;">
	            <a href="' . home_url('/magic-trick/thanks?face=queen') . '" style="text-decoration: none !important;" class="sharpspring_magic_rank">Q</a>
	        </div>
	        <div class="large-3 columns" style="text-align:center;">
	            <a href="' . home_url('/magic-trick/thanks?face=king') . '" style="text-decoration: none !important;" class="sharpspring_magic_rank">K</a>
	        </div>
	        <div class="large-3 columns" style="text-align:center;">
	            <a href="' . home_url('/magic-trick/thanks?face=ace') . '" style="text-decoration: none !important;" class="sharpspring_magic_rank">A</a>
	        </div>
	    </div>';

		//Create the magic-trick/suit/rank page
		$page = array(
			'post_author' => 'SharpSpring',
			'post_title' => 'rank',
			'post_content' => $page_content,
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_parent' => $magicID,
			);

		//Create the page, and get the id of this new page so it can parent the next page
		$rankID = wp_insert_post( $page );
	} else {	
		//if the page already exists, just get the ID
		$rankID = $sharpspring_pages['rank'];
	}

	//SharpSpring Thanks Page
	if ((get_post_status($sharpspring_pages['thanks']) == FALSE) || (get_post_status($sharpspring_pages['thanks']) == 'trash')) {
		$page_content = '
		<div class="row">
	        <div class="large-12 columns headers">
	            <h1 style="line-height: 4em;">Magic is happening.  Can you feel it?</h1>
	        </div>
	    </div>

	    <div class="row">
	        <div class="12 columns content">
	            <h3 style="font-weight: 400; text-align: center;">Next, check behind your left ear...</h3>
	            <br>
	            <p>&hellip;</p>
	            <br>
	            <h3 style="font-weight: 300; text-align: center;">Ok, don\'t do that - check your email instead.</h3>
	        </div>
	    </div>';

		//Create the magic-trick/suit/rank/thanks page
		$page = array(
			'post_author' => 'SharpSpring',
			'post_title' => 'thanks',
			'post_content' => $page_content,
			'post_status' => 'publish',
			'post_type' => 'page',
			'post_parent' => $magicID,
			);

		//Create the thank you page
		$thanksID = wp_insert_post( $page );
	} else {
		//if the page already exists, just get the ID
		$thanksID = $sharpspring_pages['thanks'];
	}

	//Store page IDs as an array
	$sharpspring_create_magic_pages = array(
		'magic-trick' => $magicID,
		'suit' => $suitID,
		'rank' => $rankID,
		'thanks' => $thanksID,
		);

	//Save the page IDs as a WordPress Option
	update_option('sharpspring_create_magic_pages',$sharpspring_create_magic_pages);

	//Add magic-trick rewrite rules
	sharpspring_magic_rewrite_rules();

	//Flush rewrite rules and recreate them with our magic-trick redirects
	flush_rewrite_rules();
	}

//Steps to take when the plugin is deativated
function sharpspring_create_magic_deactivate() {
	//Will remove the redirects for our magic-trick
	flush_rewrite_rules();
}

//Delete pages stored option data when uninstalled
function sharpspring_create_magic_uninstall() {
	$sharpspring_pages = get_option('sharpspring_create_magic_pages');
	wp_trash_post($sharpspring_pages['suit']);
	wp_trash_post($sharpspring_pages['rank']);
	wp_trash_post($sharpspring_pages['thanks']);
	wp_trash_post($sharpspring_pages['magic-trick']);
	delete_option('sharpspring_create_magic_pages');
}

//Register activation and deactivation actions
register_activation_hook(__FILE__, 'sharpspring_create_magic_activate');
register_deactivation_hook(__FILE__, 'sharpspring_create_magic_deactivate');
register_uninstall_hook(__FILE__, 'sharpspring_create_magic_uninstall');

//Create rules to redirect magic-trick pages
function sharpspring_magic_rewrite_rules() {
	//Get page IDs of our magic pages that were stored in our Options file
	$sharpspring_pages = get_option('sharpspring_create_magic_pages');
	$magic_page = "index.php?page_id=" . "{$sharpspring_pages['magic-trick']}";
	$suit_page = "index.php?page_id=" . "{$sharpspring_pages['suit']}";
	$rank_page = "index.php?page_id=" . "{$sharpspring_pages['rank']}";
	$thanks_page = "index.php?page_id=" . "{$sharpspring_pages['thanks']}";

	//Add the rewrite rules
	add_rewrite_rule('^magic-trick/thanks$',$thanks_page,'top' );
	add_rewrite_rule('^magic-trick/rank$',$rank_page,'top' );
	add_rewrite_rule('^magic-trick/suit$',$suit_page,'top' );
	add_rewrite_rule('^magic-trick/?$',$magic_page,'top' );
}

//Add our rewrite rules if the rules get flushed by something else
add_action('init','sharpspring_magic_rewrite_rules');

//Filter out canonical redirection for our magic trick pages
//This will allow them to be the exact address SharpSpring is looking for
//Without having to modify the automations within your SharpSpring app
//Main use is to prevent WP Permalink structure from adding trailing slashes
//that prevent the SharpSpring tasks from firing without modifying the referring URLs
add_filter('redirect_canonical', 'sharpspring_magic_canonical',10,2);
function sharpspring_magic_canonical($redirect_url, $requested_url) {
	$sharpspring_pages = get_option('sharpspring_create_magic_pages');
	$page_id = get_query_var('page_id');
	if (in_array($page_id, $sharpspring_pages)) {
		return $requested_url;
	} else {
		return $redirect_url;
	}
}

//Load CSS
function add_sharpspring_css() {	
	wp_register_style('sharpspring_create_magic', plugins_url('sharpspring-magic-trick/sharpspring_create_magic.css', '__FILE__'));
	wp_enqueue_style('sharpspring_create_magic');
}
add_action('init','add_sharpspring_css');
?>