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
	 * composite primary key
	 * @var $voteId
	 */
	private $voteId;

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
	 * Comment constructor.
	 *
	 * @param int|null $newVoteId, composite key
	 * @param int $newVoteImageId, foreign key
	 * @param int $newVoteProfileId, foreign key
	 * @param int $newVoteValue, Value of vote
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newVoteId = null, int $newVoteProfileId, int $newVoteImageId, $newVoteValue) {
		try {
			$this->setVoteId($newVoteId);
			$this->setVoteProfileId($newVoteProfileId);
			$this->setVoteImageId($newVoteImageId);
			$this->setVoteValue($newVoteValue);
		}
			//Rethrow the exception to the caller
		catch(\RangeException $range) {
				throw(new \RangeException($range->getMessage(), 0, $range));
			}
		catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}
		catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}


	/**
	 * accessor method for vote id
	 *
	 * @return int value of vote id
	 **/
	public function getVoteId() {
		return $this->voteId;
	}

	/**
	 * mutator method for vote id
	 *
	 * @param int|null $newVoteId
	 * @throws \RangeException if $newVoteId is not positive
	 * @throws \TypeError if $newVoteId is not an int
	 **/
	public function setVoteId(int $newVoteId = null) {
		// If $newVoteId is null, this is a new comment
		if($newVoteId === null) {
			$this->voteId = null;
			return;
		}
		//verify the comment id is positive
		if($newVoteId <= 0) {
			throw(new \RangeException("vote id is not positive"));
		}
		$this->voteId = $newVoteId;
	}


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
	 * @param int $newVoteImageId the new value of vote profile id
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
		if($this->voteProfileId !== null && $this->voteImageId !== null) {
			throw(new \PDOException("this is not a new vote"));
		}

		// create query template
		$query = "INSERT INTO vote(voteProfileId, voteImageId, voteValue ) VALUES (:voteProfileId, :voteImageId, :voteValue)";
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


	/**
	 * get Vote by voteId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $voteId tweet id to search for
	 * @return Vote|null Vote found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getVoteByVoteId(\PDO $pdo, int $voteId) {
		// sanitize the voteId before searching
		if($voteId <= 0) {
			throw(new \PDOException("vote id is not positive"));
		}

		// create query template
		$query = "SELECT voteId, voteProfileId, voteValue FROM vote WHERE voteId = :voteId";
		$statement = $pdo->prepare($query);

		// bind the vote id to the place holder in the template
		$parameters = array("voteId" => $voteId);
		$statement->execute($parameters);

		// grab the vote from mySQL
		try {
			$vote = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$vote = new Vote($row["voteId"], $row["voteProfileId"], $row["voteValue"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($vote);
	}

	/**
	 * get all Votes
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Tweets found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllVotes(\PDO $pdo) {
		// create query template
		$query = "SELECT voteProfileId, voteImageId, voteValue, FROM vote";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of votes
		$votes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vote = new Vote($row["voteProfileId"], $row["voteImageId"], $row["voteValue"]);
				$votes[$votes->key()] = $vote;
				$votes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($votes);
	}


}