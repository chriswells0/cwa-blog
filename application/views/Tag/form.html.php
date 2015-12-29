<?php
require_once 'views/_shared/status.html.php';
?>
			<div id="tag" class="content">
				<h1>Tag</h1>
				<div class="content-body">
					<form action="/tags/save" method="post">
						<input type="hidden" name="ID" id="ID" value="<?= $Tag->ID ?>" />
						<div class="form-field">
							<label for="Value">Value</label>
							<input type="text" name="Value" id="Value" value="<?= $Tag->Value ?>" placeholder="User Friendly Value" autofocus required minlength="3" maxlength="50" />
						</div>
						<div class="form-field">
							<label for="Slug">Slug</label>
							<input type="text" name="Slug" id="Slug" value="<?= $Tag->Slug ?>" placeholder="url-friendly-value" required minlength="3" maxlength="50" />
							<button type="button" id="slug-gen">Generate</button>
						</div>
						<div class="form-field">
							<label for="SortOrder">Sort Order</label>
							<input type="text" name="SortOrder" id="SortOrder" value="<?= $Tag->SortOrder ?>" placeholder="10000" list="commonSortOrders" required minlength="1" maxlength="5" />
							<datalist id="commonSortOrders">
								<option value="10000" />
								<option value="15000" />
								<option value="20000" />
							</datalist>
						</div>
						<div class="form-field">
							<label for="ShowInMenu">Show In Menu</label>
							<input type="hidden" name="ShowInMenu" value="0" />
							<input type="checkbox" name="ShowInMenu" id="ShowInMenu" value="1" <?= ($Tag->ShowInMenu ? ' checked="checked"' : '') ?> />
						</div>
						<div class="buttons">
							<button type="submit">Save</button>
							<button type="button" onclick="document.location='/tags/admin'; return false;">Cancel</button>
						</div>
					</form>
				</div>
			</div>

<script>

$("#Slug").focus(function () {
	var slug = $(this);
	if (slug.val() === "") {
		slug.val(CWA.MVC.View.createSlug($("#Value").val()));
	}
});

$("#slug-gen").click(function (e) {
	e.preventDefault();
	$("#Slug").val(CWA.MVC.View.createSlug($("#Value").val()));
});

</script>
