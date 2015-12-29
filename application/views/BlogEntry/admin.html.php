<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
				<div class="actions"><a class="add" href="/blog/add">Add a new Blog Entry</a></div>
<?php
}
?>
			<div class="content">
				<h1>Blog Entries</h1>
				<div class="content-body">
					<table>
						<thead>
							<tr>
								<th>Blog Entry</th>
								<th class="hidden-tablet-portrait">Comments</th>
								<th class="hidden-tablet-portrait">Published</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
<?php
if (count($BlogEntryList) === 0) {
?>
							<tr><td colspan="4" class="text-center">No blog entries found.</td></tr>
<?php
} else {
	foreach ($BlogEntryList as $BlogEntry) {
?>
							<tr>
								<td><a href="/blog/view/<?= $BlogEntry->Slug ?>" title="<?= $BlogEntry->Summary ?>"><?= $BlogEntry->Title ?></a></td>
								<td class="hidden-tablet-portrait"><a href="/blog/view/<?= $BlogEntry->Slug ?>#disqus_thread" title="Read and respond to comments" data-disqus-identifier="<?= "BlogEntry_$BlogEntry->ID" ?>"></a></td>
								<td class="hidden-tablet-portrait"><?= (is_null($BlogEntry->Published) ? 'Not published.' : $BlogEntry->Published) ?></td>
								<td>
									<div class="actions">
										<a class="edit" href="/blog/edit/<?= $BlogEntry->Slug ?>" title="Edit this item">Edit</a>
										|
										<a class="delete" href="/blog/delete/<?= $BlogEntry->Slug ?>" title="Delete this item">Delete</a>
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
				<div class="actions"><a class="add" href="/blog/add">Add a new Blog Entry</a></div>
<?php
}

require_once 'views/_shared/comments-counts.php';
?>
