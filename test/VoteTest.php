<?php
/**
 * Created by PhpStorm.
 * User: michaelkemm
 * Date: 2/3/16
 * Time: 3:03 PM
 */

namespace Edu\Cnm\Jpegery\test;

use Edu\CNM\Jpegery\JpegeryTest;
use Edu\Cnm\Jpegery\Profile;

// get the project test parameters
require_once("JpegeryTest.php");

//
require_once(dirname(__DIR__) . "jpegery/classes/autoload.php");

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
	 *  voe profile id
	 * @var $VALID_VOTEPROFILEID
	 */
	protected $VALID_VOTEPROFILEID = "PHPUnit test passing";

	/**
	 * vote profile id
	 * @var $VALID_VOTEIMAGEID
	 */
	protected $VALID_VOTEIMAGEID = null;

	/**
	 * vote type
	 * @var  $VALID_VOTEVALUE
	 */
	protected $VALID_VOTEVALUE = null;

	/**
	 * create dependent objects before running each test
	 **/

	public final function setUp() {
		// run the default setUp() method first
		parent::setUp();

		// create and insert a Profile to own the test profile
		$this->voteProfile = new VoteProfile(null, "@phpunit", "test@phpunit.de", "+12125551212");
		$this->voteProfile->insert($this->getPDO());

	}

	//todo add voteImageId det up function





	/**
	 * test inserting a valid Vote and verify that the actual mySQL data matches
	 **/
	public function testInsertValidVote() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vote");

		// create a new Tweet and insert to into mySQL
		$vote = new Vote(null, $this->voteProfile->getVoteProfileId(), $this->voteImage->getVoteImageId(), $this->VALID_VOTETYPE);
		$vote->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoVote = Vote::getVoteByVoteId($this->getPDO(), $vote->getVoteId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("vote"));
		$this->assertEquals($pdoVote->getVoteProfileId(), $this->voteProfile->getVoteProfileId());
		$this->assertEquals($pdoVote->getVoteImageId(), $this->voteImage->getVoteImageId());
		$this->assertEquals($pdoVote->getVoteValue(), $this->VALID_VOTEVALUE);
	}

/**
 * test inserting a Vote that already exists
 *
 * @expectedException PDOException
 **/
public function testInsertInvalidVote() {
	// create a Vote with a non null Vote id and watch it fail
	$vote = new Vote(DataDesignTest::INVALID_KEY, $this->voteProfile->getvoteProfileId(), $this->voteImage->getVoteImageId(), $this->VALID_VOTEVALUE);
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
	$vote = new Vote(null, $this->profile->getProfileId(), $this->voteImage->getvoteImageId(), $this->VALID_TWEETDATE);
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

























}