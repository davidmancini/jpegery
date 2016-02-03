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
		$this->profile->insert($this->getPDO());

		//TODO: Finish this.
		$this->image = new Image(null, $this->profile->getProfileId());
		//Calculate the date
		$this->VALID_COMMENTDATE = new \DateTime();
	}

	/**
	 * Test inserting a valid Comment and verify that the mySQL data matches
	 *
	 */
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
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTTEXT);
	}

	/**
	 * Test inserting a comment that already exists
	 */
	public function testInsertInvalidComment() {
		//Create a comment with a non null id and watch it fail
		$comment = new Comment(JpegeryTest::INVALID_KEY, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());
	}

	/**
	 * Test inserting a comment, editing it, and then updating it.
	 */
	public function testUpdateValidTweet() {
		//Count the number of rows for later
		$numRows = $this->getConnection()->getRowCount("comment");

		//Create a new Comment and insert it into mySQL
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->insert($this->getPDO());

		//Edit the Comment and update it in mySQL
		$comment->setCommentContent($this->VALID_COMMENTTEXT2);
		$comment->update($this->getPDO());

		//Grab the data from mySQL and check it against our expectations
		$pdoComment = Comment::getCommentByCommentId($this->getPDO(), $comment->getCommentId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("comment"));
		$this->assertEquals($pdoComment->getCommentImageId(), $this->image->getImageId());
		$this->assertEquals($pdoComment->getCommentProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoComment->getCommentDate(), $this->VALID_COMMENTDATE);
		$this->assertEquals($pdoComment->getCommentContent(), $this->VALID_COMMENTTEXT2);
	}

	/**
	 * Test updating a Comment that already exists
	 *
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidComment() {
		//Test updating a comment without inserting it
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->update($this->getPDO());
	}

	/**
	 * Test creating and deleting a comment.
	 */
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
	 */
	public function testDeleteInvalidComment() {
		//Create a comment and delete it without actually inserting it.
		$comment = new Comment(null, $this->image->getImageId(), $this->profile->getProfileId(), $this->VALID_COMMENTDATE, $this->VALID_COMMENTTEXT);
		$comment->delete($this->getPDO());
	}
	public function testGetValidCommentByCommentId() {

	}
}