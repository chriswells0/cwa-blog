<?php
if (count($BlogEntryList) === 0) {
?>
				<div class="content">
					<p class="text-center">No blog entries found.</p>
				</div>
<?php
} else {
	echo '				<div id="blog-entry-listing">';
	foreach ($BlogEntryList as $BlogEntry) {
?>
					<div class="content blog-entry">
						<a href="/blog/view/<?= $BlogEntry->Slug ?>#disqus_thread" title="Join the discussion" class="heading-addon disqus-link" data-disqus-identifier="<?= "BlogEntry_$BlogEntry->ID" ?>"></a>
						<h2><a href="/blog/view/<?= $BlogEntry->Slug ?>" title="<?= $BlogEntry->Title ?>"><?= $BlogEntry->Title ?></a></h2>
						<div class="blog-entry-published">
							Published: <?= ($BlogEntry->Published ? date(DATE_DB_TO_PHP, strtotime($BlogEntry->Published)) : 'No') ?>
						</div>
<?php if ($CurrentUser->hasRole('ADMIN')) { ?>
						<div class="actions hidden-phone-portrait hidden-tablet-portrait">
							<a class="edit" href="/blog/edit/<?= $BlogEntry->Slug ?>" title="Edit this item">Edit</a>
							|
							<a class="delete" href="/blog/delete/<?= $BlogEntry->Slug ?>" title="Delete this item">Delete</a>
						</div>
<?php } ?>
						<div class="content-body">
							<p class="summary"><?= $BlogEntry->Summary ?></p>
<?= $BlogEntry->getPreview(isset($PreviewSize) ? $PreviewSize : null) ?>
							<div class="fade-out"></div>
						</div>
						<div class="actions">
<?php if ($CurrentUser->hasRole('ADMIN')) { ?>
							<a class="edit" href="/blog/edit/<?= $BlogEntry->Slug ?>" title="Edit this item">Edit</a>
							|
							<a class="delete" href="/blog/delete/<?= $BlogEntry->Slug ?>" title="Delete this item">Delete</a>
							|
<?php } ?>
							<a href="/blog/view/<?= $BlogEntry->Slug ?>" title="Read the full blog entry">Continue<span class="hidden-phone-portrait"> reading</span>...</a>
						</div>
					</div>
<?php
	}
	if (!empty($BackURL) || !empty($NextURL)) {
		echo '					<div id="pagination">';
		if (!empty($BackURL)) {
			echo '						<a class="page-action" rel="prev" href="' . $BackURL . '" title="View newer blog entries">← Newer Entries</a>';
		}
		if (!empty($NextURL)) {
			echo '						<a class="page-action" rel="next" href="' . $NextURL . '" title="View older blog entries">Older Entries →</a>';
		}
		echo '					</div>';
	}
	echo '				</div>';
}

require_once 'views/_shared/comments-counts.php';
?>
