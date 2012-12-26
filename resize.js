
var imageHeight;
var imageWidth;
var flag;

function init()
{
	// Flag=0 means Original
	// Flag=1 means Resized
	flag=0;
	imageWidth = $("mainphoto").width;
	imageHeight = $("mainphoto").height;
	if(imageWidth>(screen.width-400))
	{
		imageHeight = $("mainphoto").height;
		toggleSize();
	}
	if(imageHeight>(screen.Height-400))
	{
		imageWidth = $("mainphoto").width;
		toggleSize();
	}
	
	toggleSizeImg();
}

function toggleSizeImg()
{
	if(imageHeight>(screen.height-400))
	{
		toggleSizeHeight();
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

function toggleSizeHeight()
{	
	if(flag==0)
	{
		// Get image aspect ratio
		var ratio = (imageHeight/imageWidth);
		var newHeight = (screen.height-400);
		var newWidth = (screen.height-400)/ratio;;
		
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
