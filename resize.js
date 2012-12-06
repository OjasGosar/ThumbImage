
var imageHeight;
var imageWidth;
var flag;

function init()
{
	// Flag=0 means Original
	// Flag=1 means Resized
	flag=0;
	imageWidth = $("mainphoto").width;

	if(imageWidth>(screen.width-400))
	{
		imageHeight = $("mainphoto").height;
		toggleSize();
	}
	
	

}

function toggleSizeImg()
{
	if(imageWidth>(screen.width-400))
	{
		toggleSize();
	}
}

function toggleSize()
{	
	if(flag==0)
	{
		// Get image aspect ratio
		var ratio = (imageWidth/imageHeight);
		var newWidth = (screen.width-400);
		var newHeight = (screen.width-400)/ratio;
		
		$("mainphoto").height=newHeight;
		$("mainphoto").width=newWidth;
		$("sizeChanger").innerHTML="Click to View Full Size";
		flag=1;
	}
	else
	{
		$("mainphoto").height=imageHeight;
		$("mainphoto").width=imageWidth;
		$("sizeChanger").innerHTML="Click to Resize Image";	
		flag=0;
	}
}
