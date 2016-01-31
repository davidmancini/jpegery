<?php

include_once("autoload.php");

class Follower implements JsonSerializable {

	/**
	 * id for the follower (One who is following another), this is a composite primary key
	 * @var int $followerId
	 */
	private $followerId;

	/**
	 * id for the followed (One who is being followed by another), this is a composite primary key
	 * @var int $followedId
	 */
	private $followedId;


	/**
	 * Follower constructor.
	 *
	 * @param int $newFollowerId A composite id, specifically that of the follower
	 * @param int $newFollowedId A composite id, specifically that of the followed
	 * @throws \InvalidArgumentException if the data types are not valid
	 * @throws \RangeException if the ids are not positive numbers
	 * @throws \TypeError if the ids are not ints
	 * @throws \Exception if some other problem occurs
	 */
	public function __construct(int $newFollowerId, int $newFollowedId) {
		try {
			$this->setFollowerId($newFollowerId);
			$this->setFollowedId($newFollowedId);
		}
		//Rethrow the exception to the caller
		catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
		catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		catch(\TypeError $typeError) {
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}
		catch(\Exception $exception) {
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for follower id
	 *
	 * @return int value of follower id
	 */
	public function getFollowerId() {
		return $this->followerId;
	}

	/**
	 * mutator method for follower id
	 *
	 * @param int $newFollowerId
	 * @throws \RangeException if $newFollowerId is not a positive number
	 * @throws \TypeError if $newFollowerId is not an int
	 */
	public function setFollowerId(int $newFollowerId) {
		//If the follower id is null, throw error
		if($newFollowerId === null) {
			throw(new \RangeException("The follower must exist"));
		}

		//Out of bounds error
		if($newFollowerId <= 0) {
			throw(new \RangeException("The follower has a negative number or zero for their id"));
		}
		$this->followerId = $newFollowerId;
	}

	/**
	 * accessor method for followed id
	 *
	 * @return int the value of the followed id
	 */
	public function getFollowedId() {
		return $this->followedId;
	}

	/**
	 * mutator method for followed id
	 *
	 * @param $newFollowedId
	 * @throws \RangeException if $newFollowedId is not a positive number
	 * @throws \TypeError if $newFollowedId is not an int
	 */
	public function setFollowedId($newFollowedId) {
		//If the followed id is null, throw error
		if($newFollowedId === null) {
			throw(new \RangeException("The followed must exist"));
		}
		//out of bounds error
		if($newFollowedId <= 0) {
			throw(new \RangeException("The followed has a negative number or zero for their id"));
		}
		$this->followedId = $newFollowedId;
	}

	//Not sure how to do the insert just yet
	public function insert(\PDO $pdo) {

	}

	/**
	 * delete this follower relationship from mySQL
	 *
	 * @param PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) {
		//Enforce that the relationship can exist
		if($this->followedId === null) {
			throw(new \PDOException("The id of the followed does not exist"));
		}
		if($this->followerId === null) {
			throw(new \PDOException("The id of the follower does not exist"));
		}

		//Create query template
		$query = "DELETE FROM follower WHERE followerId = :followerId AND followedId = :followedId";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the placeholder in the template
		$parameters = ["followerId" => $this->followerId, "followedId" => $this->followedId];
		$statement->execute($parameters);
	}

	public function jsonSerialize() {
		//TODO finish this
		return(null);

	}
}