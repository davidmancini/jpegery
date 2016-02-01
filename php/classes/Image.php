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


}


/*
 * TODO:
 * imageId
 * imageProfileId
 * imageType
 * imageFileName
 * imageText
 */