<?php
/**
 * Created by PhpStorm.
 * User: zleyba
 * Date: 1/28/16
 * Time: 1:38 PM
 */

include_once("autoload.php");


class Comment implements JsonSerializable {
	/**
	 * id for comment, the primary key
	 * @var int $commentId
	 */
	private $commentId;

	/**
	 * id for image, foreign key
	 * @var int $commentImageId
	 */
	private $commentImageId;

	/**
	 * id for profile, foreign key
	 * @var int $commentProfileId
	 */
	private $commentProfileId;

	/**
	 * the text of the comment
	 * @var string $commentText
	 */
	private $commentText;

	/**
	 * the date the comment was posted
	 * @var \DateTime $commentDate
	 */
	//private $commentDate;

	/**
	 * accessor method for comment id
	 *
	 * @return int value of comment id
	 */
	public function getCommentId() {
		return $this->commentId;
	}

	/**
	 * mutator method for comment id
	 *
	 * @param int|null $newCommentId
	 * @throws \RangeException if $newCommentId is not positive
	 * @throws \TypeError if $newCommentId is not an int
	 */
	public function setCommentId(int $newCommentId = null) {
		//base case: If $newCommentId is null, this is a new comment
		if($newCommentId === null) {
			$this->commentId = null;
			return;
		}
		//verify the comment id is positive
		if ($newCommentId <= 0) {
			throw(new \RangeException("comment id is not positive"));
		}
		$this->commentId = $newCommentId;
	}

	/**
	 * accessor method for image id
	 * @return int value of image id
	 */
	public function getCommentImageId() {
		return $this->commentImageId;
	}

	/**
	 * mutator method for comment image id
	 *
	 * @param int $newCommentImageId
	 * @throws \RangeException if $newCommentImageId is not positive
	 * @throws \TypeError if $newCommentImageId is not an int
	 */
	public function setCommentImageId(int $newCommentImageId) {
		//Verify $newCommentImageId is positive
		if($newCommentImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}
		$this->commentImageId = $newCommentImageId;
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int value of profile id
	 */
	public function getCommentProfileId() {
		return $this->commentProfileId;
	}

	/**
	 * mutator method for comment profile id
	 *
	 * @param int $newCommentProfileId
	 * @throws \RangeException if $newCommentProfileId is not positive
	 * @throws \TypeError if $newCommentProfileId is not an int
	 */
	public function setCommentProfileId(int $newCommentProfileId) {
		//verify $newCommentProfileId is positive
		if($newCommentProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		$this->commentProfileId = $newCommentProfileId;
	}

	/**
	 * accessor method for comment text
	 *
	 * @return string value of comment text
	 */
	public function getCommentText() {
		return $this->commentText;
	}

	/**
	 * mutator method for $newCommentText
	 *
	 * @param string $newCommentText
	 * @throws \InvalidArgumentException if $newCommentText is empty or insecure
	 * @throws \TypeError if $newCommentText is not a string
	 */
	public function setCommentText(string $newCommentText) {
		//verify the comment text is secure
		$newCommentText = trim($newCommentText);
		$newCommentText = filter_var($newCommentText, FILTER_SANITIZE_STRING);
		if(empty($newCommentText) === true) {
			throw(new \InvalidArgumentException("comment content is empty or insecure"));
		}

		$this->commentText = $newCommentText;
	}

	/**
	 * accessor method for comment date
	 *
	 * @return \DateTime value of comment date
	 */
	/**public function getCommentDate() {
		return $this->commentDate;
	}

	public function setCommentDate($newCommentDate = null) {
		//base case: if $newCommentDate is null, use current date and time
		if($newCommentDate === null) {
			$this->commentDate = new \DateTime();
			return;
		}
		//store the comment date
		try {
			$newCommentDate;
		} catch (\InvalidArgumentException $invalidArgument) {

		}
		$this->commentDate = $newCommentDate;
	}
	 * */

	/**
	 * inserts this comment into mySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo) {
		//Enforce that the comment id is null
		if($this->commentId !== null) {
			throw(new \PDOException("Not a new comment"));
		}

		//Create a query template
		$query = "INSERT INTO comment(commentImageId, commentProfileId, commentText) VALUES(:commentImageId, :commentProfileId, :commentText)";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the place holder in the template
		$parameters = ["commentImageId" => $this->commentImageId, "commentProfileId" => $this->commentProfileId, "commentText" => $this->commentText];
		$statement->execute($parameters);
		//Update comment id to the newest available id
		$this->commentId = intval($pdo->lastInsertId());
	}

	public function jsonSerialize() {
		//TODO finish this
		return(null);

	}

}