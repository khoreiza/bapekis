
CSCO_add_clsid_name('CLSID:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B', 'src');
CSCO_add_clsid_name('CLSID:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B', 'href');
CSCO_add_clsid_name('CLSID:D27CDB6E-AE6D-11CF-96B8-444553540000', 'movie', 'CSCO_MangleFlashMovie');
CSCO_add_clsid_name('CLSID:D27CDB6E-AE6D-11CF-96B8-444553540000', 'src', 'CSCO_MangleFlashMovie');
CSCO_add_clsid_name('CLSID:D27CDB6E-AE6D-11CF-96B8-444553540000', 'base');
CSCO_add_clsid_name('CLSID:D27CDB6E-AE6D-11CF-96B8-444553540000', 'flashvars', 'CSCO_MangleFlashVars');
CSCO_add_clsid_name('CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95', 'FileName');
CSCO_add_clsid_name('CLSID:333C7BC4-460F-11D0-BC04-0080C7055A83', 'DataURL');

//~ Domino5 start
CSCO_add_clsid_name('CLSID:3BFFE033-BF43-11D5-A271-00A024A51325', 'General_ServerName', 'CSCO_MangleServerName');
CSCO_add_clsid_name('CLSID:3BFFE033-BF43-11D5-A271-00A024A51325', 'General_URL');
CSCO_add_clsid_name('CLSID:3BFFE033-BF43-11D5-A271-00A024A51325', 'EndBSession');
CSCO_AddWrapper("OBJECT", "getput", "General_URL", "CLSID:3BFFE033-BF43-11D5-A271-00A024A51325");
CSCO_AddWrapper("OBJECT", "call", "EndBrowserSession", "CLSID:3BFFE033-BF43-11D5-A271-00A024A51325");
//~ Domino5 end

//~ Domino6 start
CSCO_add_clsid_name('CLSID:1E2941E3-8E63-11D4-9D5A-00902742D6E0', 'General_ServerName', 'CSCO_MangleServerName');
CSCO_add_clsid_name('CLSID:1E2941E3-8E63-11D4-9D5A-00902742D6E0', 'General_URL');
CSCO_add_clsid_name('CLSID:1E2941E3-8E63-11D4-9D5A-00902742D6E0', 'EndBrowserSession');
CSCO_AddWrapper("OBJECT", "getput", "General_URL", "CLSID:1E2941E3-8E63-11D4-9D5A-00902742D6E0");
CSCO_AddWrapper("OBJECT", "call", "EndBrowserSession", "CLSID:1E2941E3-8E63-11D4-9D5A-00902742D6E0");
//~ Domino6 end

//~ Domino7 start
CSCO_add_clsid_name('CLSID:E008A543-CEFB-4559-912F-C27C2B89F13B', 'General_ServerName', 'CSCO_MangleServerName');
CSCO_add_clsid_name('CLSID:E008A543-CEFB-4559-912F-C27C2B89F13B', 'General_URL');
CSCO_add_clsid_name('CLSID:E008A543-CEFB-4559-912F-C27C2B89F13B', 'EndBrowserSession');
CSCO_add_clsid_name('CLSID:E008A543-CEFB-4559-912F-C27C2B89F13B', 'Mail_MailDbPath');
CSCO_AddWrapper("OBJECT", "getput", "General_URL", "CLSID:E008A543-CEFB-4559-912F-C27C2B89F13B");
CSCO_AddWrapper("OBJECT", "call", "EndBrowserSession", "CLSID:E008A543-CEFB-4559-912F-C27C2B89F13B");
//~ Domino7 end

//~ Domino8 start
CSCO_add_clsid_name('CLSID:983A9C21-8207-4B58-BBB8-0EBC3D7C5505', 'General_ServerName', 'CSCO_MangleServerName');
CSCO_add_clsid_name('CLSID:983A9C21-8207-4B58-BBB8-0EBC3D7C5505', 'General_URL');
CSCO_add_clsid_name('CLSID:983A9C21-8207-4B58-BBB8-0EBC3D7C5505', 'EndBrowserSession');
CSCO_add_clsid_name('CLSID:983A9C21-8207-4B58-BBB8-0EBC3D7C5505', 'Mail_MailDbPath');
CSCO_AddWrapper("OBJECT", "getput", "General_URL", "CLSID:983A9C21-8207-4B58-BBB8-0EBC3D7C5505");
CSCO_AddWrapper("OBJECT", "call", "EndBrowserSession", "CLSID:983A9C21-8207-4B58-BBB8-0EBC3D7C5505");
//~ Domino8 end

