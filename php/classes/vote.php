<?php
/**
 * Created by PhpStorm.
 * User: michaelkemm
 * Date: 1/31/16
 * Time: 12:21 PM
 */

// namespace     ;

include_once("autoload.php");

/**
 * Vote: Users can up/down vote content
 * @author Michael Kemm
 */

class vote {

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

	private $voteType;




	/**
	 * accessor method for vote profile id
	 * return int value for vote profile id
	 */

	public function getVoteProfileId() {
		return $this->voteProfileId;
	}

	/**
	 * accessor method for vote image id
	 * return int value for vote image id
	 */

	public function getVoteImageId() {
		return $this->voteImageId;
	}

	/**
	 * accessor method for vote type
	 * return int value for vote type
	 */

	public function getVoteType() {
		return $this->voteType;
	}























}