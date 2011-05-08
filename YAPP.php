<?php

$uploadDir = 'xlsx/';
$destDir = 'yapps/';
$destName = 'yappsFor' . date('dmy') . '.zip';
$tempDir = 'temp/';

?>
<html>
	<head>
	</head>
	<body>

<?php

if($_FILES['uploadedFile'])
{
	$targetPath = './' . $uploadDir . basename($_FILES['uploadedFile']['name']);

	if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $targetPath)) {
		echo('The file ' .  basename($_FILES['uploadedFile']['name']) . ' has been uploaded<br />');
		echo('Converting...<br />');
		unlink('./'.$destDir.$destName);
		mkdir($tempDir);
		chdir('./' . $tempDir);
		exec('../genYAPP.php ' . '.' . $targetPath);
		exec('zip -r ../' . $destDir . $destName . ' .');
		chmod('../' . $destDir . $destName, 0755);
		echo('<a href="./' . $destDir . $destName . '" >Download</a><br />');
		chdir('../');
		exec('rm -rf ' . $tempDir);
	}
	else
	{
		echo("There was an error uploading the file, please try again!");
	}
}
?>
	<form enctype="multipart/form-data" action="YAPP.php" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
		Choose a .csv file to upload: <input name="uploadedFile" type="file" /><br />
		<input type="submit" value="Upload File" />
	</form>
<?php

?>
	</body>
</html>
