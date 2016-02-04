<?php
namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\{Profile, Image};

//Grab test parameters
require_once ("JpegeryTest.php");

//Grab the class we're testing
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/*
 * PHPUnit test for Image class
 *
 * @see Image
 * @author David Mancini <hello@davidmancini.xyz>
 */

class ImageTest extends JpegeryTest {
	/*
	 * Profile that created the image for foreign key relations
	 * @var Profile profile
	 */
	protected $profile = null;

	/*
	 * Timestamp of the image; starts as null and is assigned later
	 * @var DateTime $VALID_IMAGEDATE
	 */
	protected $VALID_IMAGEDATE = null;

	/*
	 * String of image file name
	 * @var String $VALID_IMAGEFILENAME
	 */
	protected $VALID_IMAGEFILENAME = "image.jpg";

	/*
	 * String of image text
	 * @var String $VALID_IMAGETEXT
	 */
	protected $VALID_IMAGETEXT = "This is an image!";

	/*
	 * String of updated image text
	 * @var String $VALID_IMAGETEXT2
	 */
	protected $VALID_IMAGETEXT2 = "This is updated image text.";

	/*
 * String of image type
 * @var String $VALID_IMAGETYPE
 */
	protected $VALID_IMAGETYPE = "jpg";

	/*
	 * Create dependent objects before running each test
	 */
	public final function setUp() {
		//run the default setUp method first
		parent::setUp();

		//Create and insert a profile to own the test image
		//profileId, profileAdmin, profileCreateDate, profileEmail, profileHandle, profileHash, profileImageId, profileName, profilePhone, profileSalt, profileVerify
		$this->profile = new Profile(null, false, null, "test@example.com", "testGuy", null, null, "Test Guy", "800-555-1234", null, "true");
		$this->profile->insert($this->getPDO());

		//Calculate the date that was just set up
		$this->VALID_IMAGEDATE = new \DateTime();
	}

	/*
	 * Test inserting a valid image and verify that the actual MySQL data matches
	 */
	public function testInsertValidImage() {
		//Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//Create a new Image and insert into MySQL
		//newImageId, newProfileId, newImageType, newImageFileName, newImageText, newImageDate
		$image = new Image (null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Grab data from MySQL and enforce fields to match expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
		$this->assertEquals($pdoImage->getImageFileName(), $this->VALID_IMAGEFILENAME);
		$this->assertEquals($pdoImage->getImageText(), $this->VALID_IMAGETEXT);
		$this->assertEquals($pdoImage->getImageDate(), $this->VALID_IMAGEDATE);
	}

	/*
	 * Test inserting an image, editing it, then updating it
	 */

	public function testUpdateValidImage() {
		//Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//Create a new image and insert it into MySQL
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Edit the image and update it
		$image->setImageText($this->VALID_IMAGETEXT2);
		$image->update($this->getPDO());

		//Grab data from MySQL and ensure fields match expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
		$this->assertEquals($pdoImage->getImageFileName(), $this->VALID_IMAGEFILENAME);
		$this->assertEquals($pdoImage->getImageText(), $this->VALID_IMAGETEXT2);
		$this->assertEquals($pdoImage->getImageDate(), $this->VALID_IMAGEDATE);
	}

	/*
	 * Test creating an image and then deleting it
	 */
	public function testDeleteValidImage() {
		//Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//Create new image and insert into database
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Delete image from database
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$image->delete($this->getPDO());

		//Grab data from database and ensure the image does not exist
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertNull($pdoImage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("image"));
	}

	/*
	 * Test inserting an image that already exists
	 *
	 * @expectedException PDOException
	 */
	public function testInsertInvalidImage() {
		//Create an image with a non-null image id and watch it fail
		$image = new Image(JpegeryTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());
	}

	/*
	 * Test deleting an image that does not exist
	 *
	 * @expectedException PDOException
	 */
	public function testDeleteInvalidImage() {
		//Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//Create an image and try to delete it without first inserting it
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->delete($this->getPDO());
	}

	/*
	 * Test inserting an image and re-grabbing it from MySQL
	 */
	public function testGetValidImageByImageId() {
		//Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("image");

		//Create new image and insert into database
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Get data from database and ensure the fields match our expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
		$this->assertEquals($pdoImage->getImageFileName(), $this->VALID_IMAGEFILENAME);
		$this->assertEquals($pdoImage->getImageText(), $this->VALID_IMAGETEXT);
		$this->assertEquals($pdoImage->getImageDate(), $this->VALID_IMAGEDATE);
	}

	/*
	 * Test grabbing an image that does not exist
	 *
	 * @expectedExpectation PDOException
	 */
	public function testGetInvalidImageByImageId() {
		//Grab a profile id that exceeds the maximum allowable profile id
		$image = Image::getImageByImageId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertNull($image);
	}

	/*
	 * Test grabbing all Images
	 */
	public function testGetAllValidImages() {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("image");

		//Create new image and insert into database
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGEFILENAME, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Grab data from database and ensure it matches our expectations
		$results = Image::getAllImages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery", $results);

		//Grab the result from the array and validate it
		$pdoImage = $results[0];
		$this->assertEquals($pdoImage->getProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
		$this->assertEquals($pdoImage->getImageFileName(), $this->VALID_IMAGEFILENAME);
		$this->assertEquals($pdoImage->getImageText(), $this->VALID_IMAGETEXT);
		$this->assertEquals($pdoImage->getImageDate(), $this->VALID_IMAGEDATE);
	}









}