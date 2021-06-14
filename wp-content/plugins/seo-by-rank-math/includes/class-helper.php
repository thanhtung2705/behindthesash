<?php
/**
 * Helper Functions.
 *
 * @since      0.9.0
 * @package    RankMath
 * @subpackage RankMath\Core
 * @author     Rank Math <support@rankmath.com>
 */

namespace RankMath;

use RankMath\Helpers\Api;
use RankMath\Helpers\Attachment;
use RankMath\Helpers\Conditional;
use RankMath\Helpers\Choices;
use RankMath\Helpers\Post_Type;
use RankMath\Helpers\Options;
use RankMath\Helpers\Taxonomy;
use RankMath\Helpers\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * Helper class.
 */
class Helper {

	use Api, Attachment, Conditional, Choices, Post_Type, Options, Taxonomy, WordPress;

	/**
	 * Replace `%variables%` with context-dependent value.
	 *
	 * @param  string $content The string containing the %variables%.
	 * @param  array  $args    Context object, can be post, taxonomy or term.
	 * @param  array  $exclude Excluded variables won't be replaced.
	 * @return string
	 */
	public static function replace_vars( $content, $args = [], $exclude = [] ) {
		$replacer = new Replace_Vars();

		return $replacer->replace( $content, $args, $exclude );
	}

	/**
	 * Register extra %variables%. For developers.
	 *
	 * @codeCoverageIgnore
	 *
	 * @param  string $var       Variable name, for example %custom%. '%' signs are optional.
	 * @param  mixed  $callback  Replacement callback. Should return value, not output it.
	 * @param  array  $args      Array with additional title, description and example values for the variable.
	 *
	 * @return bool Whether the replacement function was succesfully registered.
	 */
	public static function register_var_replacement( $var, $callback, $args = [] ) {
		return Replace_Vars::register_replacement( $var, $callback, $args );
	}

	/**
	 * Get midnight time for the date variables.
	 *
	 * @param  int $time Timestamp of date.
	 * @return int
	 */
	public static function get_midnight( $time ) {
		if ( is_numeric( $time ) ) {
			$time = date( 'Y-m-d H:i:s', $time );
		}
		$date = new \DateTime( $time );
		$date->setTime( 0, 0, 0 );

		return $date->getTimestamp();
	}

	/**
	 * Extract URL part.
	 *
	 * @param  string $url  The URL to parse.
	 * @param  string $part The URL part to retrieve.
	 * @return string The extracted URL part.
	 */
	public static function get_url_part( $url, $part ) {
		$url_parts = wp_parse_url( $url );

		if ( isset( $url_parts[ $part ] ) ) {
			return $url_parts[ $part ];
		}

		return '';
	}

	/**
	 * Get current page URL.
	 *
	 * @param  bool $ignore_qs Ignore query string.
	 * @return string
	 */
	public static function get_current_page_url( $ignore_qs = false ) {
		$link = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$link = ( is_ssl() ? 'https' : 'http' ) . $link;

		if ( $ignore_qs ) {
			$link = explode( '?', $link );
			$link = $link[0];
		}

		return $link;
	}

	/**
	 * Get RM Search Console API config.
	 *
	 * @return array
	 */
	public static function get_console_api_config() {
		return array(
			'application_name' => 'Rank Math',
			'client_id'        => '521003500769-n68nimh2rrahq6b4cdcjm03ojgsukr1f.apps.googleusercontent.com',
			'client_secret'    => 'nPNvFDg-1MHrT1cAFQouaVtK',
			'redirect_uri'     => 'urn:ietf:wg:oauth:2.0:oob',
			'scopes'           => array( 'https://www.googleapis.com/auth/webmasters', 'https://www.googleapis.com/auth/analytics', 'https://www.googleapis.com/auth/analytics.edit', 'https://www.googleapis.com/auth/adsense.readonly' ),
			'token_url'        => 'https://accounts.google.com/o/oauth2/token',
			'auth_url'         => 'https://accounts.google.com/o/oauth2/auth',
			'signon_certs_rl'  => 'https://www.googleapis.com/oauth2/v1/certs',
			'revoke_url'       => 'https://accounts.google.com/o/oauth2/revoke',
		);
	}

