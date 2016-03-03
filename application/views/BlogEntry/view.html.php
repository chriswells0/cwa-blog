<?php
require_once 'views/_shared/status.html.php';
?>
				<div class="content blog-entry" itemscope itemtype="http://schema.org/BlogPosting">
					<div class="metadata">
						<!-- Open Graph for Facebook -->
						<meta property="og:type" content="article" />
						<meta property="og:url" content="<?= $this->getCanonicalURL() ?>" />
						<meta property="og:image" content="<?= $ImageURL ?>" />
						<meta property="og:title" content="<?= $BlogEntry->Title ?>" />
						<meta property="og:description" content="<?= $BlogEntry->Summary ?>" />
						<!-- schema.org microdata for Google -->
						<meta itemprop="mainEntityOfPage" content="<?= $this->getCanonicalURL() ?>" />
						<div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<meta itemprop="url" content="<?= $ImageURL ?>" />
							<meta itemprop="width" content="<?= $ImageWidth ?>" />
							<meta itemprop="height" content="<?= $ImageHeight ?>" />
						</div>
						<div itemprop="author" itemscope itemtype="https://schema.org/Person">
							<meta itemprop="name" content="<?= SITE_AUTHOR ?>" />
						</div>
						<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
							<meta itemprop="name" content="<?= PUBLISHER_NAME ?>" />
							<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
								<meta itemprop="url" content="<?= PROTOCOL_HOST_PORT . PUBLISHER_LOGO ?>" />
							</div>
						</div>
						<meta itemprop="datePublished" content="<?= date(DateTime::ATOM, strtotime($BlogEntry->Published)) ?>" />
						<meta itemprop="dateModified" content="<?= date(DateTime::ATOM, strtotime($BlogEntry->Updated)) ?>" />
					</div>
					<a href="#disqus_thread" title="Join the discussion" class="heading-addon disqus-link" data-disqus-identifier="<?= "BlogEntry_$BlogEntry->ID" ?>"></a>
					<h1 itemprop="headline"><?= $BlogEntry->Title ?></h1>
					<div class="blog-entry-published">
						Published: <?= ($BlogEntry->Published ? date(DATE_DB_TO_PHP, strtotime($BlogEntry->Published)) : 'No') ?>

					</div>
<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
					<div class="actions hidden-phone-portrait hidden-tablet-portrait">
						<a class="edit" href="/blog/edit/<?= $BlogEntry->Slug ?>" title="Edit this item">Edit</a>
						|
						<a class="delete" href="/blog/delete/<?= $BlogEntry->Slug ?>" title="Delete this item">Delete</a>
					</div>
<?php
}
?>
					<div class="content-body">
						<p class="summary" itemprop="description"><?= $BlogEntry->Summary ?></p>
						<div id="blog-entry-body" itemprop="articleBody">
							<?= $BlogEntry->Body ?>

						</div>
					</div>
<?php
require_once 'views/_shared/tags.html.php';

if ($CurrentUser->hasRole('ADMIN')) {
?>
					<div class="actions">
						<a class="edit" href="/blog/edit/<?= $BlogEntry->Slug ?>" title="Edit this item">Edit</a>
						|
						<a class="delete" href="/blog/delete/<?= $BlogEntry->Slug ?>" title="Delete this item">Delete</a>
					</div>
<?php
}
?>
					<h4 class="share-heading">Share This</h4>
					<div class="ss-privacy" data-social-share-privacy="true"></div>
<?php
if (!is_null($BlogEntry->Published)) {
	require_once 'views/_shared/comments.php';
	require_once 'views/_shared/comments-counts.php';
}
?>
				</div>
<script>
<?php
if (!$BlogEntry->Published) { // Prevent tracking of unpublished blog entries. -- cwells
?>
analyticsID = "";
<?php
}
?>

// Add the microdata attribute to each image in the blog entry. -- cwells
$("#blog-entry-body > .visual > img").attr("itemprop", "image");
</script>
