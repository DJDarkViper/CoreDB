CoreDB
======

An Introduction
---------------

CoreDB is a drop-and-drop usable library that brings Apples "CoreData" functionality to your PHP powered site. The terminology is pretty much the same and the usage is attempted to be fairly identical, with some minor changes (because This is a web based DB engine for PHP, not an app powered by Objective-C and the CoaCoa Touch API)


Prerequisitics
--------------

All functionality of CoreDB has been tested on and targeted for PHP 5.3.  Any version below 5.3 is largely untested, and CoreDB welcomes pull requests for backwards compatibility


Installation
------------

Download the latest stable version. You only need CoreDB.php, place it pretty much anywhere. Done.

I highly recommend using tools like [Navicat Premium](http://www.navicat.com/en/products/navicat_premium/premium_overview.html), [NaviCat for SQLite](http://www.navicat.com/en/products/navicat_sqlite/sqlite_overview.html), or [PHPLiteAdmin](https://code.google.com/p/phpliteadmin/) to create and manage the structure of your SQLite databases easier. 


Usage
-----

CoreDB is a SQLess wrapper for SQLite3 Databases. That means that CoreDB will manage all operations of your sites communication with stored data via "Managed Obejct" structs. 

The pattern is that for each "table" (aka: *Entity*), there is a class with properties that matches the structure of the Entities properties (fields).

Lets pretend we have a _Users_ entity (table) with the properties as follows (in pseudoQL):

```
id INTEGER PRIMARY AUTO INCREMENT,
username TEXT NOT NULL,
password TEXT NOT NULL,
email TEXT NOT NULL
```

we would have an class like this:
```
// Users.model.php
class Users extends CoreDBModel {

	public $id 			= null;
	public $username 	= null;
	public $password	= null;
	public $email		= null;

	// This construct is required
	public function __construct(CoreContext $context) {
		parent::__construct($this);
	}


	//// ... feel free to add your getters and setters here

}
```

If you wish to insert a new object to the database, we could do something such as:

```
// Initialize a new Context (established connection)
define(DATASTORE_PATH, "./");
$context = new CoreContext(DATASTORE_PATH."example"); // looks for and establishes a connection to "./example.sqlite", if it does not exist, one will be created

// Create a new User
$user1 = new Users(&$context);
$user1->username = "Dave";
$user1->password = sha1("password");
$user1->email = "dave@davesworld.com";

// Save the user with the context
$context->save();

```