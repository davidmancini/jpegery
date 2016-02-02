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

class imageTag implements \JsonSerializable {

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

		try{
				$this->setImageId($newImageId);
				$this->setTagId($newTagId);
		}
		catch(\InvalidArgumentException $invalidArgument){
			//rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(),0, $invalidArgument));
		}
		catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		catch(\TypeError $typeError) {
			//rethrow the exception
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}
		catch(\Exception $exception) ;
		//rethrow the exception
		throw(new \Exception($exception->getMessage(), 0, $exception));
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
	public function setTagId($tagId) {
		$this->tagId = $tagId;
		//verify the tag id is positive
		if($newTagId <= 0) {
			throw(new \RangeException("tag id is not positive"));

			//convert and store the tag id
			$this->tagId = $newTagId;
		}
	}

}