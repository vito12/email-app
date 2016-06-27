<?php
error_reporting(E_ALL ^ E_WARNING);
	function findAndCompare(){
		$firstSite=$_POST["firstSite"];
		$secondSite=$_POST["secondSite"];

		$htmlFirstSite = file_get_contents($firstSite);
		$htmlSecondSite = file_get_contents($secondSite);

		$firstArray = [];
		$secondArray = [];
		getHrefArray($firstArray,$htmlFirstSite);
		getHrefArray($secondArray,$htmlSecondSite);

		$htmlFirstSiteAnchor = file_get_contents($firstArray[0]);
		$htmlSecondSiteAnchor = file_get_contents($secondArray[0]);
		getHrefArray($firstArray,$htmlFirstSiteAnchor);
		getHrefArray($secondArray,$htmlSecondSiteAnchor);



		$result = [];
		$l1=count($firstArray);
		$l2=count($secondArray);

		for ($i=0; $i < $l1; $i++) {
			$pos = -1;
			$max = -1;
			for ($j=0; $j < $l2; $j++) { 
				similar_text($firstArray[$i]['title'] , $secondArray[$j]['title'], $perc);
				if($perc > $max) {
					$pos = $j;
					$max = $perc;
				}
			}
				$result[] = array($firstArray[$i]['href'], $secondArray[$pos]['href'], $max);


		}

		$filemane = "file";
		$filepath = $filemane.".csv";
		$fp = fopen($filepath, 'w');

		foreach ($result as $row) {
			fputcsv($fp, $row);
		}
		fclose($fp);

		header('Content-Type: application/octet-stream');
  		header("Content-Disposition: attachment; filename=" . $filepath);
  		header('Content-Length: ' . filesize($filepath)); 
  		echo readfile($filepath);
	} 

	require('helpers.php');

	if(isset($_POST["firstSite"]) && isset($_POST["secondSite"])){
		findAndCompare();
		die();
	}
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Web App</title>
		<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
		<style>
			html, body {
			    height: 100%;
			}

			body {
			    margin: 0;
			    padding: 0;
			    width: 100%;
			    display: table;
			}

			.container {
			    text-align: center;
			    display: table-cell;
			    vertical-align: middle;
			}
		</style>
	</head>
	<body>

		<form action="/" method="POST" class="container">
			<label for="First site">Insert first site</label>

			<br>

			<input type="text" name="firstSite" id="firstSite" placeholder="http://www.cresceredigitale.it">

			<br><br>

			<label for="Second Site">Insert second site</label>

			<br>

			<input type="text" name="secondSite" id="secondSite" placeholder="http://instilla.it">

			<br><br>

			<button type="submit" name="submit">Submit</button>
		</form>
	</body>
</html>