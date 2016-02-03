<?php
namespace Edu\Cnm\Jpegery;

use Edu\Cnm\Jpegery\Profile;

//Grab the project test parameters
require_once("JpegeryTest.php");


require_once(dirname(__DIR__, 1) . "/php/classes/autoload.php");

class FollowerTest extends JpegeryTest {

	/**
	 * Profile that is following another profile
	 * @var \Edu\Cnm\Jpegery\Profile $follower
	 */
	protected $follower = null;

	/**
	 * Profile that is being followed by another profile
	 * @var \Edu\Cnm\Jpegery\Profile $followed
	 */
	protected $followed = null;

	/**
	 * Create dependent objects before running each test
	 */
	public final function setUp() {
		//Run the default setUp() method first
		parent::setUp();

		//Create and insert a profile for the follower object
		//TODO: Finish this once profile is good.
		$this->follower = new Profile(null, null, null, "Email", "myName", "passw0rd", "null", "mynameagain", "867", "456", "def");
		$this->followed = new Profile(null, null, null, "Email2", "myName2", "passWARD", "null", "John", "5309", "123", "abc");
	}

	public function testInsertValidFollower() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("follower");

		//Create a new follower relationship and insert it into mySQL
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->insert($this->getPDO());


	}
}