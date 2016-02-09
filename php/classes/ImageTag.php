<?php

namespace Edu\Cnm\Jpegery;

require_once("autoload.php");

/**
 * tag attached to a given image
 *
 * This is a hashtag of the poster's choice that helps viewing users
 * to sort the image among other posts
 *
 * @authors David Mancini, Jacob Findley, Michael Kemm, Zach Leyba
 * @version 1.0
 */

class ImageTag implements \JsonSerializable {

	/**
	 * id# of the Image that this tag is attached to
	 *
	 * @var int $imageId
	 **/

	private $imageId;

	/**
	 * id# of the actual tag attached to the image; this is a component of a composite primary key (and a foreign key)
	 *
	 * @var int $tagId
	 */

	private $tagId;

	/**
	 * constructor for this imageTag; this is a component of a composite primary key (and a foreign key)
	 *
	 * @param int $newImageId id of the parent image
	 * @param int $newTagId id of the parent tag
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/

	public function __construct(int $newImageId = null, int $newTagId) {

		try {
			$this->setImageId($newImageId);
			$this->setTagId($newTagId);
		} catch(\InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			//rethrow the exception
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			//rethrow the exception
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	* accessor method for imageId
	 * @return int value of image id
	 * */

	public function getImageId() {
		return $this->imageId;
	}

	/**
	 * mutator method for imageId
	 * @param int $newImageId
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not an integer
	 */

	public function setImageId(int $newImageId) {
		//verify the image id is positive
		if($newImageId <= 0)  {
			throw(new \RangeException("Image Id is not positive"));
		}
		//convert and store the image id
		$this->imageId = $newImageId;
	}

	/**
	 * accessor method for tagId
	 *
	 * @return int value of tagId
	 **/

	public function getTagId() {
		return $this->tagId;
	}

	/**
	 * mutator method for tag ID
	 * @param int $newTagid new value of tag id
	 * @throws \RangeException if $newTagId is not positive
	 * @throws \TypeError if $newTagId is not an integer
	 */
	public function setTagId(int $tagId) {
		$this->tagId = $tagId;
		//verify the tag id is positive
		if($newTagId <= 0) {
			throw(new \RangeException("tag id is not positive"));

			//convert and store the tag id
			$this->tagId = $newTagId;
		}
	}



/**
 * Inserts this Tag into mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related error occurs
 * @throws \ TypeError if $pdo is not a PDO connection object
 *
 **/

public function insert(\PDO $pdo) {
	//enforce the ImageTag is not null (i.e. don't insert a tag that does not exist)
	if($this->imageId === null || $this->tagId === null) {
		throw(new \PDOException("not an existing tag"));
	}

	//create query template
	$query = "INSERT INTO imageTag(imageId, tagId
				VALUES(:imageId, :tagId))";
	$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
	$parameters = ["imageId" => $this->imageId, "tagId" => $this->tagId];
	$statement->execute($parameters);

	//update the null tagId with the value MySQL gives us
	$this->tagId = intval($pdo - lastInsertId());

	}

/**
 *
 **Deletes tag from mySQL
 *
 * @param \PDO $pdo connection object
 * @throws \PDOException when mySQL related errors occur
 * @thows \TypeError if $pdo is not a PDO connection object
 *
 **/

public function delete(\PDO $pdo) {
	//enforce tagId and tagName are not null
	if($this->imageId === null || $this->tagId === null) {
		throw(new \PDOException("not an existing tag"));
	}
		// create query template
	$query = "DELETE FROM imageTag WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);


		//bind the member variables to the place holders in the template
		$parameters = ["imageId" => $this->imageId, "tagId" => $this->tagId];
		$statement->execute($parameters);


	}

public function update(\PDO $pdo) {
	//enforce tagId and tagName are not null
	if($this->imageId === null || $this->tagId === null) {
		throw(new \PDOException("not an existing tag"));
	}
	// create query template
	$query = "UPDATE imageTag SET tagName :tagName,
 		WHERE tagId = :tagId";


		//bind the member variables to the place holders in the template
		$parameters = ["imageId" => $this->imageId, "tagId" => $this->tagId];
		$statement->execute($parameters);



	}

	/**
	 * gets imageTag by tagId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $tagId to search for
	 * @return Tag|null Tag found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throw \TypeError when variables are not the correct data type
	 * **/

	public static function getImageTagByTagId(\PDO $pdo, int $tagId) {
		//sanitize the tagId before searching
		if($tagId <= 0) {
			throw(new \PDOException("tag id is not positive"));
		}

		//create query template
		$query = "SELECT tagId, imageId FROM ImageTag WHERE tagId = :tagId";
		$statement = $pdo->prepare($query);

		//bind the tag id to the place holder in the template
		$parameters = array("tagId" => $tagId);
		$statement->execute($parameters);

		// grab the image tag from mySQL
		try {
			$imageTag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$imageTag = new ImageTag($row[$tagId], $row[$imageId]);
			}
		catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($imageTag)
		}

	}

	/**
	 * gets imageTag by imageId
	 *
	 * @param \PDO $pdo connection object
	 * @param int $tagId to search for
	 * @return Tag|null Tag found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throw \TypeError when variables are not the correct data type
	 * **/

	public static function getImageTagByTagId(\PDO $pdo, int $imageId) {
		//sanitize the tagId before searching
		if($imageId <= 0) {
			throw(new \PDOException("image id is not positive"));
		}

		//create query template
		$query = "SELECT imageId, tagId FROM ImageTag WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		//bind the tag id to the place holder in the template
		$parameters = array("imageId" => $imageId);
		$statement->execute($parameters);

		// grab the image tag from mySQL
		try {
			$imageTag = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$imageTag = new ImageTag($row[$imageId], $row[$tagId]);
			}
		catch
			(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($imageTag)
		}

	}




/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
	return($fields);
}


}