<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
				<div class="actions"><a class="add" href="/blog/add">Add a new Blog Post</a></div>
<?php
}
?>
			<div class="content">
				<h1>Blog Posts</h1>
				<div class="content-body">
					<table>
						<thead>
							<tr>
								<th>Blog Post</th>
								<th class="hidden-tablet-portrait">Comments</th>
								<th class="hidden-tablet-portrait">Published</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
<?php
if (count($BlogPostList) === 0) {
?>
							<tr><td colspan="4" class="text-center">No blog posts found.</td></tr>
<?php
} else {
	foreach ($BlogPostList as $BlogPost) {
?>
							<tr>
								<td><a href="/blog/<?= $BlogPost->Slug ?>" title="<?= $BlogPost->Summary ?>"><?= $BlogPost->Title ?></a></td>
								<td class="hidden-tablet-portrait"><a href="/blog/<?= $BlogPost->Slug ?>#disqus_thread" title="Read and respond to comments" data-disqus-identifier="<?= "BlogPost_$BlogPost->ID" ?>"></a></td>
								<td class="hidden-tablet-portrait"><?= (is_null($BlogPost->Published) ? 'Not published.' : $BlogPost->Published) ?></td>
								<td>
									<div class="actions">
										<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
										|
										<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
									</div>
								</td>
							</tr>
<?php
	}
}
?>
						</tbody>
					</table>
				</div>
			</div>
<?php
require_once 'views/_shared/pagination.php';

if ($CurrentUser->hasRole('ADMIN')) {
?>
				<div class="actions"><a class="add" href="/blog/add">Add a new Blog Post</a></div>
<?php
}

require_once 'views/_shared/comments-counts.php';
?>
