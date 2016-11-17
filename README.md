#MTN-API-BongoHive-Session

**Code and notes for MTN API session at Bongo Hive**

So, Bongo Hive was gracious enough to setup an event for developers to share their experiences with the MTN API and also attract businesses, individuals, entusiasts, etc, interested in utilising MTN services, to see what power can be harnessed from this platform.

Event page: <a href="https://www.eventbrite.com/e/an-introduction-to-the-mtn-api-tickets-29271818798" title="An Introduction to the MTN API" target="_blank">An Introduction to the MTN API</a>

I would like to share my experience with the MTN API. If I was asked to put that into one sentence, it would be:
##A Web Approach to Integrating MTN API
And below are some highlights:

1. Introduction to [MTN Developer portal and available resources](https://developer.mtn.com/community/portal/site.action?s=devsite&c=Home "MTN Developer portal and available resources")
2. Using SDP32 Interface Simulator. [Download it and try it out](https://developer.mtn.com/community/portal/site.action?s=devsite&c=detailsResource&resourceId=150&categoryId=DEV1000005&search=DEV1000005&resourceName=SDP32_Simulator&h=firresource&currentPage=1&osIds=DEV2000001,DEV2000002,DEV2000003,DEV2000004,DEV2000005&flag=fromRight "SDP32 Interface Simulator")
3. Demo service testing
  - The MTN developers portal provides lots of demo projects, free to download and tinker with, in three flavours; C#, JAVA and PHP. [Download and test here](https://developer.mtn.com/community/portal/site.action?s=devsite&c=Resources&categoryId=DEV1000006)
4. Introducing SOAP and WSDL files
  - MTN API makes use of SOAP messages delivered over http. If you are like me, a few months ago and wondering what a SOAP message is, [READ THIS](http://www.w3schools.com/xml/xml_soap.asp).
  - So, now that you know about SOAP messages, it would be worthwhile to also learn about WSDL files, they also XML formatted files like SOAP messages, but they define the web service to be used, they are sort of the blueprint and validation rule for the SOAP message. [Learn about WSDL files](http://www.w3schools.com/xml/xml_wsdl.asp).
5. Introducing SOAPUI
  - Now, if you downloaded a demo service from the developer portal or used the SDP32 Simulator, you might be wondering why I am introducing WSDL files when you didn't even have to use them. Well, that's where [SOAPUI](https://www.soapui.org/open-source.html) comes in. What is SOAPUI? I picked this right off their website:

    > SoapUI is the world's most widely-used open source API testing tool for SOAP and REST APIs.
    
    From my experience, I found the SDP32 Simulator rather limited in services and I was not able to get a server-like response after a request from my client app. SOAPUI handles responses and requests beautifully.
    
6. Introducing Developer API Reference Documentation
  - To start testing a specific MTN API service, you need to download the relevant WSDL file from the resources page and import it into a new SOAPUI project, then you can use the SOAP messages specified in the [API reference documentaion](https://developer.mtn.com/community/portal/site.action?s=devsite&c=Resources&osIds=DEV2000001,DEV2000002,DEV2000003,DEV2000004,DEV2000005&categoryId=DEV1000002&apiResource=yes). With your SOAPUI project setup, you can create mock services that will emulate the MTN API server. I found API Reference documents to be extremely helpful in providing message flows and field specifications for messages sent. The API Reference documents include detailed sequence diagrams, sample SOAP messages and SOAP message parameter (field) specifications; like type (string, integer, etc), length, mandatory or not, etc.
7. Alternative method to implement demo service using PHP
  - I called this a web approach to integrating MTN API, if you are like me, intending to develop something that runs in the browser and not using an IDE like Eclipse EE, working with XML, SOAP, WSDL, etc pose quite a challenge. If you used a PHP demo service, you would have had to include [NuSOAP - SOAP Toolkit for PHP](https://sourceforge.net/projects/nusoap/) and [ThinkPHP2.1](http://www.thinkphp.cn/down/73.html). Including these other tools, learning how to use them, etc, proved to be too much admin, plus there was the issue of speed. Looked for alternative solutions and finally, thanks to my buddies Google and Stack Overflow, I stumbled upon a number of solutions that I incorporated to come up up with a solution I was pleased with. This involves embedding XML files directly into PHP code and manipulating SOAP responses and requests using a combination of [PHP cURL Library](http://php.net/manual/en/book.curl.php), [SimpleXMLElement](http://php.net/manual/en/class.simplexmlelement.php) and [XPath Path Expressions](http://www.w3schools.com/xml/xml_xpath.asp).

## [Sample Book Store XML manipulation using XPath](https://github.com/Chizzoz/MTN-API-BongoHive-Session/blob/master/XPath_Example.php)
```php
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
```

## [Sample code on how to send a SOAP request to specific server URL, receive the SOAP response from server and pull data from response using PHP cURL Library, SimpleXMLElement and XPath Path Expressions](https://github.com/Chizzoz/MTN-API-BongoHive-Session/blob/master/SOAPResponseHandler.php)
```php
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
```

8. Creating API
  - Lastly, you might want to extend your app beyond the browser to other mobile platforms, SMS, USSD, etc using URL queries. To do that, you will also need to create your own API that provides interaction with your app. 

So, that's about it. Thank you for your time!
