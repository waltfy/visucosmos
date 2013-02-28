//This file saves file into a text file

<!DOCTYPE html>
<html>
<body>

<?php

echo "This file works";

$file = "testFile.txt";

$fw = fopen($file, 'w') or die("File cannot be opened!");

//Data to be written

//Field names
$data = "userid,visualisation,date,time\n";
fwrite($fw, $data);

/*
	$userid = $i + 1;
	$visualisation = 'Some visualisation';
	$date = date("Y/m/d");
	$time = time();
*/

//$data = "2" . "," . "Some visualisation" . "," . "Feb 12 2013" . "," . "23:59" . "," \n;

for ($i =0; $i < 10; $i++) 
{

	$data = "2,Some visualisation,Feb 12 2013,23:59,\n";

	fwrite($fw, $data);
	
}
	fclose($fw);

?>

</body>
</html>