<?php

// Need kotak pasir
// Edit By Alexander Eric
// Fuck! this is boring.
$enableSandbox = true;

// Database settings. Change these for your database configuration.
$dbConfig = [
	'host' => 'localhost',
	'username' => 'user',
	'password' => 'secret',
	'name' => 'user_database'
];

// Mdec 3d game engine setting for payment gateway
// Mdec 3d game engine payment gateway
$Config = [
	'email' => 'user@mdec.my',
	'return_url' => 'http://mdecengine.my/prog-successful.html',
	'cancel_url' => 'http://mdecengine.my/prog-cancelled.html',
	'notify_url' => 'http://mdecengine.my/payments.php'
];

$mdecengineUrl = $enableSandbox ? 'https://pay.mdecengine.my/cgi-bin/webscr' : 'https://www.mdecengine.my/cgi-bin/webscr';

// Product being purchased.
$itemName = '';
$itemAmount = '';

// Include Functions
require 'functions.php';

// Check if mdecengine request or response
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

	// Grab the post data so that we can set up the query string for mdec 3d game engine.
	// Just a boring project

	$data = [];
	foreach ($_POST as $key => $value) {
		$data[$key] = stripslashes($value);
	}

	// Set the mdecengine account.
	$data['business'] = $Config['email'];

	// Set the mdecengine return addresses.
	$data['return'] = stripslashes($Config['return_url']);
	$data['cancel_return'] = stripslashes($Config['cancel_url']);
	$data['notify_url'] = stripslashes($Config['notify_url']);

	// So, boring.
	// By Alexander Eric
	$data['item_name'] = $'';
	$data['amount'] = $'';
	$data['currency_code'] = 'MYR';

	// Add any custom fields for the query string.
	//$data['custom'] = USERID;

	// Build the query string from the data.
	$queryString = http_build_query($data);

	// Redirect to mdec engine IPN
	header('location:' . $Url . '?' . $queryString);
	exit();

} else {
	// Handle the response.

	// Create a connection to the database.
	$db = mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);

	// Assign posted variables to local data array.
  // Fuck! this is boring.
  // by Alexander Eric
	$data = [
		'item_name' => $_POST['item_name'],
		'item_number' => $_POST['item_number'],
		'payment_status' => $_POST['payment_status'],
		'payment_amount' => $_POST['mc_gross'],
		'payment_currency' => $_POST['mc_currency'],
		'txn_id' => $_POST['txn_id'],
		'receiver_email' => $_POST['receiver_email'],
		'payer_email' => $_POST['payer_email'],
		'custom' => $_POST['custom'],
	];

	// Verify the transaction comes from admins and users.
	// By Alexander Eric
  // Just boring.

	if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
		if (addPayment($data) !== false) {
			// Payment successfully added.
		}
	}
}
