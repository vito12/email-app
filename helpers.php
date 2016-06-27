<?php
	function getHrefArray(&$array, $html){
		$dom = new DOMDocument;
		$dom->loadHTML($html);
		$xpath = new DOMXPath($dom);
		$nodes = $xpath->query('//a/@href');
		foreach($nodes as $href) {

			$url = $href->nodeValue;
			$html = file_get_contents($url);
			$dom = new DOMDocument;
		    $dom->loadHTML($html);
			$xpath = new DOMXPath($dom);
			$nodes = @$xpath->query('//title');


			$array[] = [
				'href' => $url,
				'title' => @$nodes->item(0)->nodeValue
			];
			// echo $url;
			// echo " - ";
			// echo $nodes->item(0)->nodeValue;
			// echo "<br>";
		}
		//var_dump($array);
	}

