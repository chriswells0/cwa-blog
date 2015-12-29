<?php
require_once 'views/_shared/status.html.php';
?>
				<div id="tag" class="content">
					<a href="/tags" title="View all tags" class="heading-addon">View All Tags</a>
					<h1><?= $Tag->Value ?></h1>
<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
					<div class="actions">
						<a class="edit" href="/tags/edit/<?= $Tag->Slug ?>" title="Edit this item">Edit</a>
						|
						<a class="delete" href="/tags/delete/<?= $Tag->Slug ?>" title="Delete this item">Delete</a>
					</div>
<?php
}

if ($CurrentUser->hasRole('ADMIN')) {
?>
					<p>
						<div class="label">Created:</div><?= $Tag->Created ?>
						<br />
						<div class="label">Updated:</div><?= $Tag->Updated ?>
						<br />
						<div class="label">Sort Order:</div><?= $Tag->SortOrder ?>
						<br />
						<div class="label">Show In Menu:</div><?= ($Tag->ShowInMenu ? 'Yes' : 'No') ?>
					</p>
<?php
}
//						<h2 class="blog-entry-list">Blog Entries</h2>
require_once 'views/BlogEntry/list.pretty.php';


/*
					<hr />
					<div>
						<h2 class="photo-album-list">Photo Albums</h2>
if (count($PhotoAlbums) === 0) {
	echo '							<p>No photo albums found.</p>';
} else {
	$ControllerName = $this->CustomPath = 'photo-album';
	foreach ($PhotoAlbums as $PhotoAlbum)
	{
		require_once "includes/views/photo-album/list_item.php";
	}
}
?>
					</div>
					<hr />
					<div>
						<h2 class="photo-list">Photos</h2>
<?php
if (count($Photos) === 0) {
	echo '							<p>No photos found.</p>';
} else {
	$ControllerName = $this->CustomPath = 'photo';
	foreach ($Photos as $Photo)
	{
		require_once "includes/views/photo/list_item.php";
	}
}
					</div>
*/
?>
				</div>
