<?
require_once '../CoreDB.php';

// Create Context and connect to the datastore
$context = CoreDB::CreateContext("stores/insert");

// This should be all the setup required.

$db = CoreDB::CreateEntity(&$context,
		CoreEntityDescription::Create("Example", array(
				CoreEntityProperty::Create()->setName("id")->setType(CoreEntityProperty::NUMBER)->setPrimary(),
				CoreEntityProperty::Create()->setName("name")->setType(CoreEntityProperty::TEXT)
			)
		)   
	);


// Create our object model that matches the structure of the Entity ("id" is always handled automatically)
class Example extends CoreModel {

	public $name;

	function __construct(CoreContext $context) {
		parent::__construct(&$context);
	}

}



$example = new Example(&$context);
$example->name = "John";

$example2 = new Example(&$context);
$example2->name = "Sweeny";

$example3 = new Example(&$context);
$example3->name = "Cliff";


// Commit these three objects to the entity
$context->save();
