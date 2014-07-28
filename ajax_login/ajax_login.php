<html>
<body>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
</head>
<!-- edit action url -->
<form name="webmail" action="http://control.roland-liebl.de/webmail/index.php" method="post">
	<div class="info" style="color:#f00;display:none"></div>
	
	<input name="_action" value="login" type="hidden" />
	<input name="_timezone" id="rcmlogintz" value="_default_" type="hidden" />
        <input name="ajax" value="1" type="hidden" />
	
	User <input name="_user" type="text" /><br>
	Pass <input name="_pass" type="password" /><br>
	
	<input type="submit">

</form>

<script type="text/javascript">
var d = new Date();
document.getElementById("rcmlogintz").value = d.getTimezoneOffset() / -60;
<?PHP
$message = '';
if(isset($_GET['message'])){
  $message = urldecode(trim($_GET['message']));
}
?>
$('div.info').html("<?PHP echo $message ?>");
$('div.info').show();
</script>

</body>
</html>