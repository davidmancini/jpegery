<?php
namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\Follower;
use Edu\Cnm\Jpegery\Profile;
//Grab the project test parameters
require_once("JpegeryTest.php");


require_once(dirname(__DIR__) . "/php/classes/autoload.php");

class FollowerTest extends JpegeryTest {

	/**
	 * Profile that is following another profile
	 * @var \Edu\Cnm\Jpegery\Profile $follower
	 **/
	protected $follower = null;

	/**
	 * Profile that is being followed by another profile
	 * @var \Edu\Cnm\Jpegery\Profile $followed
	 **/
	protected $followed = null;

	/**
	 * Create dependent objects before running each test
	 **/
	public final function setUp() {
		//Run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
		//Create and insert a profile for the follower object
		$this->follower = new Profile(null, true, null, "Email", "myName", $hash, 1, "mynameagain", "867", $salt, "def");
		$this->follower->insert($this->getPDO());
		$this->followed = new Profile(null, true, null, "Email2", "myName2", $hash, 2, "John", "5309", $salt, "abc");
		$this->followed->insert($this->getPDO());
	}

	/**
	 * Test inserting a Follower relationship and making sure it was inserted properly
	 **/
	public function testInsertValidFollower() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("follower");

		//Create a new follower relationship and insert it into mySQL
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->insert($this->getPDO());

		//Grab the data from mySQL and ensure that it was inserted properly
		$pdoFollow = Follower::getFollowerByFollowerIdAndFollowedId($this->getPDO(), $this->follower->getProfileId(), $this->followed->getProfileId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("follower"));
		$this->assertEquals($pdoFollow->getFollowerFollowerId(), $this->follower->getProfileId());
		$this->assertEquals($pdoFollow->getFollowerFollowedId(), $this->followed->getProfileId());
	}

	/**
	 * test creating a Follower relationship that cannot exist
	 *
	 * @expectedException \TypeError
	 **/
	public function testInsertInvalidFollower() {
		//Create a follower relationship without foreign keys
		$follow = new Follower(null, null);
		$follow->insert($this->getPDO());
	}

	/**
	 * Test creating a Follower relationship and then deleting it
	 **/
	public function testDeleteValidFollower() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("follower");

		//Create a new follower relationship and insert it into mySQL
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->insert($this->getPDO());

		//Delete the Follower from mySQL
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("follower"));
		$follow->delete($this->getPDO());

		//Grab the data from mySQL to make sure it is really dead
		$pdoFollow = Follower::getFollowerByFollowerIdAndFollowedId($this->getPDO(), $this->follower->getProfileId(), $this->followed->getProfileId());
		$this->assertNull($pdoFollow);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("follower"));
	}

	/**
	 * Test grabbing a Follower relationship with the id of the person following
	 **/
	public function testGetValidFollowerByFollowerId() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("follower");

		//Create a new follower relationship and insert it into mySQL
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->insert($this->getPDO());
		$results = Follower::getFollowerByFollowerId($this->getPDO(), $this->follower->getProfileId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("follower"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Follower", $results);

		//Grab the result from the array and validate it
		$pdoFollow = $results[0];
		$this->assertEquals($pdoFollow->getFollowerFollowerId(), $this->follower->getProfileId());
		$this->assertEquals($pdoFollow->getFollowerFollowedId(), $this->followed->getProfileId());
	}

	/**
	 * Test trying to locate the Follow relationships of a Follower who does not exist
	 **/
	public function testGetInvalidFollowerByFollowerId() {
		//Search for a follower id that cannot exist
		$follow = Follower::getFollowerByFollowerId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertCount(0, $follow);
	}

	/**
	 * Test grabbing a Follower relationship with the id of the person being followed
	 **/
	public function testGetValidFollowerByFollowedId() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("follower");

		//Create a new follower relationship and insert it into mySQL
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->insert($this->getPDO());
		$results = Follower::getFollowerByFollowedId($this->getPDO(), $this->followed->getProfileId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("follower"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Follower", $results);

		//Grab the result from the array and validate it
		$pdoFollow = $results[0];
		$this->assertEquals($pdoFollow->getFollowerFollowerId(), $this->follower->getProfileId());
		$this->assertEquals($pdoFollow->getFollowerFollowedId(), $this->followed->getProfileId());
	}

	/**
	 * Test grabbing a Follow relationship with a Followed id that cannot exist
	 **/
	public function testGetInvalidFollowByFollowedId() {
		//Search for a followed id that cannot exist
		$follow = Follower::getFollowerByFollowedId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertCount(0, $follow);
	}

	/**
	 * Test grabbing a Follower relationship with both the Follower and Followed known
	 **/
	public function testGetValidFollowerByFollowerIdAndFollowedId() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("follower");

		//Create a new follower relationship and insert it into mySQL
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->insert($this->getPDO());

		//Grab the data from mySQL and ensure that it was inserted properly
		$pdoFollow = Follower::getFollowerByFollowerIdAndFollowedId($this->getPDO(), $this->follower->getProfileId(), $this->followed->getProfileId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("follower"));
		$this->assertEquals($pdoFollow->getFollowerFollowerId(), $this->follower->getProfileId());
		$this->assertEquals($pdoFollow->getFollowerFollowedId(), $this->followed->getProfileId());
	}

	/**
	 * Test grabbing a relationship where neither follower nor followed exist
	 **/
	public function testGetInvalidFollowerByFollowerIdAndFollowedId() {
		//Grab a follower id and followed id that do not exist
		$follow = Follower::getFollowerByFollowerIdAndFollowedId($this->getPDO(), JpegeryTest::INVALID_KEY, JpegeryTest::INVALID_KEY);
		$this->assertNull($follow);
	}

	/**
	 * @expectedException \RangeException
	 **/
	public function testSetInvalidFollowerByNegativeFollowerId() {
		$follow = new Follower(-1, $this->followed->getProfileId());
		$follow->insert($this->getPDO());
	}
	/**
	 * @expectedException \RangeException
	 **/
	public function testSetInvalidFollowerByNegativeFollowedId() {
		$follow = new Follower($this->follower->getProfileId(), -1);
		$follow->insert($this->getPDO());
	}
}