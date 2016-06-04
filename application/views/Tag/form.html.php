<?php
require_once 'views/_shared/status.html.php';
?>
			<div id="tag" class="content">
				<h1>Tag</h1>
				<div class="content-body">
					<form id="tag" action="<?= $ControllerURL ?>/save" method="post">
						<input type="hidden" name="ID" value="<?= $Tag->ID ?>" />
						<div class="form-field">
							<label for="tag-value">Value</label>
							<input type="text" name="Value" id="tag-value" value="<?= $Tag->Value ?>" placeholder="User Friendly Value" autofocus required minlength="3" maxlength="50" />
						</div>
						<div class="form-field">
							<label for="tag-slug">Slug</label>
							<input type="text" name="Slug" id="tag-slug" value="<?= $Tag->Slug ?>" placeholder="url-friendly-value" required minlength="3" maxlength="50" data-cwa-focus="suggestSlug" data-from="tag-value" data-to="tag-slug" />
							<button type="button" data-cwa-click="updateSlug" data-from="tag-value" data-to="tag-slug">Generate</button>
						</div>
						<div class="form-field">
							<label for="SortOrder">Sort Order</label>
							<input type="text" name="SortOrder" value="<?= $Tag->SortOrder ?>" placeholder="10000" list="commonSortOrders" required minlength="1" maxlength="5" />
							<datalist id="commonSortOrders">
								<option value="10000" />
								<option value="15000" />
								<option value="20000" />
							</datalist>
						</div>
						<div class="form-field">
							<label for="ShowInMenu">Show In Menu</label>
							<input type="hidden" name="ShowInMenu" value="0" />
							<input type="checkbox" name="ShowInMenu" value="1" <?= ($Tag->ShowInMenu ? ' checked="checked"' : '') ?> />
						</div>
						<div class="buttons">
							<button type="submit">Save</button>
							<button type="button" data-cwa-click="cancelEdit">Cancel</button>
						</div>
					</form>
				</div>
			</div>
