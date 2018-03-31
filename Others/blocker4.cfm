
/**
 * The page can be used in ColdFusion applications to check for SQL injections and XSS attacks
 * It should be used anywhere after the application scope has been initialized but before any page processing takes place
 * This code is free to use for personal or commercial use. Feel free to email me any comments or improvements.
 * 
 * @author Mary Jo Sminkey maryjo@dogpatchsw.com
 * @version 1, July 25, 2008
 * @version 2, July 28, 2008
 * @version 3, August 15, 2008
 * @version 4, August 20, 2008
 * @version 5, July 5, 2009
 * @version 6, September 25, 2009
 */ 
 
<cfscript>

function checkSQLInject() {
	/**
	 * Creates the RegEx to test a string for possible SQL injection.
	 * 
	 * @return Returns string. 
	 * @author Luis Melo (luism@grouptraveltech.com)
	 * @original author Gabriel Read
	 * @version 1, July 25, 2008
	 * @version 2, July 28, 2008
	 * @version 3, August 20, 2008
	 */ 
	 
	// list of db objects/functions to protect 
	var insSql = 'insert|delete|select|update|create|alter|drop|truncate|grant|revoke|declare|' &
				 'exec|backup|restore|sp_|xp_|set|execute|dbcc|deny|union|Cast|Char|Varchar|nChar|nVarchar';
 
	 // Build the regex 
	 var regEx='((or)+[[:space:]]*\(*''?[[:print:]]+''?' &
		  '([[:space:]]*[\+\-\/\*][[:space:]]*''?' &
		  '[[:print:]]+''?)*\)*[[:space:]]*' &
		  '(([=><!]{1,2}|(like))[[:space:]]*\(*''?' &
		  '[[:print:]]+''?([[:space:]]*[\+\-\/\*]' &
		  '[[:space:]]*''?[[:print:]]+''?)*\)*)|((in)' &
		  '[[:space:]]*\(+[[:space:]]*''?[[:print:]]+''?' &
		  '(\,[[:space:]]*''?[[:print:]]+''?)*\)+)|' &
		  '((between)[[:space:]]*\(*[[:space:]]*''?' &
		  '[[:print:]]+''?(\,[[:space:]]*''?[[:print:]]+''?)' &
		  '*\)*(and)[[:space:]]+\(*[[:space:]]*''?[[:print:]]+''?' &
		  '(\,[[:space:]]*''?[[:print:]]+''?)*\)*)|((;)([^a-z>]*)' &
		  '(#insSql#)([^a-z]+|$))|(union[^a-z]+(all|select))|(\/\*)|(--$))';
		  
	return regEx;
}

function loadPattern(strRegex) {
/**
 * Build the java pattern matcher
 * 
 * @return Returns object. 
 * @author Gabriel Read from CF-Talk (gabe@evolution7.com)
 * @version 1, July 28, 2008
 * @version 2, August 15, 2008
 * @version 3, July 5, 2009 by Mary Jo Sminkey
 */ 
	// Build the java pattern matcher 
	
	var reMatcher = '';
	
	var rePattern = createObject('java', 'java.util.regex.Pattern'); 
	rePattern = rePattern.compile(strRegex,rePattern.CASE_INSENSITIVE); 	
	return rePattern;
}

/**
 * This function checks the URL, form, and cookie scopes, and selected CGI variables for SQL Injection
 * Updated version also includes additional check for XSS attacks
 * 
 * @return Returns boolean. 
 * @author Mary Jo Sminkey
 * @version 1, July 25, 2008
 * @version 2, July 28, 2008
 * @version 3, August 15, 2008
 * @version 4, August 20, 2008
 * @version 5, July 5, 2009
 * @version 6, September 25, 2009
 */ 
function checkforattack(scope) {
	
	var hackattempt = 'no';
	var testvar = '';
	var SQLMatcher = '';
	var XSSMatcher = '';
	var strRegex = '';
	var CGIvars = 'script_name,remote_addr,path_info,http_referer,http_user_agent,server_name';
	var i = 1;
	
	//Make sure the regex matcher objects are available in Application Scope
	if (NOT StructKeyExists(Application, 'SQLChecker')) {
		strBlacklist = checkSQLInject();
		Application.SQLChecker = loadPattern(strBlacklist);
	}
	
	if (NOT StructKeyExists(Application, 'XSSChecker')) {
		strXSS = "((\%3C)|<)((\%2F)|\/)*[a-zA-Z0-9\%]+";
		Application.XSSChecker = loadPattern(strXSS);
	}
	
	//load matchers
	SQLMatcher = Application.SQLChecker.matcher('');
	XSSMatcher = Application.XSSChecker.matcher('');
	
	//Check URL scope for SQL Injection and XSS attacks
	for (testvar in URL) {
		if (SQLMatcher.reset(URL[testvar]).find()) {
			hackattempt="yes";
			}
		else if (XSSMatcher.reset(URL[testvar]).find()) {
			hackattempt="yes";
			}
	}
	
	//Check cookie scope
	for (testvar in COOKIE) {
		if (SQLMatcher.reset(COOKIE[testvar]).find()) {
			hackattempt="yes";
		}
		else if (XSSMatcher.reset(COOKIE[testvar]).find()) {
			hackattempt="yes";
			}
	}
	
	//Check CGI scope 
	for (i=1; i LTE ListLen(CGIvars); i=i+1) {
		testvar = ListGetAt(CGIvars, i);
		if (StructKeyExists(CGI, testvar) AND SQLMatcher.reset(CGI[testvar]).find()) {
			hackattempt="yes";
		}
		else if (StructKeyExists(CGI, testvar) AND XSSMatcher.reset(CGI[testvar]).find()) {
			hackattempt="yes";
			}
	}
	
	//additional XSS check on query string
	if (XSSMatcher.reset(CGI.query_string).find()) { 
		hackattempt="yes";
	}
	
	//check form scope
	if (scope IS "public") {
		for (testvar in FORM) {
			if (testvar IS NOT "fieldnames" AND SQLMatcher.reset(FORM[testvar]).find()) {
				hackattempt="yes";
			}
			else if (testvar IS NOT "fieldnames" AND XSSMatcher.reset(FORM[testvar]).find()) {
				hackattempt="yes";
				}
			}
	}
	

	return hackattempt;
}

 
</cfscript>


<cfset hackattempt = checkforattack('public')>
<cfif hackattempt>
	<cfoutput><br/>Sorry, your page request appears to be a hack attempt and processing has been halted.<br/><br/> If you believe this message was received in error, return to the previous page and change the text you entered. <br/><br/>If you continue to receive this message, please contact the Webmaster. </cfoutput>
	<cfabort>
</cfif> 


