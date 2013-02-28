<?
require_once '../CoreDB.php';

define(ROOT, $_SERVER['DOCUMENT_ROOT']."/stores/");

// Create Context and connect to the datastore
$context = CoreDB::CreateContext(ROOT."setup");

// This should be all the setup required.