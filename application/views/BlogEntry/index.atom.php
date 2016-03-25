<?php
foreach ($BlogEntryList as $BlogEntry) {
?>
	<entry>
		<id><?= "$idPrefix$BlogEntry->ID" ?></id>
		<link href="/blog/view/<?= $BlogEntry->Slug ?>" />
		<updated><?php $updated = new DateTime($BlogEntry->Updated); echo $updated->format(DateTime::ATOM); ?></updated>
<?php
	if (!is_null($BlogEntry->Published)) {
?>
		<published><?php $published = new DateTime($BlogEntry->Published); echo $published->format(DateTime::ATOM); ?></published>
<?php
	}
?>
		<title><?= $BlogEntry->Title ?></title>
<?php /*
		<summary type="html"><![CDATA[<?= $BlogEntry->Summary ?>]]></summary>
*/ ?>
		<content type="html"><![CDATA[<?= $BlogEntry->Body ?>]]></content>
<?php
	$scheme = PROTOCOL_HOST_PORT . \CWA\APP_ROOT . 'tags/view/';
	foreach ($BlogEntry->Tags as $Tag) {
?>
		<category term="<?= $Tag->Slug ?>" label="<?= $this->sanitize($Tag->Value) ?>" scheme="<?= $scheme ?>"></category>
<?php
	}
?>
	</entry>
<?php
}
?>