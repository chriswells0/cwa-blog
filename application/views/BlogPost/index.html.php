<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
				<div class="actions"><a class="add" href="/blog/add">Add a new Blog Post</a></div>
<?php
}

require_once 'list.pretty.php';
?>