<?
/*
	CoreDB
	A "CoreData" inspired managed object SQLLess wrapper for SQLite3
	Written by: Kyle Harrison
	http://kyleharrison.ca

	See: README.md for examples
*/

// This function might actually be useless, we'll see.. or could be the Context, havent decided
class CoreDB {
	
	function CoreDB() {

	}

	public static function CreateContext($DatabasePath) {
		return new CoreContext($DatabasePath);
	}


	public static function CreateEntity($context, CoreEntityDescription $entity) {
		$sql = "DROP TABLE IF EXISTS ".$entity->name.";";

		$store = $context->getStore();
		
		


		return $entity;
	}

}

class CoreEntityDescription {
	public $name;
	public $properties = array();

	function CoreEntityDescription($name, $properties = null) {
		$this->name = $name;
		$this->properties = $properties;
	}

	public function addProperty(CoreEntityProperty $property) {
		$this->properties[] = $property;
		return $this;
	}

	public static function Create($name, $properties = null) {
		return new CoreEntityDescription($name, $properties);
	} 
}

class CoreEntityProperty {

	const TEXT = "TEXT";
	const NUMBER = "INTEGER";
	const BLOB = "BLOB";
	const DATE = "TEXT";

	public $name;
	public $type;
	public $primary = false;

	function CoreEntityProperty($name = null, $type = null, $primary = false) {
		$this->setName($name)->setType($type)->setPrimary($primary);
	}

	public function setName($str) { $this->name = $str; return $this; }
	public function setType($const) { $this->type = $const; return $this; }
	public function setPrimary($bool = true) { $this->primary = $bool; return $this; }

	public static function Create($name = null, $type = null, $primary = false) {
		return new CoreEntityProperty($name, $type, $primary);
	}
}

class CoreError {
	private $code = 0;
	private $message = null;

	function CoreError($code, $message) {
		$this->code = $code; 
		$this->message = $message;
	}

	public function describe() {
		return "Error: ".$this->code."; with Message: '".$this->message."'";
	}
}

class CorePredicateCondition {
	const EQUALS = "=";
	const DOES_NOT_EQUAL = "!=";
	const LIKE 	 = "LIKE";
}

class CorePredicateGlue {
	const GLUEAND = " AND ";
	const GLUEOR  = " OR ";
}

class CorePredicate {

	// Property to condition against
	private $property = null;
	
	// The Conditional to compare with
	private $conditional = null;
	
	// What the property should or should not be (depending on conditional)
	private $value = null;

	// If multiple Predicates are present, this glue can (and will) be used and THEN this predicate is written
	private $glue = null;

	/**
	* Creates a new Filter Predication (Conditional)
	* @property String $property The property/field name
	* @property String $value the value of the property to match against
	* @property Const $conditional The conditional representaiton to argue the value vs. the property with
	* @property Const $glue If multiple predicates are presented, this is the condition this predicate should be used in sequence 
	* @example new CorePredicate("id", 1); // would equal: WHERE `id` = 1;
	* @example array(new CorePredicate("firstname", "Ron%", CorePredicate::LIKE), new CorePredicate("lastname", "Howard", CorePredicateCondition::EQUALS, CorePredicateGlue::AND)); // equivilent to: WHERE `firstname` LIKE "Ron%" AND `lastname` = "Howard"
	*/
	function CorePredicate($property, $value, $conditional = CorePRedicateCondition::EQUALS, $glue = CorePredicateGlue::GLUEAND) {
		$this->setField($property);
		$this->setValue($value);
		$this->setConditional($conditional);
		$this->setGlue($glue);
	}

	public function setProperty($str) { $this->property = $str; }
	public function setValue($str) { $this->value = $str; }
	public function setConditional($str) { $this->conditional = $str; }
	public function setGlue($glue) { $this->glue = $glue; }

}

class CoreSortDescriptor {

	const ASCENDING = "ASC";
	const DESCENDING = "DESC";

