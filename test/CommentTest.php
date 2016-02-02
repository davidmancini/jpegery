<?php
namespace Edu\Cnm\Jpegery;

use Edu\Cnm\Jpegery\{Comment, Image, Profile};

//Grab the project test parameters
require_once("JpegeryTest.php");

//Grab Comment.php
//Not sure if there's an error below?
require_once(dirname(__DIR__, 1) . "/php/classes/autoload.php");

class CommentTest extends JpegeryTest {

	/**
	 * content of first comment
	 * @var string $VALID_COMMENTTEXT
	 */
	protected $VALID_COMMENTTEXT = "PHPUnit test is passing";

	/**
	 * content of comment after update
	 * @var string $VALID_COMMENTTEXT2
	 */
	protected $VALID_COMMENTTEXT2 = "PHPUnit is still passing";

	/**
	 * timestamp of the comment; starts as null
	 * @var \DateTime $VALID_COMMENTDATE
	 */
	protected $VALID_COMMENTDATE = null;

	/**
	 * Profile that posted comment; a foreign key
	 * @var Profile profile
	 */
	protected $profile = null;

	/**
	 * Image that comment was regarding; a foreign key
	 * @var Image $image
	 */
	protected $image = null;

	public final function setUp() {
		//Run the default setUp() method first
		parent::setUp();

		//Create and insert a Profile to post the test Comment
		//TODO: Finish this.
		$this->profile = new Profile(null, "John Public", "John", "867-5309");

	}

	public function testInsertValidComment () {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTTEXT, $this->VALID_COMMENTDATE);
		$comment->insert($this->getPDO());

		//Grab the data from mySQL and ensure that the fields match our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());

	}
}