<?php
foreach ($BlogPostList as $BlogPost) {
?>
	<entry>
		<id><?= "$idPrefix$BlogPost->ID" ?></id>
		<link href="/blog/<?= $BlogPost->Slug ?>" />
		<updated><?php $updated = new DateTime($BlogPost->Updated); echo $updated->format(DateTime::ATOM); ?></updated>
<?php
	if (!is_null($BlogPost->Published)) {
?>
		<published><?php $published = new DateTime($BlogPost->Published); echo $published->format(DateTime::ATOM); ?></published>
<?php
	}
?>
		<title><?= $BlogPost->Title ?></title>
<?php /*
		<summary type="html"><![CDATA[<?= $BlogPost->Summary ?>]]></summary>
*/ ?>
		<content type="html"><![CDATA[<?= $BlogPost->Body ?>]]></content>
<?php
	$scheme = PROTOCOL_HOST_PORT . \CWA\APP_ROOT . 'tags/';
	foreach ($BlogPost->Tags as $Tag) {
?>
		<category term="<?= $Tag->Slug ?>" label="<?= $this->sanitize($Tag->Value) ?>" scheme="<?= $scheme ?>"></category>
<?php
	}
?>
	</entry>
<?php
}
?>