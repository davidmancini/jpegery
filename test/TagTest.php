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
	 * @var string $VALID_TAGNAME
	 **/

	protected $VALID_TAGNAME = "PHPUnitTestPass";

	/**
	 * tag id
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
		$tag = new Tag(null, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
	}

	/**
	 * Test inserting a Tag that already exists
	 *
	 * @epectedException PDOException
	 */
	public function testInsertInvalidTag() {
		//create a Tag with a non null id and watch it fail
		$tag = new Tag(JpegeryTest::INVALID_KEY, $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());

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

		//grab the data from mySQL and enforce the fields that match our expectations
		$results = Tag::getTagByTagName($this->getPDO(), $tag->getTagName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount());
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstanceOf("Edu\\Cnm\\Jpegery\\Classes\\tag, $results");

		//grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $this->tag->getTagId());
		$this->assertEquals($pdoTag->getTweetName(), $this->VALID_TAGNAME);
	}

	/**
	 * test grabbing a tag that does not exist
	 **/
	public function getAllValidTags() {

		//grab a tag id that exeeds the maximum allowable tag id
		$tag = Tag::getTagByTagName($this->getPDO(), "nobody ever made this tag");
		$this->asserCount(0, $tag);
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
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Classes\\Tag");

		//grab the result from the array and validate it
		$pdoTag = $results[0];
		$this->assertEquals($pdoTag->getTagId(), $this->tag->getTagId());
		$this->assertEquals($pdoTag->getTagName(), $this->VALID_TAGNAME);


	}

}
