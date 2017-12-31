<?php
if ($CurrentUser->hasRole('ADMIN')) {
?>
				<div class="actions"><a class="add" href="/tags/add">Add a new Tag</a></div>
<?php
}
?>
			<div class="content">
				<h1>Tags</h1>
				<div class="content-body">
					<table>
						<thead>
							<tr>
								<th width="150px">Value</th>
								<th class="hidden-tablet-portrait">Sort Order</th>
								<th class="hidden-phone-portrait">Show In Menu</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
<?php
if (count($TagList) === 0) {
?>
							<tr><td colspan="4" class="text-center">No tags found.</td></tr>
<?php
} else {
	foreach ($TagList as $Tag) {
?>
							<tr>
								<td><a href="/tags/<?= $Tag->Slug ?>"><?= $Tag->Value ?></a></td>
								<td class="hidden-tablet-portrait"><?= $Tag->SortOrder ?></td>
								<td class="hidden-phone-portrait"><?= ($Tag->ShowInMenu ? 'Yes' : 'No') ?></td>
								<td>
									<div class="actions">
										<a class="edit" href="/tags/edit/<?= $Tag->Slug ?>" title="Edit this item">Edit</a>
										|
										<a class="delete" href="/tags/delete/<?= $Tag->Slug ?>" title="Delete this item">Delete</a>
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
				<div class="actions"><a class="add" href="/tags/add">Add a new Tag</a></div>
<?php
}
?>
