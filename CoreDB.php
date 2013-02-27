<?
/*







*/

// This function might actually be useless, we'll see.. or could be the Context, havent decided
class CoreDB {
	
	function CoreDB() {

	}

}


class CorePredicate {

	const EQUALS = "=";
	const DOES_NOT_EQUAL = "!=";
	const LIKE 	 = "LIKE";
	
	private $field = null;
	private $conditional = null;
	private $value = null;

	function CoreCondition($field, $value, $conditional = self::EQUALS) {
		$this->setField($field);
		$this->setValue($value);
		$this->setConditional($conditional);
	}

	private function setField($str) { $this->field = $str; }
	private function setValue($str) { $this->value = $str; }
	private function setConditional($str) { $this->conditional = $str; }

}

class CoreSortDescriptor {

	const ASCENDING = 1;
	const DESCENDING = 2;

	private $field = null;
	private $direction = null;

	function CoreSort($field, $withDirection = self::ASCENDING) {
		$this->setField($field);
		$this->setDirection($withDirection);
	}

}


class CoreFetch {

	// the table
	private $entity = null;

	// conditions
	private $predicates = array();

	// sorting
	private $descriptors = array();

	// fields to fetch
	private $properties = array();

	function CoreFetch($withEntityName) {

	}

	public function setSortDescriptor(CoreSortDescriptor $sort) {

	}

	public function setPredicate(CorePredicate $predicate) {

	}

	public function setPropertiesToFetch($array = array("*")) {
		
	}

}


class CoreContext {

}