<?php
/**
 * This class handles the category and author rewrites.
 *
 * @since      0.9.0
 * @package    RankMath
 * @subpackage RankMath\Core
 * @author     Rank Math <support@rankmath.com>
 */

namespace RankMath;

use RankMath\Traits\Hooker;

defined( 'ABSPATH' ) || exit;

/**
 * Rewrite class.
 */
class Rewrite {

	use Hooker;

	/**
	 * The Constructor.
	 */
	public function __construct() {

		if ( Helper::get_settings( 'general.strip_category_base' ) ) {
			$this->filter( 'query_vars', 'query_vars' );
			$this->filter( 'request', 'request' );
			$this->filter( 'category_rewrite_rules', 'category_rewrite_rules' );
			$this->filter( 'term_link', 'no_category_base', 10, 3 );

			add_action( 'created_category', 'RankMath\\Helper::schedule_flush_rewrite' );
			add_action( 'delete_category', 'RankMath\\Helper::schedule_flush_rewrite' );
			add_action( 'edited_category', 'RankMath\\Helper::schedule_flush_rewrite' );
		}

		if ( ! Helper::get_settings( 'titles.disable_author_archives' ) ) {
			if ( ! empty( Helper::get_settings( 'titles.url_author_base' ) ) ) {
				add_action( 'init', 'RankMath\\Rewrite::change_author_base', 4 );
			}

			$this->filter( 'author_link', 'author_link', 10, 3 );
			$this->filter( 'request', 'author_request' );
		}
	}

	/**
	 * Change the url to the author's page.
	 *
	 * @param  string $link            The URL to the author's page.
	 * @param  int    $author_id       The author's id.
	 * @param  string $author_nicename The author's nice name.
	 * @return string
	 */
	public function author_link( $link, $author_id, $author_nicename ) {
		$custom_url = get_user_meta( $author_id, 'rank_math_permalink', true );
		if ( $custom_url ) {
			$link = str_replace( $author_nicename, $custom_url, $link );
		}

		return $link;
	}

	/**
	 * Redirect the old user permalink to the new one.
	 *
	 * @param  array $query_vars Query vars to check for author_name var.
	 *
	 * @return array
	 */
	public function author_request( $query_vars ) {
		global $wpdb;

		if ( ! array_key_exists( 'author_name', $query_vars ) ) {
			return $query_vars;
		}

		$author_id = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key='rank_math_permalink' AND meta_value = %s", $query_vars['author_name'] ) );
		if ( $author_id ) {
			$query_vars['author'] = $author_id;
			unset( $query_vars['author_name'] );
		}

		return $query_vars;
	}

	/**
	 * Remove the rewrite rules.
	 */
	public function remove_rules() {
		$this->remove_filter( 'query_vars', 'query_vars' );
		$this->remove_filter( 'request', 'request' );
		$this->remove_filter( 'category_rewrite_rules', 'category_rewrite_rules' );
		$this->remove_filter( 'term_link', 'no_category_base', 10 );

		remove_action( 'init', 'RankMath\\Rewrite::change_author_base', 4 );
	}

	/**
	 * Change the base for author permalinks.
	 */
	public static function change_author_base() {
		global $wp_rewrite;

		/**
		 * Filter: Change the author base.
		 *
		 * @param string $base The author base.
		 */
		$base = apply_filters( 'rank_math/author_base', sanitize_title_with_dashes( Helper::get_settings( 'titles.url_author_base' ), '', 'save' ) );
		if ( empty( $base ) ) {
			return;
		}

		$wp_rewrite->author_base      = $base;
		$wp_rewrite->author_structure = '/' . $wp_rewrite->author_base . '/%author%';
	}

	/**
	 * Add the redirect var to the query vars if the "strip category bases" option is enabled.
	 *
	 * @param  array $query_vars Query vars to filter.
	 *
	 * @return array
	 */
	public function query_vars( $query_vars ) {
		$query_vars[] = 'rank_math_category_redirect';

		return $query_vars;
	}

