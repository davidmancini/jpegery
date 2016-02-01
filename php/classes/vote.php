<?php
/**
 * Created by PhpStorm.
 * User: michaelkemm
 * Date: 1/31/16
 * Time: 12:21 PM
 */

namespace Edu\Cnm\Jpegery\;

require_once("autoload.php");

/**
 * Vote: Users can up/down vote content
 * @author Michael Kemm
 */
class vote {

	/**
	 * profile id associated with vote
	 * @var $voteProfileId
	 */

	private $profileId;

	/**
	 * image id associated with vote
	 * @var $voteImageId
	 */

	private $imageId;

	/**
	 * vote type: up/down vote
	 * @var $voteType
	 */

	private $voteValue;


	/**
	 * accessor method for profile id
	 * return int value for profile id
	 */

	public function getVoteProfileId() {
		return $this->profileId;
	}

	/**
	 * mutator method for vote profile id
	 * @param int $newProfileId the new value of vote profile id
	 * @throws \RangeException if profile id is not positive
	 * @throws \TypeError if id is not an integer
	 */

	public function setVoteProfileId(int $newProfileId) {
		// verify that the profile id is positive
		if($newProfileId <= 0) {
			throw (new \RangeException("vote profile id is not positive"));
		}

		// save valid id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for vote image id
	 * return int value for vote image id
	 */

	public function getImageId() {
		return $this->imageId;
	}

	/**
	 * mutator method for vote image id
	 * @param int $newImageId the new value of vote profile id
	 * @throws \RangeException if image id is not positive
	 * @throws \TypeError if image id is not positive
	 */

	public function setImageId(int $newImageId) {
		// verify that the image id is positive
		if($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		// save valid id
		$this->imageId = $newImageId;
	}

	/**
	 * accessor method for vote type
	 * return int value for vote type
	 */

	public function getVoteValue() {
		return $this->voteValue;
	}

	/** mutaor method for vote type
	 *
	 * @param int @newVoteValueUp verify vote value
	 * @throws \RangeException if vote is not 1 or -1
	 */


	public function setVoteValue(int $newVoteValue) {
		// verify vote value
		if($newVoteValue !== 1 && $newVoteValue !== -1) {
			throw(new \RangeException("there is no vote"))
		}

		// save vote value
		$this->voteValue = $newVoteValue;
	}

/**
 * inserts this vote into mySQL
 *
 * @param \PDO $pdo connects object to PDO
 *
 *
 */

	public function insert(\PDO $pdo) {
		// enforce that vote is null
		if($this->voteValue !== null) {
			throw(new \PDOException("this is not a new vote"));
		}

		// create query template
		$query = "INSERT INTO vote(profileId, imageId, voteValue ) VALUES (:profileId : imageId :voteValue)";
		$statment = $pdo->prepare($query);

		// bind the member variable to the place holders in the template
		$parameters = ["profileId" => $this->profileId]






	}







	}