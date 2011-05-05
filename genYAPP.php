#!/usr/bin/php
<?php

$inFile = fopen($argv[1], 'r');

fgets($inFile);	//skip header line
$fileNames = array();

//loop through lines
while(($currentLine = fgets($inFile)) !== false)
{
	$params = explode(',', $currentLine);
	array_push($fileNames, $params[18]);
}

fclose($inFile);

$fileNamesOut = fopen('fileNames'.date('dmy').'.txt', 'w');
foreach($fileNames as $name)
{
	fwrite($fileNamesOut, $name."\n");
}
fclose($fileNamesOut);

?>
