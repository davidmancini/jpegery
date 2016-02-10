<?php
/**
 * Created by PhpStorm.
 * User: zleyba
 * Date: 1/28/16
 * Time: 1:38 PM
 */

namespace Edu\Cnm\Jpegery;
require_once("autoload.php");

/**
 * Class Comment
 *
 * A comment on an image
 * @author David Mancini <hello@davidmancini.xyz>
 * @author Jacob Findley <jfindley2@cnm.edu>
 * @author Michael Kemm
 * @author Zach Leyba
 */
class Comment implements \JsonSerializable {

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
	 * the date the comment was posted
	 * @var \DateTime $commentDate
	 */
	private $commentDate;

	/**
	 * the text of the comment
	 * @var string $commentText
	 */
	private $commentText;



	/**
	 * Comment constructor.
	 *
	 * @param int|null $newCommentId, private key
	 * @param int $newCommentImageId, foreign key
	 * @param int $newCommentProfileId, foreign key
	 * @param string $newCommentText
	 * @param \DateTime|string|null $newCommentDate date and time comment was posted, or current time if null
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newCommentId = null, int $newCommentImageId, int $newCommentProfileId, \DateTime $newCommentDate = null,  string $newCommentText) {
		try {
			$this->setCommentId($newCommentId);
			$this->setCommentImageId($newCommentImageId);
			$this->setCommentProfileId($newCommentProfileId);
			$this->setCommentDate($newCommentDate);
			$this->setCommentText($newCommentText);
		}
		//Rethrow the exception to the caller
		catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

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
	 * accessor method for comment date
	 *
	 * @return \DateTime value of comment date
	 */
	public function getCommentDate() {
		return $this->commentDate;
	}

