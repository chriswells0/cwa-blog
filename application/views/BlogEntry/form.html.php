<?php
require_once 'views/_shared/status.html.php';
?>
			<div class="content">
				<h1>Blog Entry</h1>
				<div class="content-body">
					<form id="blog-entry" action="/blog/save" method="post" enctype="multipart/form-data">
						<input type="hidden" name="ID" id="ID" value="<?= $BlogEntry->ID ?>" />
						<div class="form-field">
							<label for="Title">Title</label>
							<input type="text" name="Title" id="Title" value="<?= $BlogEntry->Title ?>" placeholder="User Friendly Title" autofocus required minlength="3" maxlength="50" />
						</div>
						<div class="form-field">
							<label for="Slug">Slug</label>
							<input type="text" name="Slug" id="Slug" value="<?= $BlogEntry->Slug ?>" placeholder="url-friendly-slug" required minlength="3" maxlength="50" />
							<button type="button" id="slug-gen">Generate</button>
						</div>
						<div class="form-field">
							<label for="Summary">Summary</label>
							<div class="form-field">
								<textarea name="Summary" id="Summary" placeholder="1-2 sentences (up to 160 characters) summarizing this blog entry." required minlength="5" maxlength="160" ><?= $BlogEntry->Summary ?></textarea>
								<span><span id="charsLeft">160</span> characters remaining</span>
							</div>
						</div>
						<div class="form-field">
							<label for="Body">Body</label>
							<div class="form-field">
								<textarea name="Body" id="Body" minlength="5" maxlength="21200"><?= $BlogEntry->Body ?></textarea>
							</div>
						</div>
						<div class="form-field">
							<label for="Tags[]">Tags</label>
							<select name="Tags[]" id="Tags[]" multiple="multiple" size="10">
<?php
foreach($Tags as $Tag) {
	echo "<option value=\"$Tag->ID\"" . (in_array($Tag->ID, $BlogEntryTagIDs) ? ' selected="selected"' : '') . ">$Tag->Value</option>";
}
?>
							</select>
						</div>
						<div class="form-field">
							<label for="IsPublic">Public</label>
							<input type="hidden" name="IsPublic" value="0" />
							<input type="checkbox" name="IsPublic" id="IsPublic" value="1" <?= is_null($BlogEntry->Published) ? '' : 'checked="checked"' ?> />
							<input type="hidden" name="Published" value="<?= $BlogEntry->Published ?>" />
						</div>
						<div class="buttons">
							<button type="submit">Save</button>
							<button type="button" onclick="document.location='/blog/admin'; return false;">Cancel</button>
						</div>
					</form>
				</div>
			</div>

<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script>

tinymce.init({
	body_class: "content",
	body_id: "wrapper",
	browser_spellcheck: true,
	content_css: "/styles/main.css?nocache=" + Math.random(),
	convert_urls: false,
	importcss_append: true,
	importcss_groups: [{title: "Custom Styles"}],
	plugins: "code fullscreen image importcss link preview table wordcount",
	rel_list: [
		{ title: "None", value: "" },
		{ title: "External", value: "external" },
		{ title: "No Follow", value: "nofollow" },
		{ title: "External and No Follow", value: "external,nofollow" }
	],
	selector: "#Body",
	setup: function (editor) {
		var warning = "You have unsaved changes on this page!";
		editor.on("change", function (e) {
			$(window).bind("beforeunload", function (e) {
				if (warning !== null) {
					(e || window.event).returnValue = warning;
					return warning;
				}
			});
		});
		editor.on("submit", function (e) {
			warning = null;
		});
	}
});

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

$("#blog-entry").submit(function (e) {
	if ($("#Summary").val().indexOf('"') !== -1) {
		if (confirm("The summary cannot contain double quotes.\nMay I convert them to single quotes for you?")) {
			$("#Summary").val($("#Summary").val().replace(/"/g, "'"));
		}
		return false;
	}
	return true;
});

</script>
