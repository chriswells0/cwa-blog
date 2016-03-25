<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
	<head>
		<title><?= $this->getTitle() . ' :: ' . SITE_TITLE ?></title>

		<meta charset="UTF-8" />
		<meta name="author" content="<?= SITE_AUTHOR ?>" />
		<meta name="description" content="<?= $this->getDescription() ?>" />
		<meta name="robots" content="index,follow" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php
if (!is_null($this->getCanonicalURL())) {
	echo '		<link rel="canonical" href="' . $this->getCanonicalURL() . "\" />\n";
}
?>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<link rel="alternate" href="/blog?format=atom" type="application/atom+xml" title="<?= SITE_TITLE ?> :: Blog :: Atom Feed" />

		<style id="antiClickjack">body { display: none !important; }</style>
		<script>
		if (self === top) {
			var antiClickjack = document.getElementById("antiClickjack");
			antiClickjack.parentNode.removeChild(antiClickjack);
		} else {
			top.location = self.location;
		}
		var analyticsID = "<?= (defined('ANALYTICS_ID') && is_null($GLOBALS['app']->getAuthorizedRoles()) ? ANALYTICS_ID : '') ?>";
		</script>

		<script type="application/ld+json">
		[{
			"@context": "http://schema.org",
			"@type": "WebSite",
			"name": "<?= SITE_TITLE ?>",
			"alternateName": "<?= SITE_DOMAIN ?>",
			"url": "<?= PROTOCOL_HOST_PORT ?>"
		},
		{
			"@context": "http://schema.org",
			"@type": "Person",
			"name": "<?= SITE_AUTHOR ?>",
			"url": "<?= PROTOCOL_HOST_PORT ?>",
			"sameAs": [
				/* Add your social media URLs here. */
			]
		}]
		</script>

		<script type="application/x-social-share-privacy-settings">
		{
			"path_prefix": "/plugins/SocialSharePrivacy/",
			"info_link_target": "_blank",
			"layout": "line",
			"order": ["mail", "fbshare", "facebook", "gplus", "twitter", "linkedin", "hackernews", "stumbleupon", "reddit"],
			"services": {
				"buffer": {"status": false},
				"flattr": {"status": false},
				"xing": {"status": false},
				"disqus": {"status": false, "shortname": "<?= DISQUS_SHORTNAME ?>"},
				"pinterest": {"status": false},
				"stumbleupon": {"status": false}
			}
		}
		</script>
	</head>
	<body>
		<div id="wrapper">
<?php
	require_once 'views/_shared/header.php';
	require_once 'views/_shared/menu.php';
?>
			<div id="content-wrapper">
				<link rel="stylesheet" href="/styles/main.css" media="screen, print" />
				<script src="//code.jquery.com/jquery.min.js"></script>
				<script src="/scripts/jquery.cookie.js"></script>
				<script src="/scripts/cwa.js"></script>
				<script src="/scripts/main.js"></script>
<?php
	require_once $this->pathToPartial;
	require_once 'views/_shared/footer.php';
?>
			</div>
		</div>
		<script>
<?php
	$syncToken = $GLOBALS['app']->getSyncToken();
	if (is_null($syncToken)) {
		echo '			CWA.MVC.View.syncToken = { name: "", value: "" };' . PHP_EOL;
	} else {
		echo '			CWA.MVC.View.syncToken = { name: "' . $syncToken['name'] . '", value: "' . $syncToken['value'] . '" };' . PHP_EOL;
	}
?>
		</script>
	</body>
</html>
