<?php
/**
 * Created by PhpStorm.
 * User: michaelkemm
 * Date: 2/3/16
 * Time: 11:21 AM
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

class ProfileTest extends JpegeryTest {

	/**
	 * profile id
	 * @var $VALID_PROFILEID
	 */
	protected $VALID_PROFILEID = "PHPUnit test passin";

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
	  * profile
	  * @var $VALID_PROFILEIMAGEID
	  */
	protected $VALID_PROFILEIMAGEID = "PHPUnit test pass";

	 /**
	  * profile
	  * @var  $VALID_PROFILENAME
	  */
	protected $VALID_PROFILENAME = "PHPUnit test pass";







}




