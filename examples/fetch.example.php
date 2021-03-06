<?
require_once '../CoreDB.php';

// Create Context and connect to the datastore
$context = CoreDB::CreateContext("stores/fetch");

// This should be all the setup required.

$db = CoreDB::CreateEntity(&$context,
		CoreEntityDescription::Create("Users", array(
				new CoreEntityProperty("id", CoreEntityProperty::NUMBER, true),
				new CoreEntityProperty("first", CoreEntityProperty::TEXT),
				new CoreEntityProperty("last", CoreEntityProperty::TEXT)
			)
		)   
	);


// Create our object model that matches the structure of the Entity ("id" is always handled automatically)
class Users extends CoreModel {

	public $first;
	public $last;

	function __construct(CoreContext $context) {
		parent::__construct(&$context);
	}


	public function setFirst($str) { $this->first = $str; return $this; }
	public function setLast($str) { $this->last = $str; return $this; }

}


$example1 = new Users(&$context);
$example1->setFirst("John")
		 ->setLast("Carmack")
;

$example2 = new Users(&$context);
$example2->setFirst("Tim")
		 ->setLast("Sweeny")
;

$example3 = new Users(&$context);
$example3->setFirst("Cliff")
		 ->setLast("Blazinski")
;

$example4 = new Users(&$context);
$example4->setFirst("Chris")
         ->setLast("Taylor")
;


// Commit these three objects to the entity
$context->save();

$context->clear(); // cleanup


///
///  Now we have some data in the database, lets fetch some
///
echo "<pre>";
echo "<b>Get All as is</b><br />";
// Lets fetch ALL records with default settings
$records = $context->executeFetchRequest(new CoreFetchRequest("Users"));

var_dump($records);

echo "<br /><br /><b>Get Just 'John's</b><br />";

$fetch = new CoreFetchRequest("Users");
$fetch->setPredicate( new CorePredicate("first","John") );
$records = $context->executeFetchRequest($fetch);

var_dump($records);

echo "<br /><br /><b>Get All order by last name ascending</b><br />";

$fetch = new CoreFetchRequest("Users");
$fetch->setSortDescriptor(new CoreSortDescriptor("last", CoreSort::ASCENDING));
$records = $context->executeFetchRequest($fetch);

var_dump($records);

echo "<br /><br /><b>Get Everyone with an 'a' in the last name, order by last name descending</b><br />";

$fetch = new CoreFetchRequest("Users");
$fetch->setPredicate( new CorePredicate("last","%a%", CorePredicateCondition::LIKE) );
$fetch->setSortDescriptor( new CoreSortDescriptor("last", CoreSort::DESCENDING) );
$records = $context->executeFetchRequest($fetch);

var_dump($records);

echo "<br /><br /><b>Get Everyone with an 'a' in the last name and ends with 'k', order by last name descending</b><br />";

$fetch = new CoreFetchRequest("Users");
$fetch->setPredicates( array(
		new CorePredicate("last", "%a%", CorePredicateCondition::LIKE),
		new CorePredicate("last", "%k", CorePredicateCondition::LIKE, CorePredicateGlue::GLUE_AND)
	) 
);
$fetch->setSortDescriptor( new CoreSortDescriptor("last", CoreSort::DESCENDING) );
$records = $context->executeFetchRequest($fetch);

var_dump($records);

