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



class Example extends CoreModel {

	public $name;

	function __construct(CoreContext $context) {
		parent::__construct(&$context);
	}

}


// This should be an insert, creating "John"
$example = new Example(&$context);
$example->name = "John";

// Because an ID is supplied, this should become an Update, and with an id of 1, we should be replacing John with Sweeny
$example2 = new Example(&$context);
$example2->id = 1;
$example2->name = "Sweeny";

$context->save();


