var MAXUPLOADS = 5;
var boxcount = 1;

function checkType(ctrl) {
	var filenameArr = ctrl.value.split(".");
	type = filenameArr[filenameArr.length - 1].toLowerCase();

	if (!(type == "jpg" || type == "png" || type == "gif" || type == "jpeg")) {
		alert("You have selected "
				+ type
				+ " filetype to upload which is not allowed. Please choose jpg,png,jpeg,gif formats only.")
		ctrl.value = "";
	}
}

function createUploadControl() {
	if (boxcount == MAXUPLOADS) {
		alert("You cannot upload more than " + MAXUPLOADS
				+ " photos at one time");
	} else {
		// create controls container
		var newUploadContainer = document.createElement('div');

		// create <input> control - for uploading file
		var newUploadControl = document.createElement('input');

		// create <input> control - for removing other controls
		var newUploadRemove = document.createElement('input');

		// create <input> control - for Title of the file
		var newTitleControl = document.createElement('input');

		// set box count
		boxcount = boxcount + 1;

		// set Upload control attributes
		newUploadControl.setAttribute('type', 'file');
		newUploadControl.setAttribute('onBlur', 'checkType(this)');
		newUploadControl.setAttribute('name', 'upload' + boxcount);
		newUploadControl.setAttribute('class', 'fileUpload');

		// set title control attributes
		newTitleControl.setAttribute('type', 'text');
		// newTitleControl.setAttribute('onBlur','checkType(this)');
		newTitleControl.setAttribute('name', 'title' + boxcount);
		newTitleControl.setAttribute('class', 'textTitle');

		// newUploadContainer.setAttribute('class','uploadControl');
		newUploadContainer.setAttribute('style', 'margin-top:2px;');

		// set remove control attributes
		newUploadRemove.setAttribute('type', 'button');
		newUploadRemove.setAttribute('value', 'Remove');
		// newUploadRemove.setAttribute('name', 'Remove'+boxcount);
		newUploadRemove.setAttribute('onClick', 'deleteUploadControl(this)');

		// $("fileup").appendChild(newUploadContainer);
		newUploadContainer.appendChild(newUploadControl);
		newUploadContainer.appendChild(newUploadRemove);
		// newUploadContainer.appendChild(newTitleControl);

		var table = document.getElementById("fileupTable");

		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);

		var cell1 = row.insertCell(0);
		cell1.appendChild(newUploadContainer);

		var cell2 = row.insertCell(1);
		cell2.innerHTML = "Title:";

		var cell3 = row.insertCell(2);
		cell3.appendChild(newTitleControl);
	}
}

function deleteUploadControl(removeCtrl) {

	/*
	 * try { var table = document.getElementById("fileupTable"); var rowCount =
	 * table.rows.length; table.deleteRow(--removeCtrl); } catch (e) { alert(e); }
	 */
	removeCtrl.parentNode.parentNode.parentNode.parentNode
			.removeChild(removeCtrl.parentNode.parentNode.parentNode);
	/*
	 * removeCtrl.parentNode.removeChild(removeCtrl.previousSibling);
	 * removeCtrl.parentNode.removeChild(removeCtrl);
	 */

	try {
		var table = document.getElementById("fileupTable");
		var rowCount = table.rows.length;

		for ( var i = 1; i < rowCount; i++) {
			var row = table.rows[i];
			var fileInput = row.getElementsByTagName("input");
			fileInput[0].setAttribute('name', 'upload' + (i+1));
			fileInput[2].setAttribute('name', 'title' + (i+1));
			// var buttonInput = row.getElementsByClassName("buttonRemove");
			//var textInput = row.getElementsByTagName("input");
			//textInput.setAttribute('name', 'title' + (i+1));
		}
	} catch (e) {
		alert(e);
	}

	// decrease box count
	boxcount = boxcount - 1;

}

function validateUploadForm() {
	uploadPhotos();
}

function uploadPhotos() {
	var actionScript = 'picupload.php?submit=true&files=' + boxcount;
	document.uploadForm.setAttribute('action', actionScript);
	document.uploadForm.submit();
}
