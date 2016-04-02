<?php
if (count($BlogPostList) === 0) {
?>
				<div class="content">
					<p class="text-center">No blog posts found.</p>
				</div>
<?php
} else {
	echo '				<div id="blog-post-listing">';
	foreach ($BlogPostList as $BlogPost) {
?>
					<div class="content blog-post">
						<a href="/blog/view/<?= $BlogPost->Slug ?>#disqus_thread" title="Join the discussion" class="heading-addon disqus-link" data-disqus-identifier="<?= "BlogPost_$BlogPost->ID" ?>"></a>
						<h2><a href="/blog/view/<?= $BlogPost->Slug ?>" title="<?= $BlogPost->Title ?>"><?= $BlogPost->Title ?></a></h2>
						<div class="blog-post-published">
							Published: <?= ($BlogPost->Published ? date(DATE_DB_TO_PHP, strtotime($BlogPost->Published)) : 'No') ?>
						</div>
<?php if ($CurrentUser->hasRole('ADMIN')) { ?>
						<div class="actions hidden-phone-portrait hidden-tablet-portrait">
							<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
							|
							<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
						</div>
<?php } ?>
						<div class="content-body">
							<p class="summary"><?= $BlogPost->Summary ?></p>
<?= $BlogPost->getPreview(isset($PreviewSize) ? $PreviewSize : null) ?>
							<div class="fade-out"></div>
						</div>
						<div class="actions">
<?php if ($CurrentUser->hasRole('ADMIN')) { ?>
							<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
							|
							<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
							|
<?php } ?>
							<a href="/blog/view/<?= $BlogPost->Slug ?>" title="Read the full blog post">Continue<span class="hidden-phone-portrait"> reading</span>...</a>
						</div>
					</div>
<?php
	}
	if (!empty($BackURL) || !empty($NextURL)) {
		echo '					<div id="pagination">';
		if (!empty($BackURL)) {
			echo '						<a class="page-action" rel="prev" href="' . $BackURL . '" title="View newer blog posts">← Newer Posts</a>';
		}
		if (!empty($NextURL)) {
			echo '						<a class="page-action" rel="next" href="' . $NextURL . '" title="View older blog posts">Older Posts →</a>';
		}
		echo '					</div>';
	}
	echo '				</div>';
}

require_once 'views/_shared/comments-counts.php';
?>
