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


}