	/**
	 * Get Search Console auth url.
	 *
	 * @return string
	 */
	public static function get_console_auth_url() {
		$config = self::get_console_api_config();

		$params = array(
			'response_type' => 'code',
			'client_id'     => $config['client_id'],
			'redirect_uri'  => $config['redirect_uri'],
			'scope'         => implode( ' ', $config['scopes'] ),
		);

		return add_query_arg( $params, $config['auth_url'] );
	}

	/**
	 * Get or update Search Console data.
	 *
	 * @param  bool|array $data Data to save.
	 * @return bool|array
	 */
	public static function search_console_data( $data = null ) {
		$key = 'rank_math_search_console_data';

		if ( false === $data ) {
			delete_option( $key );
			return false;
		}

		$saved = get_option( $key, [] );
		if ( is_null( $data ) ) {
			return wp_parse_args( $saved, array(
				'authorized' => false,
				'profiles'   => [],
			) );
		}

		$data = wp_parse_args( $data, $saved );
		update_option( $key, $data );

		return $data;
	}

	/**
	 * Get search console module object.
	 *
	 * @return object
	 */
	public static function search_console() {
		return self::get_module( 'search-console' );
	}

	/**
	 * Get module by ID.
	 *
	 * @param  string $id ID to get module.
	 * @return object Module class object.
	 */
	public static function get_module( $id ) {
		return rank_math()->manager->get_module( $id );
	}

	/**
	 * Modify module status.
	 *
	 * @param string $modules Modules to modify.
	 */
	public static function update_modules( $modules ) {
		$stored = get_option( 'rank_math_modules' );

		foreach ( $modules as $module => $action ) {
			if ( 'off' === $action ) {
				if ( in_array( $module, $stored ) ) {
					$stored = array_diff( $stored, array( $module ) );
				}
				continue;
			}

			$stored[] = $module;
		}

		update_option( 'rank_math_modules', array_unique( $stored ) );
	}

	/**
	 * Clear cache from:
	 *  - WordPress Total Cache
	 *  - W3 Total Cache
	 *  - WP Super Cache
	 *  - SG CachePress
	 *  - WPEngine
	 *  - Varnish
	 */
	public static function clear_cache() {
		// Clean WordPress cache.
		if ( function_exists( 'wp_cache_clear_cache' ) ) {
			wp_cache_clear_cache();
		}

		// If W3 Total Cache is being used, clear the cache.
		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			w3tc_pgcache_flush();
		}

		// If WP Super Cache is being used, clear the cache.
		if ( function_exists( 'wp_cache_clean_cache' ) ) {
			global $file_prefix;
			wp_cache_clean_cache( $file_prefix );
		}

		// If SG CachePress is installed, rese its caches.
		if ( class_exists( 'SG_CachePress_Supercacher' ) && is_callable( array( 'SG_CachePress_Supercacher', 'purge_cache' ) ) ) {
			\SG_CachePress_Supercacher::purge_cache();
		}

		// Clear caches on WPEngine-hosted sites.
		if ( class_exists( 'WpeCommon' ) ) {
			\WpeCommon::purge_memcached();
			\WpeCommon::clear_maxcdn_cache();
			\WpeCommon::purge_varnish_cache();
		}

		// Clear Varnish caches.
		self::clear_varnish_cache();
	}

	/**
	 * Clear varnish cache for the dynamic files.
	 */
	private static function clear_varnish_cache() {
		// Parse the URL for proxy proxies.
		$parsed_url = wp_parse_url( home_url() );

		// Build a varniship.
		$varniship = get_option( 'vhp_varnish_ip' );
		if ( defined( 'VHP_VARNISH_IP' ) && VHP_VARNISH_IP != false ) {
			$varniship = VHP_VARNISH_IP;
		}

		// If we made varniship, let it sail.
		$purgeme = ( isset( $varniship ) && null != $varniship ) ? $varniship : $parsed_url['host'];
		wp_remote_request( 'http://' . $purgeme,
			array(
				'method'  => 'PURGE',
				'headers' => array(
					'host'           => $parsed_url['host'],
					'X-Purge-Method' => 'default',
				),
			)
		);
	}
}