	private $property = null;
	private $direction = null;

	/**
	* Creates a new Sorting Description
	* @property String $property a string representation of the property (field) to sort by
	* @property Const $withDirection a String representation of the direction of the sort: ASCENDING / DESCENDING
	*/
	function CoreSort($property, $withDirection = self::ASCENDING) {
		$this->setProperty($property);
		$this->setDirection($withDirection);
	}

	public function setProperty($property) { $this->property = $property; }
	public function setDirection($withDirection) { $this->direction = $withDirection; }

}


class CoreFetchRequest {

	// the table
	private $entity = null;

	// conditions
	private $predicates = array();

	// sorting
	private $descriptors = array();

	// fields to fetch
	private $properties = array();

	// record limit
	private $limit = null;

	// automatic record offset with limit
	private $page  = null;


	/**
	* Creates a new CoreDB Fetch Request
	* @property String $withEntityName the name of the Entity to request data from
	*/
	function CoreFetch($withEntityName = null) {
		$this->setEntity($withEntityName);
	}

	/**
	* Sets/Overrides the specified Entity (table)
	*/
	public function setEntity($entityName) {
		$this->entity = $entityName; 
		return $this;
	}

	/**
	* Sets/Overrides existing Sorting description
	* @property $sort CoreSortDescriptor a single sort descriptor object
	*/
	public function setSortDescriptor(CoreSortDescriptor $sort) {
		$this->descriptors = array($sort);
		return $this;
	}

	/**
	* Sets/Overrides existing filter predication (conditional)
	* @property $predicate CorePredicate a single predicate object (condition)
	*/
	public function setPredicate(CorePredicate $predicate) {
		$this->predicates = array($predicate);
		return $this;
	}

	/**
	* Sets/Overrides existing Sorting descroption with a series of of new Sort descroptions
	* @property $sortDescriptors An array of Sort Descriptors. Any object that is not a CoreSortDescriptor object will be ignored.
	*/
	public function setSortDescriptors($sortDescriptors) {
		$this->descriptors = array();
		foreach($sortDescriptors as $desc) if(get_class($desc) == "CoreSortDescriptor") $this->descriptors[] = $desc;
		return $this;
	}

	/**
	* Sets/Overrides existing filter predicates (conditionals)
	* @property $predicates An array of CorePredicates. Any object that is not a CorePredicate object will be ignored.
	*/
	public function setPredicates($predicates) {
		$this->predicates = array();
		foreach($predicates as $p) if(get_class($p) == "CorePredicate") $this->predicates = $p;
		return $this;
	}

	/**
	* Sets/Overrides the precise properties (fields) to fetch. If not used, default "*" will be used.
	* @property $properties Array an array of strings with property (field) names
	*/
	public function setPropertiesToFetch($properties = array("*")) {
		$this->properties = $properties;
		return $this;
	}

	/**
	* Sets/Overrides a limit of records to fetch
	* @property $integer int The limit of records to fetch as a number
	*/
	public function setFetchLimit($integer) {
		$this->limit = $integer;
		return $this;
	}

	/**
	* Sets/Overrides a page for automatic record offsetting
	* @property $integer int the explicit page number. If not used, will not take any effect.
	*/
	public function setPage($integer) {
		$this->page = $integer;
		return $this;
	}


}


class CoreContext {

	private $store;

	/**
	* Establishes a connection to the sqlite3 database
	*/
	function CoreContext($DatabasePath) {

		$this->store = new SQLite3($_SERVER['DOCUMENT_ROOT']."/".$DatabasePath.".sqlite", SQLITE3_OPEN_READWRITE|SQLITE3_OPEN_CREATE);

	}

	public function getStore() { return $this->store; }

	/**
	* 
	*/
	public function executeFetchRequest(CoreFetchRequest $request) {

	}

	/**
	* Gathers all Inserts, Updates, and Deletions, builds the series of queries, and executes them one by one
	*/
	public function save() {

	}

}



