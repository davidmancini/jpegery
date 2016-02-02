<?php
namespace Edu\CNM\Jpegery;

//grab the encrypted properties file

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

abstract class JpegeryTest extends \PHPUnit_Extensions_Database_TestCase {

	/**
	 * Creates an invalid int key for relative fields
	 * @var int INVALID_KEY
	 */
	const INVALID_KEY = 4294967296;

	/**
	 * PHPUnit database connection interface
	 * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
	 */
	protected $connection = null;

	public final function getDataSet() {
		$dataset = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());

		//Add all the tables for the project here

		$dataset->addTable("profile");
		$dataset->addTable("image");
		$dataset->addTable("tag");
		$dataset->addTable("comment");
		$dataset->addTable("vote");
		$dataset->addTable("imageTag");
		$dataset->addTable("follower");

		return($dataset);
	}


	/**
	 * @see https://phpunit.de/manual/current/en/fixtures.html#fixtures.more-setup-than-teardown
	 * @see https://github.com/sebastianbergmann/dbunit/issues/37
	 * @return \PHPUnit_Extensions_Database_Operation_Composite array containing delete and insert
	 */
	public final function getSetUpOperation() {
		return new \PHPUnit_Extensions_Database_Operation_Composite(array( \PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),  \PHPUnit_Extensions_Database_Operation_Factory::INSERT()));
	}
	/**
	 * templates the tearDown method that runs after each test. Cleanup, basically.
	 *
	 * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation deletes the database
	 */
	public final function getTearDownOperation() {
		return(\PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL());
	}

	/**
	 * sets up the database connection and provides it to PHPUnit
	 *
	 * @see <https://phpunit.de/manual/current/en/database.html#database.configuration-of-a-phpunit-database-testcase>
	 * @return \PHPUnit_Extensions_Database_DB_IDatabaseConnection PHPUnit database connection interface
	 */
	public final function getConnection() {
		//If the connection has not been established yet, create it
		if($this->connection === null) {
			//connect to mySQL and provide the interface to PHPUnit

			$config = readConfig("/etc/apache2/capstone-mysql/jpegery.ini");
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/jpegery.ini");
			$this->connection = $this->createDefaultDBConnection($pdo, $config["database"]);
		}
		return($this->connection);
	}

	/**
	 * returns the actual PDO object
	 *
	 * @return \PDO active PDO object
	 */
	public final function getPDO() {
		return($this->getConnection()->getConnection());
	}
}