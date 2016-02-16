<?php

namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\Tag;

//grab the project test parameters
require_once("JpegeryTest.php");

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * This is a complete PHPUnit test for the Tag class of the Jpegery app
 *It is complete because *ALL* mySQL/PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Tag
 * @authors David Mancini, Jacob Findley, Michael Kemm, Zach Leyba
 **/
class TagTest extends JpegeryTest {

	/**
	 * tag id
	 * @var int $TAGID
	 **/
	protected $VALID_TAGID = "null";


	/**
	 * tag name
	 * @var string $VALID_TAGNAME
	 **/

	protected $VALID_TAGNAME = "PHPUnitTestPass";

	/**
	 * tag name
	 * @var string $VALID_TAGNAME2
	 **/

	protected $VALID_TAGNAME2 = "PHPUnitStillPassing";

	/**
	 * Test inserting a valid Tag and verify that the actual mySQL data matches
	 */

	public function testInsertValidTag() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		//create a new Tag and insert it into mySQL
		$tag = new Tag(null, $this->VALID_TAGID);
		$tag->insert($this->getPDO());

		//grab data from mySQL and enforce firleds to match expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGID);
	}

	/**
	 * Test inserting a Tag that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidTag() {
		//create a Tag with a non null id and watch it fail
		$tag = new Tag(JpegeryTest::INVALID_KEY, $this->VALID_TAGID);
		$tag->insert($this->getPDO());
	}

	/**
	 * test creating a tag and then deleting it
	 **/

	public function testDeleteValidTag() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		//create a new tag and insert it into mySQL
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		//delete the tag from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$tag->delete($this->getPDO());

		//grab the data from mySQL and enforce the tag does not exist
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertNull($pdoTag);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("tag"));
	}

	/**
	 * test inserting a tag and editing it, and then updating it
	 **/

	public function testUpdateValidTagName() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		//create a new tag and insert it into mySQL
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		//Edit the tag and update it
		$tag->setTagName($this->VALID_TAGNAME2);
		$tag->update($this->getPDO());

		//grab the data from mySQL and enforce the fields that match our expectations
		$pdoTag = Tag::getTagByTagId($this->getPDO(), $tag->getTagId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME2);
	}

	/**
	 * test deleting a tag that does not exist
	 *
	 * @expectedException PDOException
	 **/

	public function testDeleteInvalidTag() {
		//create a tag and try to delete it without actually inserting it
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->delete($this->getPDO());
	}


	/**
	 * test grabbing a tag that does not exist
	 **/
	public function getAllValidTags() {

		//grab a tag id that exeeds the maximum allowable tag id
		$tag = Tag::getTagByName($this->getPDO(), "nobody ever made this tag");
		$this->asserCount(0, $tag);
}

	/**
	 * test grabbing a tag by Name
	 **/

	public function testGetTagByName() {

		//count the number of rows and save them for later
		$numRows = $this->getConnection()->getRowCount("tag");

		//create new tag and insert it into the database
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
		var_dump($tag);

		//get data from database and ensure the fields match
		$pdoTag = Tag::getTagByName($this->getPDO(), $tag->getTagName());
		var_dump($pdoTag);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertEquals($pdoTag->getTagId(), $this->VALID_TAGID);
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);
	}

	/**
	 * test grabbing all tags
	 **/

	public function testGetAllValidTags() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("tag");

		//create a new Tag and insert it into mySQL
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Tag::getAllTags($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("tag"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Tag", $results);

		//grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $tag->getTagId());
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);


	}

}
