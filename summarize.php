<?php
/*
PLUGIN NAME: Summarize
DESCRIPTION: Insert a list of latest blog posts using the shortcode <code>[summarize count=&quot;N&quot;]</code> (default is 5) in a semantic hAtom-enabled list. A plaintxt.org experiment for WordPress.
AUTHOR: Radu Vaduva
AUTHOR URI: http://raduvaduva.ro/
VERSION: 0.1b
*/


// Function for our shortcode [summarize]. See readme.txt for details on attributes
function blog_summary_shortcode($attr) {
	// Describes what attributes to parse from shortcode; only 'count'
	extract( shortcode_atts( array(
			// Default values for shortcode attributes
			'count'       =>  '5',
			'grouptag'    =>  'ul',
			'entrytag'    =>  'li',
			'titletag'    =>  'h4',
			'datetag'     =>  'span',
			'commentstag' =>  'span',
			'summarytag'  =>  'div',
		), $attr ) );
	// Queries to populate our loop based on shortcode count attribute
	$r = new WP_Query("showposts=$count&what_to_show=posts&nopaging=0&post_status=publish");
	// Only run if we have posts; can't run this through searches
	if ( $r->have_posts() && !is_search() ) :
		// If we're using a Sandbox-friendly theme . . .
		if ( function_exists('sandbox_body_class') ) {
			// We can't have double hfeed classes, otherwise it won't parse
			$groupclasses = 'xoxo';
		} else {
			// Otherwise, use hfeed to ensure hAtom compliance
			$groupclasses = 'xoxo hfeed';
		}
		// Begin the output for shortcode and inserts in the group tag what classes we have
		$output = '<' . $grouptag . ' class="' . $groupclasses . '">';
		// Begins our loop for returning posts
		while ( $r->have_posts() ) :
			// Sets which post from our loop we're at
			$r->the_post();
			// Allows the_date() with multiple posts within a single day
			unset($previousday);
			// If we're using a Sandbox-friendly theme . . .
			if ( function_exists('sandbox_post_class') ) {
				// Let's use semantic classes with each entry element
				$entryclasses = sandbox_post_class(false);
			} else {
				// Otherwise, use hentry to ensure hAtom compliance
				$entryclasses = 'hentry';
			}
			// Begin entry wrapper and inserts what classes we got from above
			$output .= "\n" . '<' . $entrytag . ' class="' . $entryclasses . '">';
			// Post title
			$output .= "\n" . '<' . $titletag . ' class="entry-title"><a href="' .  get_permalink() . '" title="' . sprintf( __( 'Permalink to %s', 'summarize' ), the_title_attribute('echo=0') ) . '" rel="bookmark">' . get_the_title() . '</a></' . $titletag . '>';
			// Post date with hAtom support
			$output .= "\n" . '<' . $datetag . ' class="entry-date"><abbr class="published" title="' . get_the_time('Y-m-d\TH:i:sO') . '">' . sprintf( __( '%s', 'summarize' ), the_date( '', '', '', false ) ) . '</abbr></' . $datetag . '>';
			// Comments number
			$output .=  "\n" . '<' . $commentstag . ' class="entry-comments"><a href="' . get_permalink() . '#comments" title="' . sprintf( __( 'Comments to %s', 'summarize' ), the_title_attribute('echo=0') ) . '">' . sprintf( __( 'Comments (%s)', 'summarize' ), apply_filters( 'comments_number', get_comments_number() ) ) . '</a></' . $commentstag . '>';
			// Post excerpt with hAtom support
			$output .= "\n" . '<' . $summarytag . ' class="entry-summary">' . "\n" . apply_filters( 'the_excerpt', get_the_excerpt() ) . '</' . $summarytag . '>';
			// Close each post LI
			$output .= "\n" . '</' . $entrytag . '>';
		// Finish the have_posts() query
		endwhile; // while ( $r->have_posts() ) :
		// Close the parent UL
		$output .= "\n" . '</' . $grouptag . '>';
		// Rewinds loop from $r->the_post();
		rewind_posts();
	// End the initial IF statement
	endif; // if ( $r->have_posts() ) :
	// Clears our query to put the loop back where it was
	wp_reset_query(); // $r = new WP_Query()
	// Returns $output to the shortcode
	return $output;
}
load_theme_textdomain('summarize');
// Register the shortcode to the function blog_excerpts_shortcode()
add_shortcode( 'summarize', 'summarize_shortcode' );
?>
