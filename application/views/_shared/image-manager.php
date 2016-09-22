					<div id="image-manager">
						<h2>Images</h2>
<?php
$imagesURL = "/images$ControllerURL"; // URL to all of the images for this controller. -- cwells
if (empty($imageDir)) {
?>
						<p>You must save this item before images can be added.</p>
<?php
} else {
?>
						<form id="add-image" name="add-image" method="post" action="<?= "$ControllerURL/image" ?>" enctype="multipart/form-data">
							<div class="form-field">
								<label>Image Path</label><?= "$imagesURL/$imageDir" ?>
							</div>
							<div id="image-loading" class="loading"><progress id="image-progress" value="0" max="100">Uploading: <span>0</span>%</progress></div>
							<div class="form-field">
								<input type="hidden" name="action" value="add" />
								<input type="hidden" name="Path" value="<?= $imageDir ?>" />
								<label for="image">Add Image</label>
								<input type="file" id="image" name="image" value="" accept="image/*,.gif,.jpg,.jpeg,.png,.tif,.tiff" required />
								<button type="submit">Upload</button>
								<div id="image-error" class="error"></div>
							</div>
						</form>
						<ul id="image-list">
<?php
	foreach ($Images as $image) {
		$imagePath = "$imageDir/$image";
?>
							<li>
								<a href="<?= "$imagesURL/$imagePath" ?>"><img src="<?= "$imagesURL/$imagePath" ?>" /></a>
								<p class="caption"><?= $image ?></p>
								<div class="actions">
									<span class="links">
										<a class="edit" href="<?= "$ControllerURL/image/$imagePath" ?>" title="Edit this item">Edit</a>
										|
										<a class="delete" href="<?= "$ControllerURL/image/delete/$imagePath" ?>" title="Delete this item">Delete</a>
									</span>
								</div>
							</li>
<?php
	}
?>
						</ul>
						<div id="image-actions">
							<div class="actions">
								<span class="links">
									<a class="edit" href="<?= "$ControllerURL/image/" ?>" title="Edit this item">Edit</a>
									|
									<a class="delete" href="<?= "$ControllerURL/image/delete/" ?>" title="Delete this item">Delete</a>
								</span>
							</div>
							<form id="edit-image" name="edit-image" method="post" action="<?= "$ControllerURL/image" ?>">
								<input type="hidden" name="action" value="edit" />
								<input type="hidden" name="Path" value="" />
								<input type="text" name="Name" value="" placeholder="New Name" autofocus required minlength="1" size="17" />
								<div class="buttons">
									<button type="submit">Save</button>
									<button class="cancel" type="button" data-cwa-click="resetImageManager">Cancel</button>
								</div>
							</form>
						</div>
<?php
}
?>
					</div>

<script>

function resetImageManager() {
	var form = CWA.DOM.forms["edit-image"];
	form.$.hide();
	form.clearErrors();
	form.reset();
	$(".caption").show();
	$(".actions > .links").show();
}

function addImageToList(image) {
	var actions = $("#image-actions > .actions").clone(),
		imageList = $("#image-list"),
		images = imageList.find("li"),
		inserted = false,
		newImage = $("<li />");

	$("<a />", {
		"href": "<?= "$imagesURL/" ?>" + image.Path
	}).append($("<img />", {
		"src": "<?= "$imagesURL/" ?>" + image.Path
	})).appendTo(newImage);
	$("<p />", {
		"class": "caption",
		"text": image.Name
	}).appendTo(newImage);
	actions.find(".edit").attr("href", actions.find(".edit").attr("href") + image.Path);
	actions.find(".delete").attr("href", actions.find(".delete").attr("href") + image.Path);
	actions.appendTo(newImage);
	images.each(function (index) {
		if (image.Name < $(this).find("p.caption").text()) {
			newImage.insertBefore($(this));
			inserted = true;
			return false;
		}
	});
	if (!inserted) {
		newImage.appendTo(imageList);
	}
}