	/**
	 * Redirect the original category URL to the new one.
	 *
	 * @param  array $query_vars Query vars to check for redirect var.
	 * @return array
	 */
	public function request( $query_vars ) {
		if ( isset( $query_vars['rank_math_category_redirect'] ) ) {
			$catlink = trailingslashit( get_option( 'home' ) ) . user_trailingslashit( $query_vars['rank_math_category_redirect'], 'category' );
			wp_redirect( $catlink, 301 );
			exit;
		}

		return $query_vars;
	}

	/**
	 * This function was taken and slightly adapted from WP No Category Base plugin by Saurabh Gupta.
	 *
	 * @return array
	 */
	public function category_rewrite_rules() {
		global $wp_rewrite;

		$category_rewrite = [];
		$categories       = $this->get_categories();
		$blog_prefix      = $this->get_blog_prefix();

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {
				$category_nicename = $category->slug;

				if ( $category->parent === $category->cat_ID ) {
					// Recursive recursion.
					$category->parent = 0;
				} elseif ( 0 !== $category->parent ) {
					$parents = get_category_parents( $category->parent, false, '/', true );
					if ( ! is_wp_error( $parents ) ) {
						$category_nicename = $parents . $category_nicename;
					}
					unset( $parents );
				}

				$category_rewrite[ $blog_prefix . '(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$' ]                = 'index.php?category_name=$matches[1]&feed=$matches[2]';
				$category_rewrite[ $blog_prefix . '(' . $category_nicename . ')/' . $wp_rewrite->pagination_base . '/?([0-9]{1,})/?$' ] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
				$category_rewrite[ $blog_prefix . '(' . $category_nicename . ')/?$' ] = 'index.php?category_name=$matches[1]';
			}
			unset( $categories, $category, $category_nicename );
		}

		// Redirect support from Old Category Base.
		$old_base                            = str_replace( '%category%', '(.+)', $wp_rewrite->get_category_permastruct() );
		$old_base                            = trim( $old_base, '/' );
		$category_rewrite[ $old_base . '$' ] = 'index.php?rank_math_category_redirect=$matches[1]';

		return $category_rewrite;
	}

	/**
	 * Remove the category base from the category link.
	 *
	 * @param  string $link     Term link.
	 * @param  object $term     Current Term Object.
	 * @param  string $taxonomy Current Taxonomy.
	 * @return string
	 */
	public function no_category_base( $link, $term, $taxonomy ) {
		if ( 'category' !== $taxonomy ) {
			return $link;
		}

		$category_base = get_option( 'category_base' );
		if ( empty( $category_base ) ) {
			global $wp_rewrite;
			$category_base = trim( str_replace( '%category%', '', $wp_rewrite->get_category_permastruct() ), '/' );
		}

		// Remove initial slash, if there is one (we remove the trailing slash in the regex replacement and don't want to end up short a slash).
		if ( '/' === substr( $category_base, 0, 1 ) ) {
			$category_base = substr( $category_base, 1 );
		}

		$category_base .= '/';

		return preg_replace( '`' . preg_quote( $category_base, '`' ) . '`u', '', $link, 1 );
	}

	/**
	 * Get categories with WPML compatibility.
	 *
	 * @return array
	 */
	private function get_categories() {
		// WPML is present: temporary disable terms_clauses filter to get all categories for rewrite.
		if ( class_exists( 'Sitepress' ) ) {
			global $sitepress;

			remove_filter( 'terms_clauses', [ $sitepress, 'terms_clauses' ] );
			$categories = get_categories( [ 'hide_empty' => false ] );
			add_filter( 'terms_clauses', [ $sitepress, 'terms_clauses' ], 10, 4 );

			return $categories;
		}

		return get_categories( [ 'hide_empty' => false ] );
	}

	/**
	 * Get the blog prefix.
	 *
	 * @return string
	 */
	private function get_blog_prefix() {
		$permalink_structure = get_option( 'permalink_structure' );
		if ( is_multisite() && ! is_subdomain_install() && is_main_site() && 0 === strpos( $permalink_structure, '/blog/' ) ) {
			return 'blog/';
		}

		return '';
	}
}
