<?php
namespace Edu\Cnm\Jpegery\Test;

use Edu\Cnm\Jpegery\Comment;
use Edu\Cnm\Jpegery\Profile;
use Edu\Cnm\Jpegery\Image;

//Grab the project test parameters
//require_once("phpunit.xml");
require_once("JpegeryTest.php");

//Grab Comment.php
//Not sure if there's an error below?
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

class CommentTest extends JpegeryTest {

	/**
	 * content of first comment
	 * @var string $VALID_COMMENTTEXT
	 **/
	protected $VALID_COMMENTTEXT = "PHPUnit test is passing";

	/**
	 * content of comment after update
	 * @var string $VALID_COMMENTTEXT2
	 **/
	protected $VALID_COMMENTTEXT2 = "PHPUnit is still passing";

	/**
	 * This shall never be inserted
	 * @var string $INVALID_COMMENTTEXT
	 **/
	protected $INVALID_COMMENTTEXT = "To be used for failure.";

	/**
	 * timestamp of the comment; starts as null
	 * @var \DateTime $VALID_COMMENTDATE
	 **/
	protected $VALID_COMMENTDATE = null;

	/**
	 * A negative id for the purpose of error checking.
	 * @var int $NEGATIVE_ID
	 **/
	protected $NEGATIVE_ID = -1;

	/**
	 * Profile that posted comment; a foreign key
	 * @var \Edu\Cnm\Jpegery\Profile $profile
	 **/
	protected $profile = null;

	/**
	 * Image that comment was regarding; a foreign key
	 * @var \Edu\Cnm\Jpegery\Image $image
	 **/
	protected $image = null;

	/**
	 * @var string
	 */
	protected $INVALID_TEXTLENGTH = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiatnulla pariatur.";



	public final function setUp() {
		//Run the default setUp() method first
		parent::setUp();

		//Create and insert a Profile to post the test Comment
		$password = "abc123";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$verify = $salt;
		$hash = hash_pbkdf2("sha512", $password, $salt, 262144);
		$this->profile = new Profile(null, true, null, "Email", "myName", $hash, 1, "First", "Last", "867", $salt, $verify);
		$this->profile->insert($this->getPDO());

		$this->image = new Image(null, $this->profile->getProfileId(), "jpeg", "myfile", "theText", null);
		$this->image->insert($this->getPDO());
		//Calculate the date
		$this->VALID_COMMENTDATE = new \DateTime();
	}

	/**
	 * Test inserting a valid Comment and verify that the mySQL data matches
	 *
	 **/
	public function testInsertValidComment () {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Grab the data from mySQL and ensure that the fields match our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}