$("#add-image").submit(function (e) {
	var fieldWrapper = $("#image").parent(),
		form = CWA.DOM.forms["add-image"],
		formData = new FormData(this),
		loading = $("#image-loading"),
		progress = $("#image-progress"),
		supportsProgress = progress.length !== 0,
		warning = "Image upload in progress! Are you sure you want to leave?";
	e.preventDefault();
	if (form.getErrorCount() === 0) {
		$("#image-error").text("");
		fieldWrapper.hide();
		loading.show();
		$(window).bind("beforeunload", function (e) {
			if (warning !== null) {
				(e || window.event).returnValue = warning;
				return warning;
			}
		});
		$.ajax({
			type: "POST",
			url: form.$.attr("action"),
			data: formData,
			dataType: "json",
			// For the file upload:
			cache: false,
			contentType: false,
			processData: false,
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function (e) {
					if (e.lengthComputable) {
						var percent = (e.loaded / e.total) * 100;
						progress.val(percent);
						progress.find("span").text(percent);
					} else if (supportsProgress) {
						supportsProgress = false;
						progress.remove();
						$("<img />", { "src": "/images/loading.gif" }).appendTo(loading);
					}
				}, false);
				return xhr;
			}
		}).always(function (response, textStatus, jqXHR) {
			warning = null;
			if (response.status && response.status.code === 200) {
				loading.hide();
				form.reset();
				fieldWrapper.show();
				if (supportsProgress) {
					progress.val("0");
					progress.find("span").text("0");
				}
				addImageToList(response.data.File);
			} else {
				var responseJSON = response.responseJSON || { "status": { "message": "An unspecified error has occurred. Please try again." }};
				loading.hide();
				fieldWrapper.show();
				$("#image-error").text(responseJSON.status.message);
			}
		});
	}
});

$("#image-manager").on("click", ".edit", function (e) {
	var link = $(this),
		actions = link.parent().parent(),
		form = CWA.DOM.forms["edit-image"],
		href = link.attr("href"),
		itemID = href.substr(href.indexOf("/image/") + 7);
	e.preventDefault();
	resetImageManager();
	actions.siblings(".caption").hide();
	actions.find(".links").hide();
	$(form.elements["Path"]).val(itemID);
	$(form.elements["Name"]).val(itemID.substring(itemID.lastIndexOf("/") + 1));
	form.$.appendTo(actions);
	form.$.show();
	form.$.find("input").focus();
});

$("#edit-image").submit(function (e) {
	var form = CWA.DOM.forms["edit-image"],
		actionLinks = form.$.prev();
	e.preventDefault();
	if (!form.hasChanged()) {
		alert("No changes have been made!");
		return;
	}
	if (form.getErrorCount() === 0) {
		form.$.hide();
		actionLinks.show();
		$.post(form.$.attr("action"),
			form.$.serialize(),
			null,
			"json"
		).always(function (response, textStatus, jqXHR) {
			if (response.status && response.status.code === 200) {
				form.$.appendTo($("#image-actions"));
				actionLinks.parents("li").remove();
				addImageToList(response.data.File);
			} else {
				var responseJSON = response.responseJSON || { "status": { "message": "An unspecified error has occurred. Please try again." }};
				actionLinks.hide();
				form.$.show();
				form.setError($(form.elements['Name']), responseJSON.status.message);
			}
		});
	}
});

$(document).ready(function () { // Replace the default delete handler. -- cwells

	$("#image-manager .delete").off("click", CWA.MVC.View.confirmDelete);

	$("#image-manager").on("click", ".delete", function (e) {
		e.preventDefault();
		if (confirm("Are you sure you want to delete this item?")) {
			var link = $(this),
				href = link.attr("href"),
				itemID = href.substr(href.indexOf("/delete/") + 8),
				postData = { "itemID": itemID };
			postData[CWA.MVC.View.syncToken.name] = CWA.MVC.View.syncToken.value;
			$.ajax({
				type: "POST",
				url: href,
				data: postData,
				dataType: "json",
				complete: function (jqXHR) {
					var response = jqXHR.responseJSON,
						unknownError = "An error occurred while deleting the specified item.";
					if (!response || !response.status) {
						alert(unknownError);
					} else if (response.status.code !== 200) {
						alert(response.status.message || unknownError);
					} else { // The item was deleted. -- cwells
						CWA.DOM.forms["edit-image"].$.appendTo($("#image-actions"));
						link.parents("li").remove();
					}
				}
			});
		}
	});
});

</script>
