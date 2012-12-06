var MAXUPLOADS=8;
var boxcount=1;

function checkType(ctrl)
{
	var filenameArr = ctrl.value.split(".");
	type = filenameArr[filenameArr.length-1].toLowerCase();
	
	if(!(type=="jpg" || type=="png" || type=="gif" || type=="bmp" || type=="jpeg"))
	 {
		alert("You have selected "+type+" filetype to upload which is not allowed. Please choose jpg,bmp,png,jpeg,gif formats only.")
		ctrl.value=""; 
	 }
}

function createUploadControl()
{
	if(boxcount==MAXUPLOADS)
	{
		alert("You cannot upload more than "+MAXUPLOADS+" photos at one time");
	}
	else
	{
		// create controls container
			var newUploadContainer = document.createElement('div');
		
		// create <input> control - for uploading file
			var newUploadControl = document.createElement('input');
			
		// create <input> control - for removing other controls
			var newUploadRemove = document.createElement('input');
			
		// set box count
			boxcount = boxcount+1;
			
		// set control attributes
			newUploadControl.setAttribute('type','file');
			newUploadControl.setAttribute('onBlur','checkType(this)');
			newUploadControl.setAttribute('name','upload'+boxcount);
			
		//	newUploadContainer.setAttribute('class','uploadControl');
			newUploadContainer.setAttribute('style','margin-top:2px;');	
			newUploadRemove.setAttribute('type','button');
			newUploadRemove.setAttribute('value','Remove');
			newUploadRemove.setAttribute('onClick','deleteUploadControl(this)');
		
			$("fileup").appendChild(newUploadContainer);
			newUploadContainer.appendChild(newUploadControl);
			newUploadContainer.appendChild(newUploadRemove);
	}
}

function deleteUploadControl(removeCtrl)
{
	removeCtrl.parentNode.removeChild(removeCtrl.previousSibling);
	removeCtrl.parentNode.removeChild(removeCtrl);
	
// decrease box count
	boxcount = boxcount-1;

}

function validateUploadForm()
{
		uploadPhotos();	
}

function uploadPhotos()
{
	var actionScript='picupload.php?submit=true&files='+boxcount;
	document.uploadForm.setAttribute('action',actionScript);
	document.uploadForm.submit();
}
