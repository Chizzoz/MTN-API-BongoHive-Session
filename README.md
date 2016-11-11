#MTN-API-BongoHive-Session

**Code and notes for MTN API session at Bongo Hive**

So, Bongo Hive was gracious enough to present a platform for developers to share their experiences with the MTN API and also attract businesses, individuals, entusiasts, etc, interested in utilising MTN services, to see what power can be harnessed from this platform.

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
  - To start testing a specific MTN API service, you need to download the relevant WSDL file from the resources page and import it into a new SOAPUI project, then you can use the SOAP messages specified in the [API reference documentaion](https://developer.mtn.com/community/portal/site.action?s=devsite&c=Resources&osIds=DEV2000001,DEV2000002,DEV2000003,DEV2000004,DEV2000005&categoryId=DEV1000002&apiResource=yes). With your SOAPUI project setup, you can create mock services that will emulate the MTN API server.
7. Alternative method to implement demo service using PHP
8. Creating API
