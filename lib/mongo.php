<?php
namespace lib;
class mongo{
	public function addMongo(){
		$collection = (new \MongoDB\Client)->test->users;

		$insertOneResult = $collection->insertOne([
				'username' => 'admin',
				'email' => 'admin@example.com',
				'name' => 'Admin User',
		]);

		printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

		var_dump($insertOneResult->getInsertedId());
	}
}

