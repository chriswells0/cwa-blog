<?php
require_once 'views/_shared/status.html.php';
?>
			<div class="content">
				<h1>Blog Post</h1>
				<div class="content-body">
					<form id="blog-post" action="<?= $ControllerURL ?>/save" method="post" enctype="multipart/form-data">
						<input type="hidden" name="ID" value="<?= $BlogPost->ID ?>" />
						<div class="form-field">
							<label for="Title">Title</label>
							<input type="text" name="Title" id="blog-title" class="long" value="<?= $BlogPost->Title ?>" placeholder="User Friendly Title" autofocus required minlength="3" maxlength="50" />
						</div>
						<div class="form-field">
							<input type="hidden" name="OldSlug" value="<?= isset($BlogPost->OldSlug) ? $BlogPost->OldSlug : $BlogPost->Slug ?>" />
							<label for="Slug">Slug</label>
							<input type="text" name="Slug" id="blog-slug" class="long" value="<?= $BlogPost->Slug ?>" placeholder="url-friendly-slug" required minlength="3" maxlength="50" data-cwa-focus="suggestSlug" data-from="blog-title" data-to="blog-slug" />
							<button type="button" data-cwa-click="updateSlug" data-from="blog-title" data-to="blog-slug">Generate</button>
						</div>
						<div class="form-field">
							<label for="Summary">Summary</label>
							<div class="form-field">
								<textarea name="Summary" id="Summary" placeholder="1-2 sentences (up to 160 characters) summarizing this blog post." required minlength="5" maxlength="160" ><?= $BlogPost->Summary ?></textarea>
								<span><span id="charsLeft">160</span> characters remaining</span>
							</div>
						</div>
						<div class="form-field">
							<label for="Body">Body</label>
							<div class="form-field">
								<textarea name="Body" minlength="5" maxlength="21200" data-html-editor="true"><?= $BlogPost->Body ?></textarea>
							</div>
						</div>
						<div class="form-field">
							<div class="actions">
								<a class="add" href="/tags/add" title="Create a new tag" data-cwa-click="loadInModal">Add New Tag</a>
							</div>
							<label for="Tags[]">Tags</label>
							<input type="hidden" name="Tags[]" value="" />
							<select id="blog-tags" name="Tags[]" multiple="multiple" size="10">
<?php
foreach($Tags as $Tag) {
	echo "<option value=\"$Tag->ID\"" . (in_array($Tag->ID, $BlogPostTagIDs) ? ' selected="selected"' : '') . ">$Tag->Value</option>";
}
?>
							</select>
						</div>
						<div class="form-field">
							<label for="IsPublic">Public</label>
							<input type="hidden" name="IsPublic" value="0" />
							<input type="checkbox" name="IsPublic" value="1" <?= is_null($BlogPost->Published) ? '' : 'checked="checked"' ?> />
							<input type="hidden" name="Published" value="<?= $BlogPost->Published ?>" />
						</div>
						<div class="buttons">
							<button type="submit">Save</button>
							<button type="button" data-cwa-click="cancelEdit">Cancel</button>
						</div>
					</form>
<?php
$imageDir = '';
if (!empty($BlogPost->Slug)) {
	$imageDir = $BlogPost->Slug[0] . '/' . $BlogPost->Slug; // The sub-path for this item's images. -- cwells
}
require_once 'views/_shared/image-manager.php';
?>
				</div>
			</div>

<script>

$("#Summary").on("input propertychange", function (e) {
	var remaining = 160 - $("#Summary").val().length;
	$("#charsLeft").text(remaining);
	if (remaining < 0) {
		$("#charsLeft").parent().addClass("error");
	} else {
		$("#charsLeft").parent().removeClass("error");
	}
});

$("#Summary").trigger("input");

$("#blog-post").submit(function (e) {
	if ($("#Summary").val().indexOf('"') !== -1) {
		if (confirm("The summary cannot contain double quotes.\nMay I convert them to single quotes for you?")) {
			$("#Summary").val($("#Summary").val().replace(/"/g, "'"));
		}
		return false;
	}
	return true;
});

CWA.MVC.View.on("cwa-modal-loaded", function (e, params) {
	if (CWA.DOM.forms["tag"]) {
		CWA.DOM.forms["tag"].on("cwa-form-submit-success", function (e, params) {
			if (!params || !params.data || !params.data.Tag) {
				return;
			}
			var inserted = false,
				newTag = $("<option />", {
					html: params.data.Tag.Value,
					selected: "selected",
					value: params.data.Tag.ID
				}),
				options = $("#blog-tags > option");
			options.each(function () {
				var option = $(this);
				if (option.text() > params.data.Tag.Value) {
					newTag.insertBefore(option);
					inserted = true;
					return false;
				}
			});
			if (!inserted) {
				newTag.appendTo($("#blog-tags"));
			}
		});
	}
});

</script>
