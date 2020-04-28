<?php
/*
Plugin Name: Taxonomy Landing Pages
Plugin URI: https://github.com/crowdfavorite/wp-taxonomy-landing
Description: Allow separately designed landing pages for taxonomy archives.
Version: 1.1.2
Author: Crowd Favorite
Author URI: https://crowdfavorite.com
*/

/**
 * @package taxonomy-landing
 *
 * This file is part of Taxonomy Landing for WordPress
 * https://github.com/crowdfavorite/wp-taxonomy-landing
 *
 * Copyright (c) 2009-2012 Crowd Favorite, Ltd. All rights reserved.
 * https://crowdfavorite.com
 *
 * Released under the GPL license
 * https://www.opensource.org/licenses/gpl-license.php
 *
 * **********************************************************************
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * **********************************************************************
 */

// ini_set('display_errors', '1'); ini_set('error_reporting', E_ALL);

if (!defined('LARGO_TEMPLATE_LANDING_VERSION')) {
	define('LARGO_TEMPLATE_LANDING_VERSION', '1.1.2');

	// Commented out as part of https://github.com/INN/largo/pull/1858
	// because this "plugin" is being loaded as a library directly in Largo
	// and as a result, no text domain is being shipped from wordpress.org.
	// load_plugin_textdomain( 'cf-tax-landing' );

	include('functions/cftl-admin.php');
	include('functions/cftl-intercept-queries.php');
	include('functions/cftl-series-order.php');

} // End CF_TEMPLATE_LANDING_VERSION check
