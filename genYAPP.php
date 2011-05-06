#!/usr/bin/php
<?php

$inFile = fopen($argv[1], 'r');

fgets($inFile);	//skip header line
$fileNames = array();

//loop through lines
while(($currentLine = fgets($inFile)) !== false)
{
	//read in the relavant information into currentYAPP
	$currentYAPP = array();
	$lineArray = explode(',', $currentLine);
	$currentYAPP['fileName'] = $lineArray[18];
	$currentYAPP['direction'] = $lineArray[16];
	$currentYAPP['3cDelay'] = $lineArray[9];
	$currentYAPP['2cDelay'] = $lineArray[10];
	$currentYAPP['correlationDelay'] = $lineArray[11];
	if($lineArray[13])
	{
		$currentYAPP['repetitions'] = $lineArray[13];
	}
	else
	{
		$currentYAPP['repetitions'] = $lineArray[14];
	}
	$currentYAPP['set'] = $lineArray[17];
	$currentYAPP['YAPPName'] = $lineArray[12];

	if($currentYAPP['fileName']!='')
	{
		//create a directory for the YAPP set if none exists
		$dirName = './' . str_pad($currentYAPP['set'], 2, '0', STR_PAD_LEFT);
		if(!is_dir($dirName))
		{
			mkdir($dirName);
		}

		//create the YAPP file
		$outFile = fopen($dirName . '/' . $currentYAPP['YAPPName'] . '-' . $currentYAPP['repetitions'] . '.yapp', 'w');

		//generate the YAPP file (yay, hard coded strings /o\)
		fwrite($outFile, '<yex10 measDir="C:\Program Files\YAPP\24Marchtest\yapp-24March2011\24Marchtest\test\LasTim-testFull3C2C-15Feb11.yapp Measurements\" description="">
    <measurements />
');
		fwrite($outFile, '    <experiment0 loopDelay="333" loops="' . $currentYAPP['repetitions'] . '">
');
		fwrite($outFile, '        <hardware hx="86" hy="-174">
            <cameras />
            <pulseGens>
                <AcutePkPg ds="" dx="147" dy="-91">
                    <chan1 nm="LaserA:1 Trig1 Flash" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan2 nm="LaserA:2 Trig1 Flash" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan3 nm="LaserB:1 Trig1 Flash" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan4 nm="LaserB:2 Trig1 Flash" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan5 nm="LaserC:1 Trig1 Flash" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan6 nm="LaserC:2 Trig1 Flash" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan7 nm="LaserA:1 Trig2 Q" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan8 nm="LaserA:2 Trig2 Q" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan9 nm="LaserB:1 Trig2 Q" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan10 nm="LaserB:2 Trig2 Q" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan11 nm="LaserC:1 Trig2 Q" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan12 nm="LaserC:2 Trig2 Q" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan14 nm="Cam 1" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan15 nm="Cam 2" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                    <chan16 nm="2C-Cam3" ts="1" dc="0" dl="1" dr="1" dp="0" dt="20.0000" />
                </AcutePkPg>
            </pulseGens>
            <motorDrivers />
            <measDevices />
            <ports />
            <slaves />
        </hardware>
        <variables>
            <variable nm="myTime" vt="0" sv="0" lf="0" lt="0" lh="1" kv="" ks="0" eq="" lz="1" id="0" />
            <variable nm="myTimeLasers" vt="0" sv="0" lf="0" lt="0" lh="1" kv="" ks="0" eq="" lz="1" id="1" />
        </variables>
        <setupActions />
        <acquisitionActions>
            <aPulseArb hw="0" tr="0">
');
		if($currentYAPP['3cDelay'] != '')
		{
			if($currentYAPP['correlationDelay'] != '')
			{
				fwrite($outFile, '                <ch1>
                    <pulse sv="' . ($currentYAPP['correlationDelay']*1000) . '" so="10" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch1>
');
			}
			else
			{
				fwrite($outFile, '                <ch1>
                    <pulse sv="1000" so="0" sp="0" se="0" ev="1" eo="0" ep="0" ee="3" />
                </ch1>
');
			}
			fwrite($outFile, '                <ch2>
                    <pulse sv="-161.3" so="7" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch2>
');
			fwrite($outFile, '                <ch3>
                    <pulse sv="0" so="0" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch3>
                <ch4>
                    <pulse sv="-160" so="9" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch4>
');
		}
		if($currentYAPP['2cDelay'] != '')
		{
			fwrite($outFile, '                <ch5>
                    <pulse sv="0" so="0" sp="0" se="0" ev="1" eo="0" ep="0" ee="3" />
                </ch5>
                <ch6>
                    <pulse sv="-160" so="11" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch6>
');
			}
			if($currentYAPP['3cDelay'] != '')
			{
			fwrite($outFile, '                <ch7>
                    <pulse sv="159.8" so="0" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch7>
');
			if($currentYAPP['direction'] == 'Dwn')
			{
				fwrite($outFile, '                <ch8>
                    <pulse sv="' . $currentYAPP['3cDelay'] . '" so="6" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch8>
');
			}
			else
			{
				fwrite($outFile, '                <ch8>
                    <pulse sv="-' . $currentYAPP['3cDelay'] . '" so="6" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch8>
');
			}
			fwrite($outFile, '                <ch9>
                    <pulse sv="160" so="2" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch9>
');
			if($currentYAPP['direction'] == 'Dwn')
			{
				fwrite($outFile, '                <ch10>
                    <pulse sv="' . $currentYAPP['3cDelay'] . '" so="8" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch10>
');
			}
			else
			{
			fwrite($outFile, '                <ch10>
                    <pulse sv="-' . $currentYAPP['3cDelay'] . '" so="8" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch10>
');
			}
		}
		if($currentYAPP['2cDelay'] != '')
		{
			fwrite($outFile, '                <ch11>
                    <pulse sv="160" so="4" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch11>
');
			fwrite($outFile, '                <ch12>
                    <pulse sv="' . $currentYAPP['2cDelay'] . '" so="10" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch12>
');
		}
		if($currentYAPP['3cDelay'] != '')
		{
			if($currentYAPP['direction'] == 'Dwn')
			{
			fwrite($outFile, '                <ch14>
                    <pulse sv="-5.5" so="6" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch14>
                <ch15>
                    <pulse sv="-5.5" so="6" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch15>
');
			}
			else
			{
				fwrite($outFile, '                <ch14>
                    <pulse sv="-5.5" so="7" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch14>
                <ch15>
                    <pulse sv="-5.5" so="7" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch15>
');
			}
		}
		if($currentYAPP['2cDelay'] != '')
		{
			fwrite($outFile, '                <ch16>
                    <pulse sv="-5.5" so="10" sp="0" se="1" ev="1" eo="0" ep="0" ee="3" />
                </ch16>
');
		}
		fwrite($outFile, '            </aPulseArb>
            <aTimer vn="myTimeLasers" />
        </acquisitionActions>
        <processingActions />
        <concludingActions />
    </experiment0>
</yex10>
');

		fclose($outFile);
	}
	array_push($fileNames, $currentYAPP['fileName']);
	//print_r($currentYAPP);
}

fclose($inFile);

$fileNamesOut = fopen('fileNames'.date('dmy').'.txt', 'w');
foreach($fileNames as $name)
{
	fwrite($fileNamesOut, $name."\r\n");
}
fclose($fileNamesOut);

?>
