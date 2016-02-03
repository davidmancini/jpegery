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
		//run the decault setUp method first
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
		$image = new Image (null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Grab data from MySQL and enforce fields to match expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
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
		$image = new Image(null, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGETEXT, $this->VALID_IMAGEDATE);
		$image->insert($this->getPDO());

		//Edit the image and update it
		$image->setImageText($this->VALID_IMAGETEXT2);
		$image->update($this->getPDO());

		//Grab data from MySQL and ensure fields match expectations
		$pdoImage = Image::getImageByImageId($this->getPDO(), $image->getImageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("image"));
		$this->assertEquals($pdoImage->getImageProfileId(), $this->profile->getProfileId);
		$this->assertEquals($pdoImage->getImageType(), $this->VALID_IMAGETYPE);
		$this->assertEquals($pdoImage->getImageText(), $this->VALID_IMAGETEXT2);
		$this->assertEquals($pdoImage->getImageDate(), $this->VALID_IMAGEDATE);
	}

	/*
		 * Test inserting an image that already exists
		 *
		 * @expectedException PDOException
		 */
		public function testInsertInvalidImage() {
			//Create an image with a non-null image id and watch it fail
			$image = new Image(JpegeryTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_IMAGETYPE, $this->VALID_IMAGETEXT, $this->-$this->VALID_IMAGEDATE);
			$image->insert($this->getPDO());
		}











}