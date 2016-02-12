<?php
namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\ImageTag;
use Edu\Cnm\Jpegery\Image;
use Edu\Cnm\Jpegery\Profile;
use Edu\Cnm\Jpegery\Tag;

//Grab the project test parameters
require_once("JpegeryTest.php");


require_once(dirname(__DIR__) . "/php/classes/autoload.php");
class ImageTagTest extends JpegeryTest {

	/**
	 * Image that is tagged
	 * @var \Edu\Cnm\Jpegery\Image $imageTagImage
	 **/
	protected $imageTagImage = null;

	/**
	 * Tag that is given
	 * @var \Edu\Cnm\Jpegery\Tag $imageTagTag
	 **/
	protected $imageTagTag = null;

	/**
	 * The profile that authors the image
	 * @var \Edu\Cnm\Jpegery\Profile
	 **/
	protected $profile = null;


	/**
	 * Create dependant objects before running each test
	 **/
	public final function setUp() {
		//Run the default setUp() method first
		parent::setUp();

		$this->profile = new Profile(null, true, null, "Email", "myName", "passw0rd", 1, "mynameagain", "867", "5309", "def");
		$this->profile->insert($this->getPDO());

		$this->imageTagImage = new Image(null, $this->profile->getProfileId(), "jpeg", "myfile", "theText", null);
		$this->imageTagImage->insert($this->getPDO());

		$this->imageTagTag = new Tag(null, "Photo");
		$this->imageTagTag->insert($this->getPDO());
	}

	/**
	 * Test inserting an ImageTag
	 **/
	public function testInsertValidImageTag() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("imageTag");
		$imageTag = new ImageTag($this->imageTagImage->getImageId(), $this->imageTagTag->getTagId());
		$imageTag->insert($this->getPDO());

		//Grab the data from sql and ensure that it was inserted properly.
		$pdoImageTag = ImageTag::getImageTagByImageIdAndTagId($this->getPDO(), $this->imageTagImage->getImageId(), $this->imageTagTag->getTagId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("imageTag"));
		$this->assertEquals($pdoImageTag->getImageId(), $this->imageTagImage->getImageId());
		$this->assertEquals($pdoImageTag->getTagId(), $this->imageTagTag->getTagId());
	}

	/**
	 * Test creating an invalid ImageTag
	 *
	 * @expectedException \TypeError
	 **/
	public function testInsertInvalidImageTag() {
		$imageTag = new ImageTag(null, null);
		$imageTag->insert($this->getPDO());
	}

	/**
	 * Test deleting an imageTag
	 **/
	public function testDeleteValidImageTag() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("imageTag");
		$imageTag = new ImageTag($this->imageTagImage->getImageId(), $this->imageTagTag->getTagId());
		$imageTag->insert($this->getPDO());

		//Delete the ImageTag from mySQL
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("imageTag"));
		$imageTag->delete($this->getPDO());

		//Grab the data from mySQL to make sure it is really dead
		$pdoImageTag = ImageTag::getImageTagByImageIdAndTagId($this->getPDO(), $this->imageTagImage->getImageId(), $this->imageTagTag->getTagId());
		$this->assertNull($pdoImageTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("imageTag"));
	}

	public function testGetValidImageTagByImageId() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("imageTag");

		$imageTag = new ImageTag($this->imageTagImage->getImageId(), $this->imageTagTag->getTagId());
		$imageTag->insert($this->getPDO());
		$results = ImageTag::getImageTagByImageId($this->getPDO(), $this->imageTagImage->getImageId());

	}
}