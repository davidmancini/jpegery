<?php

namespace Edu\Cnm\Jpegery;
require_once ("autoload.php"); //Required for validation of imageDate

/**
 * Image
 *
 * The Image entity includes all information about the image itself (image type, file name, and text)
 * and also includes the associated owner of the image (profileId)
 *
 * @author David Mancini <hello@davidmancini.xyz>
 **/
class Image implements \JsonSerializable {
	use ValidateDate;

	/**
	 * imageId is the primary key
	 * @var int $imageId
	 **/
	private $imageId;

	/**
	 * imageProfileId is a foreign key to associate the image's owner
	 * @var int $imageProfileId
	 **/
	private $imageProfileId;

	/**
	 * imageDate is the date the image was posted
	 *
	 * @var \DateTime $imageDate
	 **/
	private $imageDate;

	/**
	 * imageFileName is the unique file name of the image
	 * @var string $imageFileName
	 **/
	private $imageFileName;

	/**
	 * imageText is the user's text (comment/caption) associated with the image
	 * @var string $imageText
	 **/
	private $imageText;

	/**
	 * imageType is the file type of the image
	 * @var string $imageType
	 **/
	private $imageType;

	/**
	 * Constructor for Image
	 *
	 * @param mixed $newImageId of the image or null if new image
	 * @param int $newProfileId foreign key from Profile
	 * @param string $newImageType string containing image type
	 * @param string $newImageFileName string containing the file name of the image
	 * @param string $newImageText string containing the text associated with the image
	 * @throws RangeException if data values are out of bounds (strings are too long, negative numbers)
	 * @throws Exception if other exception is thrown
	 **/
	public function __construct(int $newImageId = null, int $newProfileId, string $newImageType, string $newImageFileName, string $newImageText, $newImageDate = null) {
		try {
			$this->setImageId($newImageId);
			$this->setImageProfileId($newProfileId);
			$this->setImageType($newImageType);
			$this->setImageFileName($newImageFileName);
			$this->setImageText($newImageText);
			$this->setImageDate($newImageDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Accessor method for image id
	 * @return int value of image id
	 **/
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * Mutator method for image id
	 * @param int $newImageId of new image
	 * @throws InvalidArgumentException if image id is not an integer
	 * @throws RangeException if image id is negative
	 **/
	public function setImageId($newImageId) {
		//If empty image id, allow MySQL to auto-increment
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}

		//Filter
		$newImageId = filter_var($newImageId, FILTER_VALIDATE_INT);

		//The below could be type hinted
		//Exception if not int
		if($newImageId === false) {
			throw(new \InvalidArgumentException("image id is not an integer"));
		}

		//Exception if negative
		if($newImageId <= 0) {
			throw(new \RangeException("image id must be positive"));
		}

		//Save the object
		$this->imageId = $newImageId;
	}

	/**
	 * Accessor method for imageProfileId
	 * @return int value of imageProfileId
	 **/
	public function getImageProfileId() {
		return ($this->imageProfileId);
	}

	/**
	 * Mutator method for imageProfileId
	 * @param int $newImageProfileId of new profileId
	 * @throws InvalidArgumentException if profile id is not an integer
	 * @throws RangeException if profile id is negative
	 **/
	public function setImageProfileId($newImageProfileId) {
		//Filter
		$newImageProfileId = filter_var($newImageProfileId, FILTER_VALIDATE_INT);

		//Exception if not int
		if($newImageProfileId === false) {
			throw(new \InvalidArgumentException("imageProfileId is not an integer"));
		}

		//Exception if negative
		if($newImageProfileId <= 0) {
			throw(new \RangeException("imageProfileId must be positive"));
		}

		//Save the object
		$this->imageProfileId = $newImageProfileId;
	}

	/**
	 * Accessor for imageDate
	 * @return datetime value for the image's date
	 **/
	public function getImageDate() {
		return ($this->imageDate);
	}

	/**
	 * Mutator method for imageDate
	 * @param datetime $newImageDate string for newImageDate or null to load current time
	 * @throws InvalidArgumentException if $newImageDate is not a valid object or string
	 * @throws RangeException if $newImageDate is a date that does not exist
	 **/
	public function setImageDate($newImageDate = null) {
		//If date is null, set current time and date
		if($newImageDate === null) {
			$this->imageDate = new \DateTime();
			return;
		}

		//Catch exceptions and display correct error (refers to validate-date.php) and if no exceptions, safe the new time and date
		try {
			$newImageDate = validateDate::validateDate($newImageDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw (new \RangeException($range->getMessage(), 0, $range));
		} catch(\Exception $exception) {
			throw (new \Exception($exception->getMessage(), 0, $exception));
		}
		$this->imageDate = $newImageDate;
	}

	/**
	 * Accessor method for imageFileName
	 * @return string of imageFileName
	 **/
	public function getImageFileName() {
		return ($this->imageFileName);
	}

	/**
	 * Mutator method for imageFileName
	 * @param string $newimageFileName string for newImageFileName
	 * @throws InvalidArgumentException if type is only non-sanitized values
	 * @throws RangeException if image file name will not fit in database
	 **/
	public function setImageFileName($newImageFileName) {
		//Sanitize
		$newImageFileName = filter_var($newImageFileName, FILTER_SANITIZE_STRING);

		//Exception if only non-standardized values (and is now empty)
		if($newImageFileName === false) {
			throw(new \InvalidArgumentException("image file name is not a valid string"));
		}

		//Exception if input will not fit in the database
		if(strlen($newImageFileName) > 128) {
			throw(new \RangeException("image file name is too large"));
		}

		//Save the input
		$this->imageFileName = $newImageFileName;
	}

	/**
	 * Accessor method for imageText
	 * @return string for an image's text
	 **/
	public function getImageText() {
		return ($this->imageText);
	}

	/**
	 * Mutator method for imageText
	 * @param string $newImageText string for new image's text
	 * @throws InvalidArgumentException if type is only non-sanitized values
	 * @throws RangeException if image's text will not fit in database
	 **/
	public function setImageText($newImageText) {
		//Sanitize
		$newImageText = filter_var($newImageText, FILTER_SANITIZE_STRING);

		//Exception if only non-standardized values (and is now empty)
		if($newImageText === false) {
			throw(new \InvalidArgumentException("image text is not a valid string"));
		}

		//Exception if input will not fit in the database
		if(strlen($newImageText) >= 500) {
			throw(new \RangeException("image text is too large"));
		}

		//Save the input
		$this->imageText = $newImageText;
	}

	/**
	 * Accessor method for imageType
	 * @return string of image type
	 **/
	public function getImageType() {
		return ($this->imageType);
	}

	/**
	 * Mutator method for imageType
	 * @param string $newImageType string for image type
	 * @throws InvalidArgumentException if type is only non-sanitized values
	 * @throws RangeException if image type will not fit in database
	 **/
	public function setImageType($newImageType) {
		//Sanitize
		$newImageType = filter_var($newImageType, FILTER_SANITIZE_STRING);

		//Exception if only non-sanitized values (and is now empty)
		if($newImageType === false) {
			throw(new \InvalidArgumentException("image type is not a valid string"));
		}

		//Exception if input will not fit in the database
		if(strlen($newImageType) > 128) {
			throw(new \RangeException("image type is too large"));
		}

		//Save the input
		$this->imageType = $newImageType;
	}

	/**
	 * Inserts image into database
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL-related error occurs
	 **/
	public function insert(\PDO $pdo) {
		//Only inserts if new image id
		if($this->imageId !== null) {
			throw(new \PDOException("not a new image id"));
		}
		//Creates query
		$query = "INSERT INTO image(imageProfileId, imageType, imageFileName, imageText, imageDate) VALUES (:imageProfileId, :imageType, :imageFileName, :imageText, :imageDate)";
		$statement = $pdo->prepare($query);

		//Binds variables to placeholders
		$formattedDate = $this->imageDate->format("Y-m-d H:i:s");
		$parameters = array("imageProfileId" => $this->imageProfileId, "imageType" => $this->imageType, "imageFileName" => $this->imageFileName, "imageText" => $this->imageText, "imageDate" => $formattedDate);
		$statement->execute($parameters);

		//Updates null image id with the auto-incremented value just created
		$this->imageId = intval($pdo->lastInsertId());
	}

	/**
	 * Updates image in database
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when MySQL-related error occurs
	 **/
	public function update(\PDO $pdo) {
		//Only updates if not new id
		if($this->imageId === null) {
			throw(new \PDOException("unable to update, image id does not exist"));
		}

		//Create query template
		$query = "UPDATE image SET imageProfileId = :imageProfileId, imageType = :imageType, imageFileName = :imageFileName, imageText = :imageText, imageDate = :imageDate WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		//Binds variables to placeholders
		$formattedDate = $this->imageDate->format("Y-m-d H:i:s");
		$parameters = array("imageProfileId" => $this->imageProfileId, "imageType" => $this->imageType, "imageFileName" => $this->imageFileName, "imageText" => $this->imageText, "imageId" => $this->imageId, "imageDate" => $formattedDate);
		$statement->execute($parameters);
	}

	/**
	 * Delete image in database
	 * @param \PDO $pdo PDO connection object
	 * @throws PDOException when MySQL-related error occurs
	 **/
	public function delete(\PDO $pdo) {
		//Only deletes if image id exists
		if($this->imageId === null) {
			throw(new \PDOException("Unable to delete, image id does not exist."));
		}

		//Create query
		$query = "DELETE FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		//Binds variables to placeholders
		$parameters = array("imageId" => $this->imageId);
		$statement->execute($parameters);
	}

	/**
	 * Gets image by imageId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageId id to search for
	 * @return Image or null if not found
	 * @throws PDOException when MySQL-related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByImageId(\PDO $pdo, int $imageId) {
		//Sanitize
		if($imageId <= 0) {
			throw(new \PDOException("image id must be positive"));
		}

		//Create query
		$query = "SELECT imageId, imageProfileId, imageType, imageFileName, imageText, imageDate FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);

		//Binds
		$parameters = array("imageId" => $imageId);
		$statement->execute($parameters);

		//grab image from MySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageProfileId"], $row["imageType"], $row["imageFileName"], $row["imageText"], $row["imageDate"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($image);
	}

	/**
	 * Gets image by image profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageProfileId id to search for
	 * @return Image or null if not found
	 * @throws PDOException when MySQL-related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByImageProfileId(\PDO $pdo, int $imageProfileId) {
		//Sanitize
		if($imageProfileId <= 0) {
			throw(new \PDOException("image profile id must be positive"));
		}

		//Create query
		$query = "SELECT imageId, imageProfileId, imageType, imageFileName, imageText, imageDate FROM image WHERE imageProfileId = :imageProfileId";
		$statement = $pdo->prepare($query);

		//Binds
		$parameters = array("imageProfileId" => $imageProfileId);
		$statement->execute($parameters);

		//grab image from MySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageProfileId"], $row["imageType"], $row["imageFileName"], $row["imageText"], $row["imageDate"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($image);
	}

	/**
	 * Gets image by image file name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $imageFileName string to search for
	 * @return Image or null if not found
	 * @throws \PDOException when MySQL-related error occurs
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByImageFileName(\PDO $pdo, string $imageFileName) {
		//Sanitize
		$imageFileName = trim($imageFileName);
		$imageFileName = filter_var($imageFileName, FILTER_SANITIZE_STRING);
		if(empty($imageFileName) === true) {
			throw(new \PDOException("image file name is invalid"));
		}

		//Create query
		$query = "SELECT imageId, imageProfileId, imageType, imageFileName, imageText, imageDate FROM image WHERE imageFileName = :imageFileName";
		$statement = $pdo->prepare($query);

		//Binds
		$parameters = array("imageFileName" => $imageFileName);
		$statement->execute($parameters);

		//Grabs image from MySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imageProfileId"], $row["imageType"], $row["imageFileName"], $row["imageText"], $row["imageDate"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($image);
	}

	/**
 * Gets image by image text
 *
 * @param \PDO $pdo PDO connection object
 * @param string $imageText string to search for
 * @return \SplFixedArray SplFixedArray of images or null if not found
 * @throws PDOException when MySQL-related error occurs
 * @throws \TypeError when variables are not the correct data type
 **/
	public static function getImageByImageText(\PDO $pdo, string $imageText) {
		//Sanitize
		$imageText = trim($imageText);
		$imageText = filter_var($imageText, FILTER_SANITIZE_STRING);
		if(empty($imageText) === true) {
			throw(new \PDOException("image text is invalid"));
		}

		//Create query
		$query = "SELECT imageId, imageProfileId, imageType, imageFileName, imageText, imageDate FROM image WHERE imageText LIKE :imageText";
		$statement = $pdo->prepare($query);

		//Binds
		$imageText = "%$imageText%";
		$parameters = array("imageText" => $imageText);
		$statement->execute($parameters);

		//Builds array from MySQL
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new Image ($row["imageId"], $row["imageProfileId"], $row["imageType"], $row["imageFileName"], $row["imageText"], $row["imageDate"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				//If the row couldn't be converted, rethrow
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($images);
	}

	/**
	 * Gets all Images
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of images found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllImages(\PDO $pdo) {
		//Query
		$query = "SELECT imageId, imageProfileId, imageType, imageFileName, imageText, imageDate FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//Build array
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new Image ($row["imageId"], $row["imageProfileId"], $row["imageType"], $row["imageFileName"], $row["imageText"], $row["imageDate"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				//If the row couldn't be converted, rethrow
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($images);
	}

	/**
	 * Formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["imageDate"] = intval($this->imageDate->format("U")) * 1000;
		return($fields);
	}
}