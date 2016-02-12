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
	 *  vote id
	 * @var $VALID_VOTEID
	 */
	protected $VALID_VOTEID = null;
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
		$this->voteProfile = new Profile(null, true, null, "Email", "myName", "passw0rd", 1, "mynameagain", "867", "456", "yes");
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
		$vote = new Vote(null, $this->voteProfile->getProfileId(), $this->voteImage->getImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByProfileIdAndImage($this->getPDO(), $vote->getVoteId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/**
	 * test inserting a Vote that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidVote() {
		// create a Vote with a non null Vote id and watch it fail
		$vote = new Vote(JpegeryTest::INVALID_KEY, $this->voteProfile->getvoteProfileId(), $this->voteImage->getVoteImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());
	}

	/**
	 * test inserting a Vote, editing it, and then updating it
	 **/
	public function testUpdateValidVote() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote(null, $this->voteProfile->getVoteProfileId(), $this->voteImage->getVoteImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// edit the vote value and update it in mySQL
		$vote->setVoteValue($this->VALID_VOTEVALUE);
		$vote->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteId($this->getPDO(), $vote->getVoteId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getVoteProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getVpteImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/**
	 * test updating a Vote that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidVote() {
		// create a Vote with a non null Vote id and watch it fail
		$vote = new Vote(null, $this->voteProfile->getProfileId(), $this->voteImage->getvoteImageId(), $this->VALID_TWEETDATE);
		$vote->update($this->getPDO());
	}

	/**
	 * test creating a Vote and then deleting it
	 **/
	public function testDeleteValidVote() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote(null, $this->voteProfile->getVoteProfileId(), $this->voteImage->getVoteImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// delete the Vote from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$vote->delete($this->getPDO());

		// grab the data from mySQL and enforce the Vote does not exist
		$pdoVote = Vote::getVoteByVoteId($this->getPDO(), $vote->getVoteId());
		$this->assertNull($pdoVote);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("vote"));
	}


	/**
	 * test deleting a Vote that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidVote() {
		// create a Vote and try to delete it without actually inserting it
		$vote = new Vote(null, $this->voteProfile->getVoteProfileId(), $this->imageId->getVoteImageId(), $this->VALID_VOTEVALUE);
		$vote->delete($this->getPDO());
	}


	/**
	 * test inserting a Vote then grabbing it from mySQL
	 **/
	public function testGetValidVoteByVoteId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Vote and insert to into mySQL
		$vote = new Vote(null, $this->voteProfile->getVoteProfileId(), $this->voteImageId->getVoteImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteId($this->getPDO(), $vote->getVoteId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getProfileId(), $this->voteProfile->getVoteProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getVoteImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

	/**
	 * test grabbing a vote that does not exist
	 **/
	public function testGetInvalidVoteByVoteId() {
		// grab a profile id that exceeds the maximum allowable profile id
		$vote = Vote::getVoteByVoteId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertNull($vote);
	}

	/**
	 * test grabbing a Vote by vote value
	 **/
	public function testGetValidVoteByVoteValue() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Tweet and insert to into mySQL
		$vote = new Vote(null, $this->voteProfile->getVoteProfileId(), $this->voteImageId->getVoteImageId(), $this->VALID_VOTEVALUE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Vote::getVoteByVoteValue($this->getPDO(), $vote->getVotevalue());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Vote", $results);

		// grab the result from the array and validate it
		$pdoVote = $results[0];
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getVoteProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImageId->getVoteImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}


}