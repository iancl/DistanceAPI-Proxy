<?php

// Script will query the distance between two points based on latitute and longitude.
// Origin and destination coordinates need to be provided by the client
// Script will return a json object
// version 1.0

/*
GET Request Params structure

// urlEnconded
origins=1.23,-0.98&destinations=4.123,9.093&mode=driving&language=en&type=json&apiKey=12345


// examples
origins = lat,long; REQUIRED
destinations = lat,long; REQUIRED
mode = driving|walking|bicycling; REQUIRED
language = es|en|fr; REQUIRED
apiKey = google api Key; OPTIONAL
type = json|xml; OPTIONAL, DEFAULT is json
 */

// Global var declaration and definition
$baseUrl  = "http://maps.googleapis.com/maps/api/distancematrix/";
$api_key  = "";// api key will be used only if provided
$response = "";
$url      = "";

// this will generate a custom error response for the client
function generateErrorResponse($errorStr) {
	return json_encode(array("error" => $errorStr));
}

// will extract all params from the GET request
function extractParamsAndBuildURL() {

	// accessing global vars
	global $baseUrl, $url, $api_key;

	// local vars
	$didGetParams = false;
	$origins      = $_GET["origins"];
	$destinations = $_GET["destinations"];
	$mode         = $_GET['travelMode'];
	$language     = $_GET['responseLanguage'];
	$api_key      = (isset($_GET['apiKey']))?$_GET['apiKey']:"";
	$type         = (isset($_GET["responseType"]))?$_GET["responseType"]:"json";

	// generate URL only if required params were provided
	if (isset($origins) && isset($destinations) && isset($mode) && isset($language)) {

		// let caller know that params are ok
		$didGetParams = true;

		// building url based on received params
		$url = $baseUrl.$type."?"."origins=".$origins."&destinations=".$destinations."&language=".$language."&mode=".$mode."&key=".$api_key;
	}

	// let caller know that params are ok
	return $didGetParams;
}

// it will perform the API call
// and return the received data
function curlUsingGet($apiUrl) {

	// continue is url is available
	if (empty($apiUrl)) {
		return 'Error: invalid Url or Data';
	}

	// perform curl call
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);// timeout after 10 seconds, you can increase it
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
	curl_setopt($ch, CURLOPT_URL, $apiUrl);//set the url and get string together

	$return = curl_exec($ch);
	curl_close($ch);

	return $return;
}
/*=================================================================================================
SCRIPT INIT BELOW
=================================================================================================*/
// get info from maps API
$didReceiveParams = extractParamsAndBuildURL();

// excec api call if params are ok
if ($didReceiveParams == true) {

	// get data
	$data = curlUsingGet($url);

	// verify data and set response
	if ($data) {
		$response = $data;
	} else {
		$response = generateErrorResponse("Error contacting Google API");
	}

} else {
	$response = generateErrorResponse("Please send all required request params");
}

// set headers and return response to client
header("Content-Type: application/json");

// response will the the json returned by the google service
echo $response;

?>