//~ Domino8.5 start
CSCO_add_clsid_name('CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A', 'General_ServerName', 'CSCO_MangleServerName');
CSCO_add_clsid_name('CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A', 'General_URL');
CSCO_add_clsid_name('CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A', 'EndBrowserSession');
CSCO_add_clsid_name('CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A', 'Mail_MailDbPath');
CSCO_AddWrapper("OBJECT", "getput", "General_URL", "CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A");
CSCO_AddWrapper("OBJECT", "call", "EndBrowserSession", "CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A");
//~ AlternateCLSID for IBM Lotus iNotes 8.5 Control
//~ There is AlternateCLSID for IBM Lotus iNotes 8.5 Control registered with CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C that is newer than previous one with CLSID:75AA409D-05F9-4F27-BD53-C7339D4B1D0A
//~ Fix for bugs: CSCty52919, CSCty40068, CSCty52981
CSCO_add_clsid_name('CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C', 'General_ServerName', 'CSCO_MangleServerName');
CSCO_add_clsid_name('CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C', 'General_URL');
CSCO_add_clsid_name('CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C', 'EndBrowserSession');
CSCO_add_clsid_name('CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C', 'Mail_MailDbPath');
CSCO_AddWrapper("OBJECT", "getput", "General_URL", "CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C");
CSCO_AddWrapper("OBJECT", "call", "EndBrowserSession", "CLSID:0F2AAAE3-7E9E-4b64-AB5D-1CA24C6ACB9C");
//~ Domino8.5 end

CSCO_add_clsid_name('CLSID:65BCBEE4-7728-41a0-97BE-14E1CAE36AAE', 'ListWeb', 'CSCO_SharePointDataSheet');
CSCO_add_clsid_name('CLSID:65BCBEE4-7728-41a0-97BE-14E1CAE36AAE', 'ListData', 'CSCO_SharePointListData');
CSCO_add_clsid_name('CLSID:65BCBEE4-7728-41a0-97BE-14E1CAE36AAE', 'ListSchema', 'CSCO_SharePointListSchema');

CSCO_add_clsid_name('CLSID:8AD9C840-044E-11D1-B3E9-00805F499D93', 'codebase', 'CSCO_MangleCodeBase');
CSCO_add_clsid_name('CLSID:8AD9C840-044E-11D1-B3E9-00805F499D93', 'archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:8AD9C840-044E-11D1-B3E9-00805F499D93', 'cache_archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:CAFEEFAC-0015-0000-0000-ABCDEFFEDCBA', 'codebase', 'CSCO_MangleCodeBase');
CSCO_add_clsid_name('CLSID:CAFEEFAC-0015-0000-0000-ABCDEFFEDCBA', 'archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:CAFEEFAC-0015-0000-0000-ABCDEFFEDCBA', 'cache_archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:CAFEEFAC-0014-0000-0000-ABCDEFFEDCBA', 'codebase', 'CSCO_MangleCodeBase');
CSCO_add_clsid_name('CLSID:CAFEEFAC-0014-0000-0000-ABCDEFFEDCBA', 'archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:CAFEEFAC-0014-0000-0000-ABCDEFFEDCBA', 'cache_archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:9B935470-AD4A-11D5-B63E-00C04FAEDB18', 'codebase', 'CSCO_MangleCodeBase');
CSCO_add_clsid_name('CLSID:9B935470-AD4A-11D5-B63E-00C04FAEDB18', 'archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:9B935470-AD4A-11D5-B63E-00C04FAEDB18', 'cache_archive', 'CSCO_ProcessArchive');
CSCO_add_clsid_name('CLSID:9059F30F-4EB1-4BD2-9FDC-36F43A218F4A','host_name','CSCO_get_default_local_host');
CSCO_add_clsid_name('CLSID:9059F30F-4EB1-4BD2-9FDC-36F43A218F4A','port','CSCO_get_default_local_port');
CSCO_add_clsid_name('CLSID:7584C670-2274-4EFB-B00B-D6AABA6D3850','host_name','CSCO_get_default_local_host');
CSCO_add_clsid_name('CLSID:7584C670-2274-4EFB-B00B-D6AABA6D3850','port','CSCO_get_default_local_port');
CSCO_add_clsid_name('CLSID:2D360201-FFF5-11D1-8D03-00A0C959BC0A', 'LoadURL');
CSCO_add_clsid_name('CLSID:2D360201-FFF5-11D1-8D03-00A0C959BC0A', 'DocumentHTML');
CSCO_add_clsid_name('CLSID:2D360201-FFF5-11D1-8D03-00A0C959BC0A', 'BaseURL');
CSCO_add_clsid_name('CLSID:47B0DFC7-B7A3-11D1-ADC5-006008A5848C', 'Dummy');
CSCO_Util['open_tunnel']('CLSID:7584C670-2274-4EFB-B00B-D6AABA6D3850','127.1.2.3','default','xxx.xxx.xxx.xxx','xxx','xxx.xxx.xxx.xxx','3389');
CSCO_Util['open_tunnel']('CLSID:9059F30F-4EB1-4BD2-9FDC-36F43A218F4A','127.1.2.3','default','xxx.xxx.xxx.xxx','xxx','xxx.xxx.xxx.xxx','3389');
CSCO_Util['open_tunnel']('CLSID:9059F30F-4EB1-4BD2-9FDC-36F43A218F4A','127.1.2.3','default','xxx.xxx.xxx.xxx','xxx','xxx.xxx.xxx.xxx','3389');


