<?php

namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\Profile;
use Edu\Cnm\Jpegery\Vote;
use Edu\Cnm\Jpegery\Image;

// get the project test parameters
require_once("JpegeryTest.php");

//
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * PHPUnit test for the profile class
 *
 * This is a complete PHPUnit test of the Profile class.
 * It is coplete because *ALL* MySQL/PDO enabled methods are tested for valid and invalid inputs.
 *
 * @see Profile
 * @author Michael Kemm
 */
class VoteTest extends JpegeryTest {


	/**
	 *  vote profile id
	 * @var $VALID_VOTEPROFILEID
	 */

	/**
	 * vote type
	 * @var  $VALID_VOTEVALUE
	 */
	protected $VALID_VOTEVALUE = 1;

	/**
	 * create dependent objects before running each test
	 **/

	/**
	 * @var Profile $profile
	 */
	protected $voteProfile = null;
	/**
	 * @var Image $image
	 */
	protected $voteImage = null;

	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile
		$password = "abc123";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
		$this->voteProfile = new Profile(null, true, null, "Email", "myName", $hash, 1, "mynameagain", "867", $salt, "yes");
		$this->voteProfile->insert($this->getPDO());

		// create and insert an Image
		$this->voteImage = new Image(null, $this->voteProfile->getProfileId(), "jpeg", "myfile", "theText", null);
		$this->voteImage->insert($this->getPDO());

	}


	/**
	 * test inserting a valid Vote and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVote() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteProfileIdAndVoteImageId($this->getPDO(), $this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/**
	 * test inserting a Vote that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidVote() {
		// create a Vote with a non null Vote id and watch it fail
		$vote = new Vote(JpegeryTest::INVALID_KEY, $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
	}

	/**
	 * test inserting a Vote, editing it, and then updating it
	 **/
	public function testUpdateValidVote() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// edit the vote value and update it in mySQL
		$vote->setVoteValue($this->VALID_VOTEVALUE);
		$vote->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteProfileIdAndVoteImageId($this->getPDO(), $this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}


	/**
	 * test creating a Vote and then deleting it
	 **/
	public function testDeleteValidVote() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// delete the Vote from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$vote->delete($this->getPDO());

		// grab the data from mySQL and enforce the Vote does not exist
		$pdoVote = Vote::getVoteByVoteProfileIdAndVoteImageId($this->getPDO(), $this->voteProfile->getProfileId(), $this->voteImage->getImageId());
		$this->assertNull($pdoVote);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("vote"));
	}




	/**
	 * test inserting a Vote then grabbing it from mySQL
	 **/
	public function testGetValidVoteByVoteId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteProfileIdAndVoteImageId($this->getPDO(), $this->voteProfile->getProfileId(), $this->voteImage->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/**
	 * test grabbing a vote that does not exist
	 **/
	public function testGetInvalidVoteProfileIdAndVoteImageId() {
		// grab a profile id that exceeds the maximum allowable profile id
		$vote = Vote::getVoteByVoteProfileIdAndVoteImageId($this->getPDO(), JpegeryTest::INVALID_KEY, JpegeryTest::INVALID_KEY );
		$this->assertNull($vote);
	}

	/**
	 * test grabbing all Votes
	 **/
	public function testGetAllValidVotes() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote($this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getAllvotes($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Vote", $results);

		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}


}