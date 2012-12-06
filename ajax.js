function updateDispName(newName)
{
	
	
	var request = makeHttpObject();
	var reqURL = "update.php?newname="+newName;
	request.open("GET",reqURL,false);
	request.send(null);
	$("dispname").innerHTML = newName;
	$("edit").style.display="inline";
	
}

function makeHttpObject()
{

try { return new XMLHttpRequest(); }
catch (error) {}

throw new Error("Cannot create HTTP Request");

}

