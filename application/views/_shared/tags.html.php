<?php
$output = '';
$tags = ${$ModelType}->Tags;
$lastIndex = count($tags) - 1;
if ($lastIndex === -1) {
	$output = 'NONE';
} else {
	for ($i = 0; $i <= $lastIndex; $i++) {
		$sanitizedValue = $this->sanitize($tags[$i]->Value);
		$output .= '<a href="/tags/view/' . $tags[$i]->Slug . '" title="View items tagged as ' . $sanitizedValue . '" rel="tag">' . $sanitizedValue . '</a>';
		if ($i !== $lastIndex) $output .= ', ';
	}
}
?>
					<div id="blog-post-tags" title="Tags">
						<?= $output ?>
					</div>
