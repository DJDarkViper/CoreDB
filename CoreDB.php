<?
/*







*/

// This function might actually be useless, we'll see.. or could be the Context, havent decided
class CoreDB {
	
	function CoreDB() {

	}

}

class CoreError {
	private $code = 0;
	private $message = null;

	public CoreError($code, $message) {
		$this->code = $code; 
		$this->message = $message;
	}

	public function describe() {
		return "Error: ".$this->code."; with Message: '".$this->message."'";
	}
}

class CorePredicate {

	const EQUALS = "=";
	const DOES_NOT_EQUAL = "!=";
	const LIKE 	 = "LIKE";

	const GLUE_AND = " AND ";
	const GLUE_OR  = " OR ";
	
	private $property = null;
	private $conditional = null;
	private $value = null;

	private $glue = null;

	function CoreCondition($property, $value, $conditional = self::EQUALS, $glue = null) {
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

	const ASCENDING = 1;
	const DESCENDING = 2;

	private $property = null;
	private $direction = null;

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


	function CoreFetch($withEntityName) {

	}

	public function setEntity($entityName) {
		$this->entity = $entityName; 
		return $this;
	}

	/**
	* Sets/Overrides existing Sorting description
	* @property $sort CoreSortDescriptor a single sort descriptor object
	*/
	public function setSortDescriptor(CoreSortDescriptor $sort) {

		return $this;
	}

	/**
	* Sets/Overrides existing filter predication (conditional)
	* @property $predicate CorePredicate a single predicate object (condition)
	*/
	public function setPredicate(CorePredicate $predicate) {

		return $this;
	}

	/**
	* Sets/Overrides existing Sorting descroption with a series of of new Sort descroptions
	* @property $sortDescriptors An array of Sort Descriptors, requires a Glue
	*/
	public function setSortDescriptors($sortDescriptors) {

		return $this;
	}

	public function setPredicates($predicates) {

		return $this;
	}

	public function setPropertiesToFetch($array = array("*")) {

		return $this;
	}

	public function setFetchLimit($integer) {
		$this->limit = $integer;
		return $this;
	}



}


class CoreContext {

	/**
	* Establishes a connection to the sqlite3 database
	*/
	public CoreContext($DatabasePath) {

	}

	public function executeFetchRequest(CoreFetchRequest $request) {

	}

}