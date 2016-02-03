<?php
/**
 * Created by PhpStorm.
 * User: michaelkemm
 * Date: 1/31/16
 * Time: 12:21 PM
 */

namespace Edu\Cnm\Jpegery;

require_once("autoload.php");

/**
 * Vote: Users can up/down vote content
 * @author Michael Kemm
 * @author David Mancini
 * @author Jacob Findley
 * @author Zach Leyba
 */
class Vote {

	/**
	 * profile id associated with vote
	 * @var $voteProfileId
	 */

	private $voteProfileId;

	/**
	 * image id associated with vote
	 * @var $voteImageId
	 */

	private $voteImageId;

	/**
	 * vote type: up/down vote
	 * @var $voteType
	 */

	private $voteValue;


	/**
	 * accessor method for profile id
	 * @return int value for profile id
	 */

	public function getVoteProfileId() {
		return $this->voteProfileId;
	}

	/**
	 * mutator method for vote profile id
	 * @param int $newProfileId the new value of vote profile id
	 * @throws \RangeException if profile id is not positive
	 * @throws \TypeError if id is not an integer
	 */

	public function setVoteProfileId(int $newVoteProfileId) {
		// verify that the profile id is positive
		if($newVoteProfileId <= 0) {
			throw (new \RangeException("vote profile id is not positive"));
		}

		// save valid id
		$this->VoteProfileId = $newVoteProfileId;
	}

	/**
	 * accessor method for vote image id
	 * @return int value for vote image id
	 */

	public function getImageId() {
		return $this->voteImageId;
	}

	/**
	 * mutator method for vote image id
	 * @param int $newImageId the new value of vote profile id
	 * @throws \RangeException if image id is not positive
	 * @throws \TypeError if image id is not positive
	 */

	public function setImageId(int $newVoteImageId) {
		// verify that the image id is positive
		if($newVoteImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		// save valid id
		$this->voteImageId = $newVoteImageId;
	}

	/**
	 * accessor method for vote type
	 * @return int value for vote type
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
			throw(new \RangeException("there is no vote"));
		}

		// save vote value
		$this->voteValue = $newVoteValue;
	}

/**
 * insert this vote into mySQL
 *
 * @param \PDO $pdo connects object to PDO
 * @throws \PDOException when mySQL errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 *
 */

	public function insert(\PDO $pdo) {
		// enforce that vote is null
		if($this->voteProfileId === null || $this->voteImageId === null) {
			throw(new \PDOException("this is not a new vote"));
		}

		// create query template
		$query = "INSERT INTO vote(voteProfileId, voteImageId, voteValue ) VALUES (:voteProfileId : voteImageId :voteValue)";
		$statement = $pdo->prepare($query);

		// bind the member variable to the place holders in the template
		$parameters = ["voteProfileId" => $this->voteProfileId, "voteImageId" => $this->voteImageId, "voteValue" => $this->voteValue];
		$statement->execute($parameters);

		// update the null vote value with the value provided by mySQL
		$this->voteValue = intval($pdo->lastInsertId());
	}

/**
 * delete this vote from my SQL
 * \PDOException when mySQL errors occur
 * \TypeError if $pdo is not a PDO connection object
 */

	public function delete(\PDO $pdo) {
		// enforce that this vote is not null
		if($this->voteValue === null) {
			throw(new \PDOException("vote does not exist"));
		}

		// create query template
		$query = "DELETE FROM votevalue WHERE voteValue = :voteValue";
		$statement = $pdo->prepare($query);

		// bind member variable to the placeholders
		$parameters = ["voteProfileId" => $this->voteProfileId, "voteImageId" => $this->voteImageId, "voteValue" => $this->voteValue];
		$statement->execute($parameters);
	}

	/**
	 * update this vote in mySQL
	 *
	 * PDOException when mySQL errors occur
	 * \TypeError if $pdo is not a PDO connection object
	 */

	public function update(\PDO $pdo) {
		// enforce that this vote in not null
		if($this->voteValue === null) {
			throw(new \PDOException("cannot update, vote does not exist"));
		}
		// create query template
		$query = "UPDATE voteValue SET voteProfileId = :voteVrofileId, voteImageId = :voteImageId, voteValue = :voteValue";
		$statement = $pdo->prepare($query);

		// bind member variables to the placeholders

		$parameters = ["voteProfileId" => $this->voteProfileId, "voteImageId" => $this->voteImageId, "voteValue" => $this->voteValue];
		$statement->execute($parameters);


	}





	}