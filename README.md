CoreDB
======

An Introduction
---------------

CoreDB is a drop-and-drop usable library that brings Apples "CoreData" functionality to your PHP powered site. The terminology is pretty much the same and the usage is attempted to be fairly identical, with some minor changes (because This is a web based DB engine for PHP, not an app powered by Objective-C and the CoaCoa Touch API)


Installation
------------

Download the latest stable version. You only need CoreDB.php, place it pretty much anywhere. Done.


Usage
-----

CoreDB is a SQLess wrapper for SQLite3 Databases. That means that CoreDB will manage all operations of your sites communication with stored data via "Managed Obejct" structs. 

The pattern is that for each "table" (aka: *Entity*), there is a class with properties that matches the structure of the Entities properties (fields).

Lets pretend we have a _Users_ entity (table) with the properties as follows:

id INTEGER PRIMARY AUTO INCREMENT,
username TEXT NOT NULL,
password TEXT NOT NULL,
email TEXT NOT NULL


we would have an class like this:
```
// Users.model.php
class Users extends CoreDBModel {

	public $id 			= null;
	public $username 	= null;
	public $password	= null;
	public $email		= null;

	//// ... feel free to add your getters and setters here

}

```