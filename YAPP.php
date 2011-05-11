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
	<form enctype="multipart/form-data" action="YAPP.php" method="POST">
		<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
		Choose a .csv file to upload: <input name="uploadedFile" type="file" /><br />
		<input type="submit" value="Upload File" />
	</form>

<?php

if($_FILES['uploadedFile'])
{
	$targetPath = './' . $uploadDir . basename($_FILES['uploadedFile']['name']);

	if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $targetPath)) {
		echo('The file ' .  basename($_FILES['uploadedFile']['name']) . ' has been uploaded<br />');
		echo('Converting...<br />');
		if(file_exists('./'.$destDir.$destName))
		{
			unlink('./'.$destDir.$destName);
		}
		mkdir($tempDir);
		chdir('./' . $tempDir);
		exec('../genYAPP.php ' . '.' . $targetPath);
		exec('ls -R ./*', $filesCreated);
		exec('zip -r ../' . $destDir . $destName . ' .');
		chmod('../' . $destDir . $destName, 0755);
		echo('<a href="./' . $destDir . $destName . '" >Download ' . $destName . '</a><br />');
		chdir('../');
		exec('rm -rf ' . $tempDir);
		echo('<br />Files produced:<br />');
		foreach($filesCreated as $file)
		{
			echo($file . '<br />');
		}
	}
	else
	{
		echo("There was an error uploading the file, please try again!");
	}
}
else
{
?>
	<h2>Instructions</h2>
	<p>Please input a .csv file exported from Excel.  This will be converted to a a zip file containing a series of .yapp files in a directory structure as shown below and a file containing the filenames in a text file for easy copy pasting at runtime.</p>
	<ul>
		<li>fileNames060511.txt</li>
		<li>01/
			<ul>
				<li>Up_d3c5.yapp</li>
				<li>Up_d2c5.yapp</li>
				<li>...</li>
			</ul>
		</li>
		<li>02/
			<ul>
				<li>Dwn_d3c10_d2c10_t25</li>
				<li>Dwn_d3c10_d2c10_t20</li>
				<li>...</li>
			</ul>
		</li>
		<li>03/
			<ul>
				<li>Dwn_d3c10_d2c10_t30</li>
				<li>Dwn_d3c10_d2c10_t15</li>
				<li>...</li>
			</ul>
		</li>
		<li>04/
			<ul>
				<li>Dwn_d3c13_d2c13_t35</li>
				<li>...</li>
			</ul>
		</li>
	</ul>
<?php
}
?>
	</body>
</html>
