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
	
	private $property = null;
	private $conditional = null;
	private $value = null;

	function CoreCondition($property, $value, $conditional = self::EQUALS) {
		$this->setField($property);
		$this->setValue($value);
		$this->setConditional($conditional);
	}

	private function setProperty($str) { $this->property = $str; }
	private function setValue($str) { $this->value = $str; }
	private function setConditional($str) { $this->conditional = $str; }

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

	public function setSortDescriptor(CoreSortDescriptor $sort) {

		return $this;
	}

	public function setPredicate(CorePredicate $predicate) {

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

	public CoreContext($DatabasePath) {
		
	}

	public function executeFetchRequest(CoreFetchRequest $request) {

	}

}