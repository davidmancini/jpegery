<?php

namespace Edu\Cnm\Jpegery;

require_once("autoload.php");

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

class Tag implements \JsonSerializable {


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
	 * @param int|null $newTagId id of this Tag or null if a new Tag
	 * @param string $newTagName name of a given tag
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \Exception if some other exception is thrown
	 */

	public function __construct(int $newTagId = null, string $newTagName) {

		try {
			$this->setTagId($newTagId);
			$this->setTagName($newTagName);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\Exception $exception) {
			// rethrow generic exception
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}


	/***
	 * Accesor method for tag id
	 * @return int of tag id
	 *
	 ***/

	public function getTagId() {
		return ($this->tagId);
	}

	/**
	 * mutator method for tag id
	 *
	 * @param int|null $newTagId new value of tag id
	 * @throws \RangeException if $newTagId is not positive
	 * @throws \TypeError if $newTagId is not an integer
	 **/
	public function setTagId(int $newTagId = null) {
		//Base case--if tag id is null, this is a new profile without a mySQL assigned id
		if($newTagId === null) {
			$this->tagId = null;
			return;
		}
		// verify the tag id is positive
		if($newTagId <= 0) {
			throw(new \RangeException("tag id is not positive"));
		}

		//Filter integers
		$newTagId = filter_var($newTagId, FILTER_VALIDATE_INT);

		// convert and store the tag id
		$this->tagId = $newTagId;
	}

	/** accessor method for tag name
	 *
	 * @return string value of tag name
	 **/

	public function getTagName() {
		return ($this->tagName);
	}

	/**
	 * mutator method for tag name
	 *
	 * @param string $newTagName new value of tag name
	 * @throws \InvalidArgumentException if $newTag is not a string or insecure
	 * @throws \RangeException if $newTag is > 64characters
	 **/
	public function setTagName(string $newTagName) {
		// verify the tag is secure
		$newTagName = trim($newTagName);
		$newTagName = filter_var($newTagName, FILTER_SANITIZE_STRING);
		if(empty($newTagName) === true) {
			throw(new \InvalidArgumentException("Tag empty or insecure"));
		}

		// verify the email address will fit in the database
		if(strlen($newTagName) > 64) {
			throw(new \RangeException("Tag too long"));
		}

		// store the email
		$this->tagName = $newTagName;
	}

	/**
	 * inserts this Tag into mySQL
	 * @param \PDO $pdo PDO Connection object
	 * @throws \PDOException when mySQL related errors occur
	 */

	public function insert(\PDO $pdo) {
		//enformce the tagId is null (i.e. don't insert a tag that already exists)
		if($this->tagId !== null) {
			throw(new \PDOException ("not a new Tag"));
		}

		//create query template
		$query = "INSERT INTO tag(tagId, tagName)
				VALUES(:tagId, :tagName)";
		$statement = $pdo->prepare($query);

		//bind the variables to placeholder in the template
		$parameters = ["tagId" => $this->tagId, "tagName" => $this->tagName];
		$statement->execute($parameters);

		//update the null tagId with what mySQL just gave us
		$this->tagId = intval($pdo->lastInsertId());


	}

	/**
	 * deletes this tag from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function delete(\PDO $pdo) {
		// enforce the tagId is not null (i.e., don't delete a tag that hasn't been inserted)
		if($this->tagId === null) {
			throw(new \PDOException("unable to delete a tag that does not exist"));
		}

		// create query template
		$query = "DELETE FROM tag WHERE tagId = :tagId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("tagId" => $this->tagId);
		$statement->execute($parameters);
	}

	/**
	 * updates this tag in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo) {
		// enforce the tagId is not null (i.e., don't update an tag that hasn't been inserted)
		if($this->tagId === null) {
			throw(new \PDOException("unable to update a tag that does not exist"));
		}

		// create query template
		$query = "UPDATE tag SET tagName = :tagName
 		WHERE tagId = :tagId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("tagId" => $this->tagId, "tagName" => $this->tagName);
		$statement->execute($parameters);
	}

	/**
	 ** Gets Tag by tagId number
	 * @param \PDO $pdo PDO connection object
	 * @param int $tagId tag id to search for
	 * @return \ SplFixedArray SplFixedArray of tags found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are no the the correct data type
	 **/

	public static function getTagByTagId(\PDO $pdo, int $tagId) {
		//santitize description before searching
		if($tagId <= 0) {
			throw(new \PDOException("tag id is not positive"));
		}


		//create query template
		$query = "SELECT tagId, tagName FROM tag WHERE tagId = :tagId";

		$statement = $pdo->prepare($query);

		//bind the tag id to the place holder in the tempalte

		$parameters = array("tagId" => $tagId);
		$statement->execute($parameters);

		//grab the tag from mySQL

		try {

			$tag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$tag = new Tag($row["tagId"], $row["tagName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($tag);
	}


	/** Gets tag by name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $tagName tag name to search for
	 * @return \SplFixedArray SplFixedArray of tagged items found
	 * @throws \PDOException when mySQL related errors occur
	 * @throw \TypeError when
	 */
	public static function getTagByName(\PDO $PDO, string $tagName) {
		//sanitize query before searching
		$tagName = trim($tagName);
		$tagName = filter_var($tagName, FILTER_SANITIZE_STRING);
		if(empty($tagName) === true) {
			throw(new \PDOException("tag name is invalid"));

		}

		//create query template
		$query = "SELECT tagName, tagId FROM tag WHERE tagName LIKE :tagName";
		$statement = $PDO->prepare($query);

		//bind the tag name to the place holder in the template
		$tagName = "%tagName%";
		$parameters = array("tagName" => $tagName);
		$statement->execute($parameters);

//		//grabs tag from mySQL
//		try {
//			$tag = null;
//			$statement->setFetchMode(\PDO::FETCH_ASSOC);
//			$row = $statement->fetch();
//			if($row !== false) {
//				$tag = new Tag($row["tagId"], $row[$tagName]);
//			}
//		} catch(\Exception $exception) {
//			//if the row couldn't be converted, rethrow it
//			throw(new \PDOException($exception->getMessage(), 0, $exception));
//
//		}


		//build an array of tags by this name
		$tags = new\SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO:: FETCH_ASSOC);
		while($row = $statement->fetch() !== false) {
			try {
				$tag = new tag($row["tagId"], $row["tagName"]);
				$tags[$tags->key()] = $tag;
				$tags->next();


			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));

			}


			return ($tags);

		}
	}

	/**
	 * Gets all tags
	 *
	 * @param \PDOException
	 * @return \SplFixedArray SpleFixedArray of Tags found or null if not found
	 * @thorws \PDOException when mySQL related issues occur
	 * @throws \TypeError when varialbes are not the correct data type
	 *
	 */
	public static function getAllTags(\PDO $pdo) {
		//create query template
		$query = "SELECT tagId, tagName FROM tag";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of tags
		$tags = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$tag = new Tag($row["tagId"], $row["tagName"]);
				$tags[$tags->key()] = $tag;
				$tags->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return ($tags);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		return (get_object_vars($this));
	}

}