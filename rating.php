<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Insert title here</title>
<style type="text/css">
#rateStatus {
	float: left;
	clear: both;
	width: 100%;
	height: 20px;
}

#rateMe {
	float: left;
	clear: both;
	width: 100%;
	height: auto;
	padding: 0px;
	margin: 0px;
}

#rateMe li {
	float: left;
	list-style: none;
}

#rateMe li a:hover,#rateMe .on {
	background: url(./images/star_on.gif) no-repeat;
}

#rateMe a {
	float: left;
	background: url(./images/star_off.gif) no-repeat;
	width: 12px;
	height: 12px;
}

#ratingSaved {
	display: none;
}

.saved {
	color: red;
}
</style>
</head>
<body>
	<div class="code">


		<script type="text/javascript" language="javascript"
			src="ratingsys.js"></script>
		<span id="rateStatus">Rate Me...</span> <span id="ratingSaved">Rating
			Saved!</span>
		<div id="rateMe" title="Rate Me...">
			<a onclick="rateIt(this)" id="_1" title="ehh..."
				onmouseover="rating(this)" onmouseout="off(this)" class="on"></a> <a
				onclick="rateIt(this)" id="_2" title="Not Bad"
				onmouseover="rating(this)" onmouseout="off(this)" class="on"></a> <a
				onclick="rateIt(this)" id="_3" title="Pretty Good"
				onmouseover="rating(this)" onmouseout="off(this)"></a> <a
				onclick="rateIt(this)" id="_4" title="Out Standing"
				onmouseover="rating(this)" onmouseout="off(this)"></a> <a
				onclick="rateIt(this)" id="_5" title="Freakin' Awesome!"
				onmouseover="rating(this)" onmouseout="off(this)"></a>
		</div>
	</div>
</body>
</html>