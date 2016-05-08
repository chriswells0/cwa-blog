<?php
require_once 'views/_shared/status.html.php';
?>
			<div class="content">
				<h1>Blog Post</h1>
				<div class="content-body">
					<form id="blog-post" action="/blog/save" method="post" enctype="multipart/form-data">
						<input type="hidden" name="ID" id="ID" value="<?= $BlogPost->ID ?>" />
						<div class="form-field">
							<label for="Title">Title</label>
							<input type="text" name="Title" id="Title" value="<?= $BlogPost->Title ?>" placeholder="User Friendly Title" autofocus required minlength="3" maxlength="50" />
						</div>
						<div class="form-field">
							<input type="hidden" name="OldSlug" value="<?= isset($BlogPost->OldSlug) ? $BlogPost->OldSlug : $BlogPost->Slug ?>" />
							<label for="Slug">Slug</label>
							<input type="text" name="Slug" id="Slug" value="<?= $BlogPost->Slug ?>" placeholder="url-friendly-slug" required minlength="3" maxlength="50" />
							<button type="button" id="slug-gen">Generate</button>
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
								<textarea name="Body" id="Body" minlength="5" maxlength="21200" data-html-editor="true"><?= $BlogPost->Body ?></textarea>
							</div>
						</div>
						<div class="form-field">
							<label for="Tags[]">Tags</label>
							<input type="hidden" name="Tags[]" value="" />
							<select name="Tags[]" id="Tags[]" multiple="multiple" size="10">
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
							<input type="checkbox" name="IsPublic" id="IsPublic" value="1" <?= is_null($BlogPost->Published) ? '' : 'checked="checked"' ?> />
							<input type="hidden" name="Published" value="<?= $BlogPost->Published ?>" />
						</div>
						<div class="buttons">
							<button type="submit">Save</button>
							<button type="button" onclick="document.location='/blog/admin'; return false;">Cancel</button>
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

$("#Slug").focus(function () {
	var slug = $(this);
	if (slug.val() === "") {
		slug.val(CWA.MVC.View.createSlug($("#Title").val()));
	}
});

$("#slug-gen").click(function (e) {
	e.preventDefault();
	$("#Slug").val(CWA.MVC.View.createSlug($("#Title").val()));
});

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

</script>
