<?php

error_reporting(0);

//require realpath(dirname( __FILE__ ) . '/../vendor/autoload.php');
require realpath(dirname( __FILE__ ) . '/../classes/CyberSource/CyberSource.php');
require realpath(dirname( __FILE__ ) . '/config.php');

/** @var CyberSource\CyberSource $c */
$c = CyberSource\CyberSource::factory($merchant_id, $transaction_key, CyberSource\CyberSource::ENV_TEST);
// $c->set_proxy($proxy);

echo
	'<head>' .
		'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">' .
		'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">' .
		'<!-- E8 support of HTML5 elements and media queries -->' .
		'<!--[if lt IE 9]>' .
		'<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>' .
		'<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>' .
		'<![endif]-->' .
		'<style>pre{white-space: pre-wrap; margin: 10px;} h1,h2,h3,apathy{margin-left: 10px}</style>'.
	'</head>';

function printHeader($name)
{
	echo "<h1>$name</h1>";
}

function printRequestResponse($request, $response, $subSection = null)
{
	global $c;
	$requestR = print_r( $request , true );
	$responseR = print_r( $response , true );

	if ($subSection !== null) echo "<h2>$subSection</h2>";

	echo '<ul>';
		echo "<li>Result: {$c->result_codes[$response->reasonCode]}</li>";

		if (isset($response->ccAuthReply) && isset($response->ccAuthReply->avsCode)) {
			$avsCode = $response->ccAuthReply->avsCode;
			echo "<li>AVS: {$c->avs_codes[$avsCode]}</li>";
		}
	echo '</ul>';

	echo
		"<h3>Request</h3>" .
		"<pre>$requestR</pre>" .

		"<h3>Response</h3>" .
		"<pre>$responseR</pre>";
}
// EOF