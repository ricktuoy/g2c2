<?php
// Before removing this file, please verify the PHP ini setting `auto_prepend_file` does not point to this.

if (file_exists('/home/rick/Dev/g2c2/wp-content/plugins/wordfence/waf/bootstrap.php')) {
	define("WFWAF_LOG_PATH", '/home/rick/Dev/g2c2/wp-content/wflogs/');
	include_once '/home/rick/Dev/g2c2/wp-content/plugins/wordfence/waf/bootstrap.php';
}
?>