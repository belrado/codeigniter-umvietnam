<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>404 Page Not Found | UMVietnam</title>
<style type="text/css">

::selection { background-color: #E13300; color: white; }
::-moz-selection { background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #003399;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 26px;
	line-height:30px;
	font-weight: bold;
	margin: 0 0 14px 0;
	padding: 170px 15px 15px 15px;
	color:#0267ff;
	background:url(/assets/img/ico_default_errpage.png) no-repeat center 5px;
	background-size:190px 162px;
}
h1 span{display:block; font-weight:normal; color:#000; font-size:20px}
code {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #002166;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}
#container {
	margin: 10px;
	border: 1px solid #D0D0D0;
	box-shadow: 0 0 8px #D0D0D0;
	text-align:center;
}
.back-home{display:block; padding:10px; border-top:1px solid #D0D0D0}
p {
	margin: 12px 15px 12px 15px;
}
</style>
</head>
<body>
	<div id="container">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
		<a class="back-home" href="http://umvietnam.com/">Back UMVietnam</a>
	</div>
</body>
</html>
