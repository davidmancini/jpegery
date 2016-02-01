<?php
/**
 * Tag is the hashtag that can be assigned to an image
 *
 * Tags are the primary method of sorting out pictures for users.
 * Users can search tags and assign them to their own images
 * so that other users may find them. Tags will also be used
 * to rank the popularity of a given image.
 *
 * @authors David Mancini, Jacob Findley, Michael Kemm, Zach Leyba
 *

 **/

class Tag {
	/**ID# of a given tag
	 * @var int $tagId
	 */

	private $tagId;

	/** Name of the tag
	 * @var string $tagName
	 **/

	private $tagName;

	/**
	 * constructor for this item
	 *
	 * @param int $newTagId id of this Tag or null if a new Tag
	 * @param string $newTagName name of a given tag
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct(int $newTagId, string $newTagName) {

		try {
			$this->setTagId($newTagId);
			$this->setTagName($newTagName);
		}
			catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
			catch(RangeException $range) {
				// rethrow the exception to the caller
				throw(new RangeException($range->getMessage(), 0, $range));
			}
			catch(Exception $exception) {
				// rethrow generic exception
				throw(new Exception($exception->getMessage(), 0, $exception));
			}

	}
}

/** accessor method for Tag ID
 *
 *@return int value of tag id
 **/

public function getTagId() {
		return($this->tagId);
}

/**
 * mutator method for tag id
 *
 * @param string $newTagId new value of tag id
 * @throws \RangeException if $newTagId is not positive
 * @throws \TypeError if $newTagId is not an integer
 **/
public function setTagId(int $newTagId) {
	// verify the tag id is positive
	if($newTagId <= 0) {
		throw(new \RangeException("tag id is not positive"));
	}

	// convert and store the tag id
	$this->tagId = $newTagId;
}

/** accessor method for tag name
 *
 *@return string value of tag name
 **/

public function getTagName() {
	return($this->tagName);
}

/**
 * mutator method for tag name
 *
 * @param string $newTagName new value of tag name
 * @throws InvalidArgumentException if $newTag is not a string or insecure
 * @throws RangeException if $newTag is > 64vcharacters
 **/
public function setTagName(int $newTagName) {
	// verify the tag is secure
	$newTagName = trim($newTagName);
	$newTagName = filter_var($newTagName, FILTER_SANITIZE_STRING);
	if(empty($newTagName) === true) {
		throw(new InvalidArgumentException("Tag empty or insecure"));
	}

	// verify the email address will fit in the database
	if(strlen($newTagName) > 64) {
		throw(new RangeException("Tag too long"));
	}

	// store the email
	$this->tagName = $newTagName;
}

/**
 * inserts this Tag into mySQL
 * @param PDO $pdo PDO Connection object
 * @throws PDOException when mySQL related errors occur
 */

public function insert(PDO $pdo) {
	//enformce the tagId is null (i.e. don't insert a tag that already exists)
	if($this->tagId !=== null) {
		throw(new PDOException ("not a new Tag"));
	}

	//create query template
	$query = "INSERT INTO tag(tagId, tagName
				VALUES(:tagId, :tagName))";
				$statement = $pdo->prepare($query);

	//update the null tagId with what mySQL just gave us
	$this->tagId = intval($pdo->lastInsertId());



}

/**
 * deletes this tag from mySQL
 *
 * @param PDO $pdo PDO connection object
 * @throws PDOException when mySQL related errors occur
 **/
public function delete(PDO $pdo) {
	// enforce the tagId is not null (i.e., don't delete a tag that hasn't been inserted)
	if($this->tagId === null) {
		throw(new PDOException("unable to delete a tag that does not exist"));
	}

	// create query template
	$query	 = "DELETE FROM tag WHERE tagId = :tagId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holder in the template
	$parameters = array("tagId" => $this->tagId);
	$statement->execute($parameters);
}

/**
 * updates this tag in mySQL
 *
 * @param PDO $pdo PDO connection object
 * @throws PDOException when mySQL related errors occur
 **/
public function update(PDO $pdo) {
	// enforce the tagId is not null (i.e., don't update an tag that hasn't been inserted)
	if($this->tagId === null) {
		throw(new PDOException("unable to update a tag that does not exist"));
	}

	// create query template
	$query	 = "UPDATE tag SET tagName :tagName,
 		WHERE tagId = :tagId";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template
	$parameters = array("tagId" => $this->tagId, "tagName" => $this->tagName,
	$statement->execute($parameters);
}



}