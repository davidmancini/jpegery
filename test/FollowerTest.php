<?php
namespace Edu\Cnm\Jpegery;

//Grab the project test parameters
require_once("JpegeryTest.php");


require_once(dirname(__DIR__) . "/php/classes/autoload.php");

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

	/**
	 * Test inserting a Follower relationship and making sure it was inserted properly
	 */
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
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidFollower() {
		//Create a follower relationship without foreign keys
		$follow = new Follower(null, null);
	}

	/**
	 * Test creating a Follower relationship and then deleting it
	 */
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
		$this->asserEquals($numRows, $this->getConnection()->getRowCount("follower"));
	}

	/**
	 * Test deleting a Follower relationship that does not exist
	 *
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidFollower() {
		//Create a Follower relationship and try to delete it without inserting it.
		$follow = new Follower($this->follower->getProfileId(), $this->followed->getProfileId());
		$follow->delete($this->getPDO());
	}

	/**
	 * Test grabbing a Follower relationship with the id of the person following
	 */
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
	 */
	public function testGetInvalidFollowerByFollowerId() {
		//Search for a follower id that cannot exist
		$follow = Follower::getFollowerByFollowerId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertCount(0, $follow);
	}

	/**
	 * Test grabbing a Follower relationship with the id of the person being followed
	 */
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
	 */
	public function testGetInvalidFollowByFollowedId() {
		//Search for a followed id that cannot exist
		$follow = Follower::getFollowerByFollowedId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertCount(0, $follow);
	}

	/**
	 * Test grabbing a Follower relationship with both the Follower and Followed known
	 */
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
	 */
	public function testGetInvalidFollowerByFollowerIdAndFollowedId() {
		//Grab a follower id and followed id that do not exist
		$follow = Follower::getFollowerByFollowerIdAndFollowedId($this->getPDO(), JpegeryTest::INVALID_KEY, JpegeryTest::INVALID_KEY);
		$this->assertNull($follow);
	}

}