<?
require_once '../CoreDB.php';

// Create Context and connect to the datastore
$context = CoreDB::CreateContext("stores/table");

// This should be all the setup required.

$db = CoreDB::CreateEntity(&$context,
		CoreEntityDescription::Create("Example", array(
				CoreEntityProperty::Create()->setName("id")->setType(CoreEntityProperty::NUMBER)->setPrimary(),
				CoreEntityProperty::Create()->setName("name")->setType(CoreEntityProperty::TEXT)
			)
		)   
	);

echo "<pre>";
echo print_r($db);