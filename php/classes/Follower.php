<?php

namespace Edu\Cnm\Jpegery;

require_once("autoload.php");

/**
 * Class Follower
 * @authors David Mancini, Jacob Findley, Michael Kemm, Zach Leyba
 *
 * Represents the Follower relationship
 *
 */
class Follower implements \JsonSerializable {

	/**
	 * id for the follower (One who is following another), this is a composite primary key
	 * @var int $followerFollowerId
	 */
	private $followerFollowerId;

	/**
	 * id for the followed (One who is being followed by another), this is a composite primary key
	 * @var int $followerFollowedId
	 */
	private $followerFollowedId;


	/**
	 * Follower constructor.
	 *
	 * @param int $newFollowerFollowerId A composite id, specifically that of the follower
	 * @param int $newFollowerFollowedId A composite id, specifically that of the followed
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the ids are not positive numbers
	 * @throws \TypeError if the ids are not ints
	 * @throws \Exception if some other problem occurs
	 */
	public function __construct(int $newFollowerFollowerId, int $newFollowerFollowedId) {
		try {
			$this->setFollowerFollowerId($newFollowerFollowerId);
			$this->setFollowerFollowedId($newFollowerFollowedId);
		} //Rethrow the exception to the caller
		catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for follower id
	 *
	 * @return int value of follower id
	 */
	public function getFollowerFollowerId() {
		return $this->followerFollowerId;
	}

	/**
	 * mutator method for follower id
	 *
	 * @param int $newFollowerFollowerId
	 * @throws \RangeException if $newFollowerId is not a positive number
	 * @throws \TypeError if $newFollowerId is not an int
	 */
	public function setFollowerFollowerId(int $newFollowerFollowerId) {
		//Out of bounds error
		if($newFollowerFollowerId <= 0) {
			throw(new \RangeException("The follower has a negative number or zero for their id"));
		}
		$this->followerFollowerId = $newFollowerFollowerId;
	}

	/**
	 * accessor method for followed id
	 *
	 * @return int the value of the followed id
	 */
	public function getFollowerFollowedId() {
		return $this->followerFollowedId;
	}

	/**
	 * mutator method for followed id
	 *
	 * @param $newFollowerFollowedId
	 * @throws \RangeException if $newFollowedId is not a positive number
	 * @throws \TypeError if $newFollowedId is not an int
	 */
	public function setFollowerFollowedId($newFollowerFollowedId) {
		//Out of bounds error
		if($newFollowerFollowedId <= 0) {
			throw(new \RangeException("The followed has a negative number or zero for their id"));
		}
		$this->followerFollowedId = $newFollowerFollowedId;
	}


	/**
	 * inserts this Follower relationship into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) {
		//Make sure that followerId and followedId are not null
		if($this->followerFollowerId === null) {
			throw(new \PDOException("The follower id is not assigned"));
		}
		if($this->followerFollowedId === null) {
			throw(new \PDOException("The followed id is not assigned"));
		}

		//Create a query template
		$query = "INSERT INTO follower (followerId, followedId) VALUES (:followerFollowerId, :followerFollowedId)";
		$statement = $pdo->prepare($query);
		//Bind the member variables to the place holders in the template
		$parameters = ["followerFollowerId" => $this->followerFollowerId, "followerFollowedId" => $this->followerFollowedId];
		$statement->execute($parameters);
	}

	/**
	 * delete this Follower relationship from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		//Enforce that the relationship can exist
		if($this->followerFollowedId === null) {
			throw(new \PDOException("The id of the followed does not exist"));
		}
		if($this->followerFollowerId === null) {
			throw(new \PDOException("The id of the follower does not exist"));
		}

		//Create query template
		$query = "DELETE FROM follower WHERE followerFollowerId = :followerFollowerId AND followerFollowedId = :followerFollowedId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the placeholder in the template
		$parameters = ["followerFollowerId" => $this->followerFollowerId, "followerFollowedId" => $this->followerFollowedId];
		$statement->execute($parameters);
	}

	public function getFollowerByFollowerFollowerId(\PDO $pdo, int $followerFollowerId) {

	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}
