<?php

namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\{
	Tag
};

//grab the project test parameters
require_once("JpgeryTest.php");

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
		$tag = new Tag(null, $this->tag->getTagName(), $this->VALID_TAGNAME);
		$tag->insert($this->getPDO());
	}

	/**
	 * Test inserting a Tag that already exists
	 *
	 * @epectedException PDOException
	 */
	public function testUpdateValidTag() {
		//create a Tag with a non null id and watch it fail
		$tag = new Tag(JpegeryTest::INVALID_KEY, $this->tag->getTagId(), $this->VALID_TAGNAME);
	}

	/**
	 * test inserting a tag and editing it, and then updating it
	 **/

	public function testUpdateValidTagName

}
