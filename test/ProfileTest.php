<?php
/**
 * Created by PhpStorm.
 * User: michaelkemm
 * Date: 2/3/16
 * Time: 11:21 AM
 */
namespace Edu\Cnm\Jpegery\Test;


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
	protected $VALID_PROFILEADMIN = false;

	/**
	 * profile creation date
	 * @var int $VALID_PROFILECREATEDATE
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
	protected $VALID_PROFILEIMAGEID = 1;

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
	 * profile verification email
	 * @var $VALID_PROFILEVERIFY
	 */
	protected $VALID_PROFILEVERIFY = "PHPUnit test pass";


	public final function setUp() {

		// calculate the date
		$this->VALID_PROFILECREATEDATE = new\DateTime();

	}


	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileAdmin(), $this->VALID_PROFILEADMIN);
		$this->assertEquals($pdoProfile->getProfileCreateDate(), $this->VALID_PROFILECREATEDATE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileHandle(), $this->VALID_PROFILEHANDLE);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILEHASH);
		$this->assertEquals($pdoProfile->getProfileImageId(), $this->VALID_PROFILEIMAGEID);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILEPHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILESALT);
		$this->assertEquals($pdoProfile->getProfileVerify(),$this->VALID_PROFILEVERIFY);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidProfile() {
		// create a Profile with a non null Profile id and watch it fail
		$profile = new Profile(JpegeryTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->insert($this->getPDO());

		// edit the profile and update it in mySQL
		$profile->setProfile($this->VALID_);
		$profile->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileAdmin(), $this->VALID_PROFILEADMIN);
		$this->assertEquals($pdoProfile->getProfileCreateDate(), $this->VALID_PROFILECREATEDATE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileHandle(), $this->VALID_PROFILEHANDLE);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILEHASH);
		$this->assertEquals($pdoProfile->getProfileImageId(), $this->VALID_PROFILEIMAGEID);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILEPHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILESALT);
		$this->assertEquals($pdoProfile->getProfileVerify(),$this->VALID_PROFILEVERIFY);
	}

	/**
	 * test updating a Vote that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testUpdateInvalidVote() {
		// create a Profile with a non null Profile id and watch it fail
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->update($this->getPDO());
	}

	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Vote and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->insert($this->getPDO());

		// delete the Profile from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// grab the data from mySQL and enforce the Profile does not exist
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}


	/**
	 * test deleting a Profile that does not exist
	 *
	 * @expectedException PDOException
	 **/
	public function testDeleteInvalidProfile() {
		// create a Profile and try to delete it without actually inserting it
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->delete($this->getPDO());
	}


	/**
	 * test inserting a Profile and regrabbing it from mySQL
	 **/
	public function testGetValidProfileByProfileId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("profile");

		// create a new Profile and insert to into mySQL
		$profile = new Profile(null, $this->profile->getProfileId(), $this->VALID_PROFILEADMIN, $this->VALID_PROFILECREATEDATE, $this->VALID_PROFILEEMAIL, $this->VALID_PROFILEHANDLE, $this->VALID_PROFILEHASH, $this->VALID_PROFILEIMAGEID, $this->VALID_PROFILENAME, $this->VALID_PROFILEPHONE, $this->VALID_PROFILESALT, $this->VALID_PROFILEVERIFY);
		$profile->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileAdmin(), $this->VALID_PROFILEADMIN);
		$this->assertEquals($pdoProfile->getProfileCreateDate(), $this->VALID_PROFILECREATEDATE);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_PROFILEEMAIL);
		$this->assertEquals($pdoProfile->getProfileHandle(), $this->VALID_PROFILEHANDLE);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_PROFILEHASH);
		$this->assertEquals($pdoProfile->getProfileImageId(), $this->VALID_PROFILEIMAGEID);
		$this->assertEquals($pdoProfile->getProfileName(), $this->VALID_PROFILENAME);
		$this->assertEquals($pdoProfile->getProfilePhone(), $this->VALID_PROFILEPHONE);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_PROFILESALT);
		$this->assertEquals($pdoProfile->getProfileVerify(),$this->VALID_PROFILEVERIFY);
	}

	/**
	 * test grabbing a vote that does not exist
	 **/
	public function testGetInvalidProfileByProfileId() {
		// grab a profile id that exceeds the maximum allowable profile id
		$profile = Profile::getProfileByProfileId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertNull($profile);
	}


}