	/**
	 * mutator method for comment date
	 *
	 * @param null $newCommentDate
	 * @throws \InvalidArgumentException if $newCommentDate is not a valid object or string
	 * @throws \RangeException if $newCommentDate is a date that cannot exist
	 */
	public function setCommentDate($newCommentDate = null) {
		//base case: if $newCommentDate is null, use current date and time
		if($newCommentDate === null) {
			$this->commentDate = new \DateTime();
			return;
		}
		//store the comment date
		try {
			$newCommentDate = $this->validateDate($newCommentDate);
		} catch (\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch (\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->commentDate = $newCommentDate;
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
	 * @throws \RangeException if $newCommentText is more than 1023 characters
	 * @throws \TypeError if $newCommentText is not a string
	 */
	public function setCommentText(string $newCommentText) {
		//verify the comment text is secure
		$newCommentText = trim($newCommentText);
		$newCommentText = filter_var($newCommentText, FILTER_SANITIZE_STRING);
		if(empty($newCommentText) === true) {
			throw(new \InvalidArgumentException("comment content is empty or insecure"));
		}
		if(strlen($newCommentText>1023)) {
			throw(new \RangeException("Your comment is too long."));
		}
		$this->commentText = $newCommentText;
	}



	/**
	 * inserts this comment into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo) {
		//Enforce that the comment id is null
		if($this->commentId !== null) {
			throw(new \PDOException("Not a new comment"));
		}

		//Create a query template
		$query = "INSERT INTO comment(commentImageId, commentProfileId, commentDate, commentText) VALUES(:commentImageId, :commentProfileId, :commentDate, :commentText)";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the placeholder in the template
		$formattedDate = $this->commentDate->format("Y-m-d H:i:s");
		$parameters = ["commentImageId" => $this->commentImageId, "commentProfileId" => $this->commentProfileId, "commentDate" => $formattedDate, "commentText" => $this->commentText];
		$statement->execute($parameters);
		//Update comment id to the newest available id
		$this->commentId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this comment in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		//Enforce that comment id is not null
		if($this->commentId === null) {
			throw(new \PDOException("Cannot delete a comment that does not exist"));
		}

		//Create a query template
		$query = "DELETE FROM comment WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the placeholder in the template
		$parameters = ["commentId" => $this->commentId];
		$statement->execute($parameters);
	}

	/**
	 * Updates this comment in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) {
		//Enforce that comment id is not null
		if($this->commentId === null) {
			throw(new \PDOException("Cannot update a comment that does not exist"));
		}

		//Create a query template
		$query = "UPDATE comment SET commentImageId = :commentImageId, commentProfileId = :commentProfileId, commentDate = :commentDate, commentText = :commentText WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the place holders in this template
		$formattedDate = $this->commentDate->format("Y-m-d H:i:s");
		$parameters = ["commentImageId" => $this->commentImageId, "commentProfileId" => $this->commentProfileId, "commentDate" => $formattedDate, "commentText" => $this->commentText, "commentId" => $this->commentId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Comment by comment id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $commentId id of the comment we're searching for
	 * @return Comment|null Comment found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCommentByCommentId(\PDO $pdo, int $commentId) {
		//Sanitize the comment id before seaching
		if($commentId <= 0) {
			throw(new \PDOException("Comment id is not positive"));
		}

		//Create query template
		$query = "SELECT commentId, commentImageId, commentProfileId, commentDate, commentText FROM comment WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);

		//Bind the comment id to the place holder in the template
		$parameters = ["commentId" => $commentId];
		$statement->execute($parameters);

		//Grab the comment from mySQL
		try {
			$comment = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$comment = new Comment($row["commentId"], $row["commentImageId"], $row["commentProfileId"], $row["commentDate"], $row["commentText"]);
			}
		} catch(\Exception $exception) {
			//If the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($comment);
	}

	/**
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageId id of the image on which the comment is posted
	 * @return \SplFixedArray SplFixedArray of Comments found
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCommentByImageId(\PDO $pdo, int $imageId) {
		//Sanitize the image id before searching
		if($imageId <= 0) {
			throw(new \PDOException("Get Comment by Image: Image Id is not valid"));
		}
		//Create a query template
		$query = "SELECT commentId, commentImageId, commentProfileId, commentDate, commentText FROM comment WHERE commentImageId = :commentImageId";
		$statement = $pdo->prepare($query);
		//Search for the image given
		$parameters = ["commentImageId" => $imageId];
		$statement->execute($parameters);

		//Build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentImageId"], $row["commentProfileId"], $row["commentDate"], $row["commentText"]);
				$comments[$comments->key()] = $comment;
				$comments->next();
			} catch (\Exception $exception) {
				//If the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($comments);
	}

	/**
	 * gets the Comment by the profile that posted it
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId the user whose comments we are searching for
	 * @return \SplFixedArray SplFixedArray of Comments found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not of the correct data type
	 */
	public static function getCommentByProfileId(\PDO $pdo, int $profileId) {
		//Sanitize the profile id before searching
		if($profileId <= 0) {
			throw(new \PDOException("Get Comment by Profile: Profile Id is not valid"));
		}
		//Create a query template
		$query = "SELECT commentId, commentImageId, commentProfileId, commentDate, commentText FROM comment WHERE commentProfileId = :commentProfileId";
		$statement = $pdo->prepare($query);
		//Search for the profile given
		$parameters = ["commentProfileId" => $profileId];
		$statement->execute($parameters);

		//Build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentImageId"], $row["commentProfileId"], $row["commentDate"], $row["commentText"]);
				$comments[$comments->key()] = $comment;
				$comments->next();
			} catch (\Exception $exception) {
				//If the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($comments);
	}

	/**
	 * gets Comments by content--Search for content
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentContent comment content to search for
	 * @return \SplFixedArray SplFixedArray of Comments found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCommentByCommentContent(\PDO $pdo, string $commentContent) {
		//Purge the string
		$commentContent = trim($commentContent);
		$commentContent = filter_var($commentContent, FILTER_SANITIZE_STRING);
		if(empty($commentContent) === true) {
			throw(new \PDOException("Get Comment by Content: Comment content is invalid"));
		}

		//Create a query template
		$query = "SELECT commentId, commentImageId, commentProfileId, commentDate, commentText FROM comment WHERE commentContent LIKE :commentContent";
		$statement = $pdo->prepare($query);

		//Search for the text given
		$commentContent = "%$commentContent%";
		$parameters = ["commentContent" => $commentContent];
		$statement->execute($parameters);

		//Build an array of comments
		$comments = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentImageId"], $row["commentProfileId"], $row["commentDate"], $row["commentText"]);
				$comments[$comments->key()] = $comment;
				$comments->next();
			} catch (\Exception $exception) {
				//If the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($comments);
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["commentDate"] = intval($this->commentDate->format("U")) * 1000;
		return($fields);
	}
}