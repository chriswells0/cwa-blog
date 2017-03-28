<?php
require_once 'views/_shared/status.html.php';
?>
				<div class="content blog-post" itemscope itemtype="http://schema.org/BlogPosting">
					<div class="metadata">
						<!-- Open Graph for Facebook -->
						<meta property="og:type" content="article" />
						<meta property="og:url" content="<?= $this->getCanonicalURL() ?>" />
						<meta property="og:image" content="<?= $ImageURL ?>" />
						<meta property="og:title" content="<?= $BlogPost->Title ?>" />
						<meta property="og:description" content="<?= $BlogPost->Summary ?>" />
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
						<meta itemprop="datePublished" content="<?= date(DateTime::ATOM, strtotime($BlogPost->Published)) ?>" />
						<meta itemprop="dateModified" content="<?= date(DateTime::ATOM, strtotime($BlogPost->Updated)) ?>" />
					</div>
<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
					<div class="actions hidden-phone-portrait hidden-tablet-portrait">
						<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
						|
						<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
					</div>
<?php
}
?>
					<h1 itemprop="headline"><?= $BlogPost->Title ?></h1>
					<a href="#disqus_thread" title="Join the discussion" class="actions disqus-link" data-disqus-identifier="<?= "BlogPost_$BlogPost->ID" ?>"></a>
					<div class="blog-post-published">
						<span class="hidden-phone">Published: </span><?= ($BlogPost->Published ? date(DATE_DB_TO_PHP, strtotime($BlogPost->Published)) : 'No') ?>

					</div>
					<div class="content-body">
						<p class="summary" itemprop="description"><?= $BlogPost->Summary ?></p>
						<div id="blog-post-body" itemprop="articleBody">
							<?= $BlogPost->Body ?>

						</div>
					</div>
<?php
require_once 'views/_shared/tags.html.php';

if ($CurrentUser->hasRole('ADMIN')) {
?>
					<div class="actions">
						<a class="edit" href="/blog/edit/<?= $BlogPost->Slug ?>" title="Edit this item">Edit</a>
						|
						<a class="delete" href="/blog/delete/<?= $BlogPost->Slug ?>" title="Delete this item">Delete</a>
					</div>
<?php
}
?>
					<h4 class="share-heading">Share This</h4>
					<div class="ss-privacy" data-social-share-privacy="true"></div>
<?php
if (!is_null($BlogPost->Published)) {
	require_once 'views/_shared/comments.php';
	require_once 'views/_shared/comments-counts.php';
}
?>
				</div>
<script>
<?php
if (!$BlogPost->Published) { // Prevent tracking of unpublished blog posts. -- cwells
?>
analyticsID = "";
<?php
}
?>

// Add the microdata attribute to each image in the blog post. -- cwells
$("#blog-post-body > .visual > img").attr("itemprop", "image");
</script>
