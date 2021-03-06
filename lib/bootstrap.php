<?php
/**
 * Common loader code
 *
 * @copyright Copyright (c) 2013, The volkszaehler.org project
 * @package default
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
/*
 * This file is part of volkzaehler.org
 *
 * volkzaehler.org is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * volkzaehler.org is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with volkszaehler.org. If not, see <http://www.gnu.org/licenses/>.
 */

use Volkszaehler\Util;

// enable strict error reporting
error_reporting(E_ALL | E_STRICT);

// Note: users of bootstrap.php can set VZ_DIR before calling bootstrap
if (!defined('VZ_DIR')) {
	define('VZ_DIR', realpath(__DIR__ . '/..'));
}
define('VZ_VERSION', '0.3');

if (!file_exists(VZ_DIR . '/vendor/autoload.php')) {
	die('Could not find autoloader. Check that dependencies have been installed via `composer install`.');
}

require_once VZ_DIR . '/vendor/autoload.php';

// load configuration
Util\Configuration::load(VZ_DIR . '/etc/volkszaehler.conf');

// set timezone
$tz = (Util\Configuration::read('timezone')) ? Util\Configuration::read('timezone') : @date_default_timezone_get();
date_default_timezone_set($tz);

// set locale
setlocale(LC_ALL, Util\Configuration::read('locale'));

// force numeric output to C convention (issue #121)
setlocale(LC_NUMERIC, 'C');

?>
