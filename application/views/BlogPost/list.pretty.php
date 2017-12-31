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
<?php if ($CurrentUser->hasRole('ADMIN')) { ?>
						<div class="actions hidden-phone-portrait hidden-tablet-portrait">
							<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
							|
							<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
						</div>
<?php } ?>
						<h2><a href="/blog/<?= $BlogPost->Slug ?>" title="<?= $BlogPost->Title ?>"><?= $BlogPost->Title ?></a></h2>
						<a href="/blog/<?= $BlogPost->Slug ?>#disqus_thread" title="Join the discussion" class="actions disqus-link" data-disqus-identifier="<?= "BlogPost_$BlogPost->ID" ?>"></a>
						<div class="blog-post-published">
							<span class="hidden-phone">Published: </span><?= ($BlogPost->Published ? date(DATE_DB_TO_PHP, strtotime($BlogPost->Published)) : 'No') ?>
						</div>
						<div class="content-body">
							<p class="summary"><?= $BlogPost->Summary ?></p>
<?= $BlogPost->getPreview(isset($PreviewSize) ? $PreviewSize : null) ?>
							<div class="fade-out hidden-print"></div>
						</div>
						<div class="actions">
<?php if ($CurrentUser->hasRole('ADMIN')) { ?>
							<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
							|
							<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
							|
<?php } ?>
							<a href="/blog/<?= $BlogPost->Slug ?>" title="Read the full blog post">Continue<span class="hidden-phone-portrait"> reading</span>...</a>
						</div>
					</div>
<?php
	}
	if (!empty($PreviousPage) || !empty($NextPage)) {
		echo '					<div id="pagination" class="hidden-print">';
		if (!empty($PreviousPage)) {
			echo '						<a class="page-action" rel="prev" href="' . $PreviousPage . '" title="View newer blog posts">← Newer Posts</a>';
		}
		if (!empty($NextPage)) {
			echo '						<a class="page-action" rel="next" href="' . $NextPage . '" title="View older blog posts">Older Posts →</a>';
		}
		echo '					</div>';
	}
	echo '				</div>';
}

require_once 'views/_shared/comments-counts.php';
?>
