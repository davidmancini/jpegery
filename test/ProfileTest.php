<?php
	/**
	 * Created by PhpStorm.
	 * User: michaelkemm
	 * Date: 2/3/16
	 * Time: 11:21 AM
	 */
	namespace Edu\Cnm\Jpegery\test;


	use Edu\Cnm\Jpegery\Profile;

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

	class ProfileTest extends JpegeryTest {


		/**
		 * profile admin
		 * @var $VALID_PROFILEADMIN
		 */
		protected $VALID_PROFILEADMIN = null;

		/**
		 * profile creation date
		 * @var  $VALID_PROFILECREATEDATE
		 */
		protected $VALID_PROFILECREATEDATE = null;

		/**
		 * profile email
		 * @var $VALID_PROFILEEMAIL
		 */
		protected $VALID_PROFILEEMAIL = "PHPUnit test pass";

		/**
		 * profile handle
		 * @var $VALID_PROFILEHANDLE
		 */
		protected $VALID_PROFILEHANDLE = "PHPUnit test pass";

		/**
		 * profile hash
		 * @var $Valid_PROFILEHASH
		 */
		protected $VALID_PROFILEHASH = "PHPUnit test pass";

		 /**
		  * profile avatar
		  * @var $VALID_PROFILEIMAGEID
		  */
		protected $VALID_PROFILEIMAGEID = "PHPUnit test pass";

		 /**
		  * user name
		  * @var  $VALID_PROFILENAME
		  */
		protected $VALID_PROFILENAME = "PHPUnit test pass";

		/**
		 * phone number
		 * @var $VALID_PROFILEPHONE
		 */
		protected $VALID_PROFILEPHONE = "PHPUnit test pass";

		/**
		 * profile salt
		 * @var $VALID_PROFILESALT
		 */
		protected $VALID_PROFILESALT = "PHPUnit test pass";


		/**
		 * test inserting a valid Profile and verify that the actual mySQL data matches
		 **/
		public function testInsertValidProfile() {
			// count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("profile");

			// create a new Profile and insert to into mySQL
			$profile = new Profile(null, $this->Profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT);
			$profile->insert($this->getPDO());

			// grab the data from mySQL and enforce the fields match our expectations
			$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
			$this->assertEquals($pdoProfile->getProfileId(), $this->Profile->getProfileId());
			$this->assertEquals($pdoProfile->getProfileAdmin(), $this->VALID_PROFILEADMIN);
			$this->assertEquals($pdoProfile->getProfileCreateDate(), $this->VALID_PROFILECREATEDATE);
			$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
			$this->assertEquals($pdoProfile->getProfileHandle(), $this->VALID_PROFILEHANDLE);
			$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILEHASH);
			$this->assertEquals($pdoProfile->getProfileImageId(), $this->VALID_PROFILEIMAGEID);
			$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
			$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILEPHONE);
			$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILESALT);
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
		 * test inserting a Vote and regrabbing it from mySQL
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
			$vote = Vote::getVoteByVoteId($this->getPDO(), DataDesignTest::INVALID_KEY);
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




