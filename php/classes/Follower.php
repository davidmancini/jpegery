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

	public function jsonSerialize() {
		//TODO finish this
		return(null);

	}
}