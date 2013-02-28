<?
require_once '../CoreDB.php';

// Create Context and connect to the datastore
$context = CoreDB::CreateContext("stores/setup");

// This should be all the setup required.

var_dump($context);