CSCO_AddWrapper("OBJECT", "call", "MultipleUpload", "CLSID:07B06095-5687-4D13-9E32-12B4259C9813");
CSCO_AddWrapper("OBJECT", "call", "LoadURL", "CLSID:2D360201-FFF5-11D1-8D03-00A0C959BC0A");
CSCO_AddWrapper("OBJECT", "getput", "DataURL", "CLSID:333C7BC4-460F-11D0-BC04-0080C7055A83");
CSCO_AddWrapper("OBJECT", "call", "Connect", "CLSID:7584C670-2274-4EFB-B00B-D6AABA6D3850");
CSCO_AddWrapper("OBJECT", "call", "Connect", "CLSID:9059F30F-4EB1-4BD2-9FDC-36F43A218F4A");
CSCO_AddWrapper("OBJECT", "getput", "DocumentHTML", "CLSID:2D360201-FFF5-11D1-8D03-00A0C959BC0A");
CSCO_AddWrapper("OBJECT", "put", "BaseURL", "CLSID:2D360201-FFF5-11D1-8D03-00A0C959BC0A");


CSCO_AddWrapper("NEWACTIVEXOBJECT", "getput", "url", "Microsoft.XMLDOM");
CSCO_AddWrapper("OBJECT", "getput", "url",'CLSID:79348936-6D8C-11D2-8B4E-00AA0030C99A|CLSID:BD96C556-65A3-11D0-983A-00C04FC29E33');

//~ XMLDocument can use the generic pattern /MSXML|XMLDOM/i
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "load", "MICROSOFT.XMLDOM");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "load", "MSXML2.XMLHTTP");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "load", "MICROSOFT.XMLHTTP");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "load", "MSXML2.DOMDOCUMENT.5.0");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "load", "Microsoft.XMLDOM");

// Sharepoint can use the generic pattern /SHAREPOINT/i
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "LaunchOIS", "OISCTRL.OISCLIENTLAUNCHER");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "SendForReview", "SHAREPOINT.SENDFORREVIEW.1");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CreateNewDocument", "SHAREPOINT.OPENDOCUMENTS.1");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CreateNewDocument", "SHAREPOINT.OPENDOCUMENTS.2");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CreateNewDocument2", "SHAREPOINT.OPENDOCUMENTS.2");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CreateNewDocument2", "SHAREPOINT.OPENXMLDOCUMENTS.2");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "EditDocument", "SHAREPOINT.OPENDOCUMENTS.1");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "ViewDocument", "SHAREPOINT.OPENDOCUMENTS.1");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "ViewDocument2", "SHAREPOINT.OPENDOCUMENTS.2");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "ViewDocument3", "SHAREPOINT.OPENDOCUMENTS.3");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CustomizeTemplate2", "SHAREPOINT.OPENXMLDOCUMENTS");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "MergeDocuments2", "SHAREPOINT.OPENXMLDOCUMENTS");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CustomizeTemplate2", "SHAREPOINT.OPENXMLDOCUMENTS.2");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "MergeDocuments2", "SHAREPOINT.OPENXMLDOCUMENTS.2");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CustomizeTemplate2", "SHAREPOINT.OPENXMLDOCUMENTS.3");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "MergeDocuments2", "SHAREPOINT.OPENXMLDOCUMENTS.3");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "PublishSlidesToSlideLibrary", "CLSID:99098758-CB85-4A90-924F-F21898796281");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "DiscardLocalCheckout", "SHAREPOINT.OPENDOCUMENTS.3");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CheckoutDocumentPrompt", "SHAREPOINT.OPENDOCUMENTS.3");
CSCO_AddWrapper("NEWACTIVEXOBJECT", "call", "CheckinDocument", "SHAREPOINT.OPENDOCUMENTS.3");

function CSCO_activex_relay_enabled() {
return true;}


if( !CSCO_WebVPN )
    CSCO_WebVPN = new CSCO_WebVPN_CTE();

if(typeof window != "undefined"){
    CSCO_seppuku();
}

