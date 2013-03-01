CoreDB
======


Status
-------

Release Status: **BETA**

**IN DEVELOPMENT, and ACCEPTING CONTRIBUTIONS at all times.**


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


Setup 
-----
CoreDB is "SetupLess", that means you only need to include the CoreDB.php file in your application when you want to use it. 
The only thing CoreDB needs to operate, is a writable directory, though this plans to be automatic as well in the near future to completely acheive this goal.

Though you can use CoreDB to create and manage tables ("Entities"), it IS however highly recommended to use the tools mentioned above to create your database structure in the first place. Though, not required. See the [CreateTables Example](https://github.com/DJDarkViper/CoreDB/blob/master/examples/createtable.example.php) to see how to create a table with CoreDB.

To get everything going, you need to create a context, this is a one line operatation: 

```
$context = CoreDB::CreateContext("db");
```
This will open and manage an existing SQLite3 database, or create an empty one if it doesnt exist. 
To use the rest of what CoreDB has to offer, simply pass a reference to the context where asked!

In PHP to pass a reference, you prepend a & to the variable name, so "&$context"


Use Example
-----------

CoreDB is a SQLess wrapper for SQLite3 Databases. That means that CoreDB will manage all operations of your sites communication with stored data via "Managed Object" structs. 

The pattern is that for each "table" (aka: *Entity*), there is a class with properties that matches the structure of the Entities properties (fields).

Lets pretend we have a _Users_ entity (table) with the properties as follows (in sqlite):

```
CREATE TABLE Users (
	id INTEGER PRIMARY KEY,
	username TEXT NOT NULL,
	password TEXT NOT NULL,
	email TEXT NOT NULL
);
```

we would have an class like this:
```
// Users.model.php
class Users extends CoreModel {

	public $username;
	public $password;
	public $email;

	// This construct is required
	public function __construct(CoreContext $context) {
		parent::__construct(&$context);
	}

	//// ... feel free to add your getters and setters here

}
```

If you wish to insert a new object to the database, we could do something such as:

```
// Initialize a new Context (established connection)
$context = new CoreContext("stores/example"); // looks for and establishes a connection to "/stores/example.sqlite", if it does not exist, one will be created

// Create a new User
$user1 = new Users(&$context);
$user1->username = "Dave";
$user1->password = sha1("password");
$user1->email = "dave@davesworld.com";

// Save the user with the context
$context->save();

```

