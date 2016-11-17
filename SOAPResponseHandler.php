<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SOAP Request & Response Handling Sample</title>
</head>

<body>
<?php
	/*
	* Sample code on how to send a SOAP request to specific server URL,
	* receive the SOAP response from server
	* and pull data from response
	* using PHP cURL Library, SimpleXMLElement and XPath Path Expressions.
	* Download WSDL file and import in SOAPUI: https://developer.mtn.com/community/portal/site.action?s=devsite&c=detailsResource&lang=en&t=web&resourceId=433&resourceName=%3Cspan%20style=%22color:#1483BB;background:#FFFFFF;">Subscribe</span>_WSDL_6_1&categoryId=&h=resourceSearch&searchName=&search=&currentPage=
	*/
	
	// This function will POST the SOAP message to the specified URL
	function doXMLCurl($url,$postXML){
		$headers = array(
			"Content-type: text/xml;charset=\"utf-8\"",
			"Accept: text/xml",
			"Cache-Control: no-cache",
			"Pragma: no-cache",
			"SOAPAction: \"run\"",
			"Content-length: ".strlen($postXML),
		); 
		$CURL = curl_init();

		curl_setopt($CURL, CURLOPT_URL, $url); 
		curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
		curl_setopt($CURL, CURLOPT_POST, 1); 
		curl_setopt($CURL, CURLOPT_POSTFIELDS, $postXML); 
		curl_setopt($CURL, CURLOPT_HEADER, false); 
		curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
		$xmlResponse = curl_exec($CURL); 

		return $xmlResponse;
	}
	// This is the SOAP message to be sent to the API, you can replace the SOAP message below with any other SOAP message you wish to test
	$REQUEST_BODY= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:loc="http://www.csapi.org/schema/parlayx/subscribe/manage/v1_0/local">
   <soapenv:Header/>
   <soapenv:Body>
      <loc:subscribeProductRequest>
         <loc:subscribeProductReq>
            <userID>
               <ID>35000001</ID>
               <type>0</type>
            </userID>
            <subInfo>
               <productID>12345678</productID>
               <!--Optional:-->
               <operCode>1</operCode>
               <!--Optional:-->
               <isAutoExtend>1</isAutoExtend>
               <channelID>1</channelID>
               <!--Optional:-->
               <extensionInfo>
                  <!--Zero or more repetitions:-->
                  <namedParameters>
                     <key>?</key>
                     <value>?</value>
                  </namedParameters>
               </extensionInfo>
            </subInfo>
         </loc:subscribeProductReq>
      </loc:subscribeProductRequest>
   </soapenv:Body>
</soapenv:Envelope>
XML;
	// Catch any error in getting response from server and return error SOAP message
	try {
		$full_response = doXMLCurl('http://localhost:9080/SubscribeManageService/services/SubscribeManage', $REQUEST_BODY);
	} catch (\Exception $e) {
		$ERROR_RESPONSE= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
   <soapenv:Body>
      <soapenv:Fault>
         <faultcode>Server</faultcode>
         <faultstring>Missing operation for soapAction [] and body element [null] with SOAP Version [SOAP 1.1]</faultstring>
      </soapenv:Fault>
   </soapenv:Body>
</soapenv:Envelope>
XML;

		return $ERROR_RESPONSE;
	}
	// Get server response and manipulate using XPath
	$response_xml = new SimpleXMLElement(strstr($full_response, '<'));
	
	echo '<hr>';
	
	foreach ($response_xml->xpath('//*[name()=\'loc:subscribeProductRsp\']/*') as $body) {
		$ns = $body->getName();
		
		echo $ns . ": " . strval($body) . "<br>";
	}
	echo '<hr>';
?>
</body>
</html>