<?php
/**
*
* by Maximiliano Dobladez - elmaxi@gmail.com 
* 
  v 1.0 - initial version 

 * @package    app_tirr
 * @author     Maximiliano Dobladez <elmaxi@gmail.com>
 * @license    GNU GPL-2.0 license
 *
 */
 
define("_TIRR_client_secret","xxxxxxxxxxxxxxxx");
define("_TIRR_client_id","xxxxxxxxxxxx");
define("_TIRR_audience","https://api.app.tirr.com.ar");
define("_TIRR_grant_type","client_credentials");
define("_TIRR_url_auth","https://tirr.auth0.com/oauth/token");


/**
 * Gets a token from the TIRR app API using the client secret, client ID, audience, and grant type.
 *
 * @return string The token as a JSON string.
 */

 function get_token_app_tirr() {
	$data = [
	'client_secret' => _TIRR_client_secret,  
	'client_id' => _TIRR_client_id,  
	'audience' => _TIRR_audience,  
	'grant_type' => _TIRR_grant_type 
	];
	$json = json_encode($data); // Encode data to JSON
	$url = _TIRR_url_auth;
	$options = stream_context_create(['http' => [
	'method'  => 'POST',
	'header'  => 'Content-type: application/json',
	'content' => $json
	]
	]); 
	$result = file_get_contents($url, false, $options);
	return $result; #  
  }
 
 /**
 * Retrieves the credit score report for a given CUIT using the provided token.
 *
 * @param string|null $token The authentication token to use for the request.
 * @param string|null $CUIT The CUIT for which to retrieve the credit score report.
 * @return string The credit score report as returned by the API.
 */

function get_score_crediticio($token=NULL,$CUIT=NULL) {
    if (!$token) return false;
	$url_auth=_TIRR_audience.'/v1/credit/'.$CUIT.'/report?id_type=CUIT';
    $ch = curl_init($url_auth);
    $data = ['cuit'=>$CUIT];
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $headers = [];
    $headers[] = 'Content-Type:application/json';
    $headers[] = "Authorization: Bearer ".$token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
	return  $result ;
  }
  
?>
