			<div id="tags" class="content">
				<h1>All Tags</h1>
				<div class="content-body">
<?php
if (count($TagList) === 0) {
?>
					<p>No tags found.</p>
<?php
} else {
	foreach ($TagList as $Tag) {
		echo "					<p class=\"tag\"><a href=\"/tags/view/$Tag->Slug\">$Tag->Value</a></p>";
	}
}
?>
				</div>
			</div>
