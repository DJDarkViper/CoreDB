<?
require_once '../CoreDB.php';

// Create Context and connect to the datastore
$context = CoreDB::CreateContext("stores/update");

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

$context->clear(); // cleanup

///
///  Now we have some data in the database, lets update one of the records
///


$update = new Example(&$context);
$update->id = 2; // the slot that "Sweeny" is in
$update->name = "Wachowski";

// If we check the records, Sweeny should not be Wachowski

$context->save();