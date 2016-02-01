<?php

namespace Edu\Cnm\Jpegery;

/*
 * Image
 *
 * The Image entity includes all information about the image itself (image type, file name, and text)
 * and also includes the associated owner of the image (profileId)
 *
 * @author David Mancini <mancini.david@gmail.com>
 */

//!!  This needs to be changed to jpegery DB!
//Secure and Encrypted PDO Database Connection
//require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
//$pdo = connectToEncryptedMySQL("/etc/apache2/data-design/dmancini1.ini");

//LOCAL DEVELOPMENT Connection
$pdo = new PDO('mysql:host=localhost;dbname=dmancini1', 'dmancini1', 'password');

class Image {

	/*
	 * imageId is the primary key
	 * @var int $imageId
	 */
	private $imageId;

	/*
	 * imageProfileId is a foreign key to associate the image's owner
	 * @var int $imageProfileId
	 */
	private $imageProfileId;

	/*
	 * imageType is the file type of the image
	 * @var string $imageType
	 */
	private $imageType;

	/*
	 * imageFileName is the unique file name of the image
	 * @var string $imageFileName
	 */
	private $imageFileName;

	/*
	 * imageText is the user's text (comment/caption) associated with the image
	 * @var string $imageText
	 */
	private $imageText;



	/*
	 * Constructor for Image
	 *
	 * @param mixed $newImageId of the image or null if new image
	 * @param int $newProfileId foreign key from Profile
	 * @param string $newImageType string containing image type
	 * @param string $newImageFileName string containing the file name of the image
	 * @param string $newImageText string containing the text associated with the image
	 * @throws RangeException if data values are out of bounds (strings are too long, negative numbers)
	 * @throws Exception if other exception is thrown
	 */
	public function __construct($newImageId, $newProfileId, $newImageType, $newImageFileName, $newImageText) {
		try {
			$this->setImageId($newImageId);
			$this->setProfileId($newProfileId);
			$this->setImageType($newImageType);
			$this->setImageFileName($newImageFileName);
			$this->setImageText($newImageText);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/*
	 * Accessor method for image id
	 * @return int value of image id
	 */
	public function getImageId(){
		return ($this->imageId);
	}

	/*
	 * Mutator method for image id
	 * @param int $newImageId of new image
	 * @throws InvalidArgumentException if image id is not an integer
	 * @throws RangeException if image id is negative
	 */
	public function setImageId($newImageId) {
		//If empty image id, allow MySQL to auto-increment
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}

		//Filter
		$newImageId = filter_var($newImageId, FILTER_VALIDATE_INT);

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

	/*
	 * Accessor method for imageProfileId
	 * @return int value of imageProfileId
	 */
	public function getImageProfileId(){
		return($this->imageProfileId);
	}

	/*
	 * Mutator method for imageProfileId
	 * @param int $newImageProfileId of new profileId
	 * @throws InvalidArgumentException if profile id is not an integer
	 * @throws RangeException if profile id is negative
	 */
	public function setImageProfileId($newImageProfileId){
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

	/*
	 * Accessor method for imageType
	 * @return string of image type
	 */
	public function getImageType() {
		return ($this->imageType);
	}

	/*
	 * Mutator method for imageType
	 * @param string for image type
	 * @throws InvalidArgumentException if type is only non-sanitized values
	 * @throws RangeException if image type will not fit in database
	 */
	public function setImageType($newImageType){
		//Sanitize
		$newImageType = filter_var($newImageType, FILTER_SANITIZE_STRING);

		//Exception if only non-sanitized values (and is now empty)
		if($newImageType === false) {
			throw(new \InvalidArgumentException("image type is not a valid string"));
		}

		//Exception if input will not fit in the database
		if(strlen($newImageType) > 128){
			throw(new \RangeException("image type (string) is too large"));
		}

		//Save the input
		$this->imageType = $newImageType;
	}

	/*
	 * Accessor method for imageFileName
	 * @return
	 */






}


/*
 * TODO:
 * imageId
 * imageProfileId
 * imageType
 * imageFileName
 * imageText
 */