	/**
	 * Test inserting a comment that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidComment() {
		//Create a comment with an invalid id
		$comment = new Comment(JpegeryTest::INVALID_KEY, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}

	/**
	 * Test inserting a comment with invalid (Negative) input for the comment id itself
	 *
	 * @expectedException \RangeException
	 **/
	public function testInsertInvalidNegativeCommentId() {
		//Create a comment with a negative id
		$comment = new Comment($this->NEGATIVE_ID, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}

	/**
	 * Test inserting a comment with invalid (Negative) input for its image
	 *
	 * @expectedException \RangeException
	 **/
	public function testInsertInvalidNegativeImageId() {
		//Create a comment with a negative image id
		$comment = new Comment(null, $this->NEGATIVE_ID, $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}

	/**
	 * Test inserting a comment with invalid (Negative) input for its profile
	 *
	 * @expectedException \RangeException
	 **/
	public function testInsertInvalidNegativeProfileId() {
		//Create a comment with a negative profile id
		$comment = new Comment(null, $this->image->getImageId(), $this->NEGATIVE_ID, $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}

	/**
	 * Test inserting a comment, editing it, and then updating it.
	 **/
	public function testUpdateValidComment() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Edit the Comment and update it in mySQL
		$comment->setCommentText($this->VALID_COMMENTTEXT2);
		$comment->update($this->getPDO());

		//Grab the data from mySQL and check it against our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT2);
	}

	/**
	 * Test updating a Comment that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidComment() {
		//Test updating a comment without inserting it
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->update($this->getPDO());
	}

	/**
	 * Test creating and deleting a comment.
	 **/
	public function testDeleteValidComment() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("comment"));
		$comment->delete($this->getPDO());

		//Grab the data from mySQL and ensure that the comment has been properly...dealt with.
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertNull($pdoComment);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("comment"));
	}

	/**
	 * Test deleting a Comment that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidComment() {
		//Create a comment and delete it without actually inserting it.
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->delete($this->getPDO());
	}

	/**
	 * Test finding a comment through its id
	 **/
	public function testGetValidCommentByCommentId() {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Try to grab the comment in mySQL by its id
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}

	/**
	 * Test trying to grab a comment that does not exist
	 **/
	public function testGetInvalidCommentByCommentId() {
		//Attempt to grab a comment using an invalid comment id
		$comment = Comment::getCommentByCommentId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertNull($comment);
	}



	/**
	 * Testing Grabbing a comment by image id
	 **/
	public function testGetValidCommentByImageId() {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Try to grab the comment in mySQL by its image id
		$comments = Comment::getCommentByImageId($this->getPDO(), $comment->getCommentImageId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("comment"));
		$this->assertCount(1, $comments);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Comment", $comments);

		//Grab the result from the array and validate it (Note that the array could, in theory, hold multiple comments. This is just for testing.
		$pdoComment = $comments[0];
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}

	/**
	 * Test grabbing a comment by an image id that does not exist
	 **/
	public function testGetInvalidCommentByImageId() {
		//Attempt to grab a comment using an invalid image id
		$comment = Comment::getCommentByImageId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertCount(0, $comment);
	}

	/**
	 * Testing Grabbing a comment by a profile Id
	 **/
	public function testGetValidCommentByProfileId () {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Try to grab the comment in mySQL by its profile
		$comments = Comment::getCommentByProfileId($this->getPDO(), $comment->getCommentProfileId());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("comment"));
		$this->assertCount(1, $comments);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Comment", $comments);

		//Grab the result from the array and validate it (Could hold more)
		$pdoComment = $comments[0];
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}

	public function testGetInvalidCommentByProfileId() {
		//Attempt to grab a comment using an invalid profile id
		$comment = Comment::getCommentByProfileId($this->getPDO(), JpegeryTest::INVALID_KEY);
		$this->assertCount(0, $comment);
	}

	public function testGetValidCommentByCommentContent() {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Try to grab the comment in mySQL by its content
		$comments = Comment::getCommentByCommentContent($this->getPDO(), $comment->getCommentText());
		$this->assertEquals($numRows+1, $this->getConnection()->getRowCount("comment"));
		$this->assertCount(1, $comments);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Jpegery\\Comment", $comments);

		//grab the result from the array and validate it (Could hold multiple comments)
		$pdoComment = $comments[0];
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentText(), $this->VALID_COMMENTTEXT);
	}

	/**
	 * Test grabbing a Comment by content that does not exist.
	 **/
	public function testGetInvalidCommentByCommentContent() {
		//Search for content we know does not exist
		$comment = Comment::getCommentByCommentContent($this->getPDO(), $this->INVALID_COMMENTTEXT);
		$this->assertCount(0, $comment);
	}

	public function testInsertValidCommentAtCurrentTime() {
		//Count the number of rows for future use
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), null, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
		/*
		 * ...How do I even test this?
		 * I mean, seriously, how do I confirm that the new DateTime value is equivalent to the time it was created?
		 *Maybe I should check to see if there's now a \DateTime object rather than a null value?
		 */
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInsertInvalidCommentByInvalidArgumentOfTime() {
		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), "Hello I am a string", $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}

//	/**
//	 * @expectedException \RangeException
//	 */
//	public function testInsertInvalidCommentByOutOfRangeTime() {
//		//Create a new Comment and insert it into mySQL
//		$comment = new Comment(null, $this->image->getImageId(), \DateTime::ATOM, $this->VALID_COMMENTTEXT);
//		$comment->insert($this->getPDO());
//	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInsertInvalidCommentByEmptyText() {
		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, "");
		$comment->insert($this->getPDO());
	}

	/**
	 * @expectedException \RangeException
	 */
	public function testInsertInvalidCommentByTooMuchText() {
		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->INVALID_TEXTLENGTH);
		$comment->insert($this->getPDO());
	}

	/**
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidCommentByNegativeId() {
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $this->NEGATIVE_ID);
	}

	/**
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidCommentByNegativeImageId() {
		$comments = Comment::getCommentByImageId($this->getPDO(), $this->NEGATIVE_ID);
	}

	/**
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidCommentByNegativeProfileId() {
		$comments = Comment::getCommentByProfileId($this->getPDO(), $this->NEGATIVE_ID);
	}

	/**
	 * @expectedException \PDOException
	 **/
	public function testGetInvalidCommentByEmptyComment() {
		$comments = Comment::getCommentByCommentContent($this->getPDO(), "");
	}
}