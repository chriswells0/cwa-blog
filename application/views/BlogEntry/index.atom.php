<?php
foreach ($Items as $Item) {
?>
	<entry>
		<id><?= "$idPrefix$Item->ID" ?></id>
		<link href="/blog/view/<?= $Item->Slug ?>" />
		<updated><?php $updated = new DateTime($Item->Updated); echo $updated->format(DateTime::ATOM); ?></updated>
<?php
	if (!is_null($Item->Published)) {
?>
		<published><?php $published = new DateTime($Item->Published); echo $published->format(DateTime::ATOM); ?></published>
<?php
	}
?>
		<title><?= $Item->Title ?></title>
<?php /*
		<summary type="html"><![CDATA[<?= $Item->Summary ?>]]></summary>
*/ ?>
		<content type="html"><![CDATA[<?= $Item->Body ?>]]></content>
<?php
	$scheme = PROTOCOL_HOST_PORT . \CWA\APP_ROOT . 'tags/view/';
	foreach ($Item->Tags as $Tag) {
?>
		<category term="<?= $Tag->Slug ?>" label="<?= $this->sanitize($Tag->Value) ?>" scheme="<?= $scheme ?>"></category>
<?php
	}
?>
	</entry>
<?php
}
?>