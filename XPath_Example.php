<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>XPath Example</title>
</head>

<body>
<?php
	/*
	* Sample Book Store XML manipulation using XPath
	*/
	$SAMPLE_RESPONSE= <<<XML
<?xml version="1.0" encoding="UTF-8"?>

<bookstore>
  <book>
    <title lang="en">Harry Potter</title>
    <author>J K. Rowling</author>
    <year>2005</year>
    <price>29.99</price>
  </book>
  <book>
    <title lang="en">Bitterness (An African Novel from Zambia)</title>
    <author>Malama Katulwende </author>
    <year>2005</year>
    <price>14.66</price>
  </book>
  <book>
    <title lang="en">Glimmers of Hope : A Memoir of Zambia</title>
    <author>Mark Burke</author>
    <year>2010</year>
    <price>15.98</price>
  </book>
  <book>
    <title lang="en">Salaula: The World of Secondhand Clothing and Zambia</title>
    <author>Karen Tranberg Hansen</author>
    <year>2000</year>
    <price>30.60</price>
  </book>
</bookstore>
XML;
	
	$response_xml = new SimpleXMLElement(strstr($SAMPLE_RESPONSE, '<'));
	
	echo '<hr>';
	
	foreach ($response_xml->xpath('//bookstore/book') as $book) {
		foreach ($book->children() as $book_details) {
			if (!empty($book_details)) {
				echo $book_details->getName() . ": " . strval($book_details) . "<br>";
			}
		}
		echo '<hr>';
	}
?>
</body>
</html>