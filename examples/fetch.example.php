<?
require_once '../CoreDB.php';

/*********
* Users object
**********/

class Users extends CoreModel {

	public $id;
	public $username;
	public $password;

}

/*********
* End Users object
**********/


define(ROOT, $_SERVER['DOCUMENT_ROOT']."/stores/");

// Create Context and connect to the datastore
$context = CoreDB::CreateContext(ROOT."fetchexample");

// Data should already be in datastore for us to fetch, for this exmaple "users"
$request = new CoreFetchRequest("Users"); 

// Acquire all records, all default settings
$records = $context->executeFetchRequest($request);

// Should output an array of Users objects populated with data
var_dump($records);










