<?php
/**
 * Created by PhpStorm.
 * User: zleyba
 * Date: 1/28/16
 * Time: 1:38 PM
 */

include_once("autoload.php");


class Comment implements JsonSerializable {
	/**
	 * id for comment, the primary key
	 * @var int $commentId
	 */
	private $commentId;

	/**
	 * id for image, foreign key
	 * @var int $commentImageId
	 */
	private $commentImageId;

	/**
	 * id for profile, foreign key
	 * @var int $commentProfileId
	 */
	private $commentProfileId;

	/**
	 * the text of the comment
	 * @var string $commentText
	 */
	private $commentText;

	/**
	 * the date the comment was posted
	 * @var \DateTime $commentDate
	 */
	private $commentDate;

	/**
	 * accessor method for comment id
	 *
	 * @return int value of comment id
	 */
	public function getCommentId() {
		return $this->commentId;
	}

	/**
	 * mutator method for comment id
	 *
	 * @param int|null $newCommentId
	 * @throws \RangeException if $newCommentId is not positive
	 * @throws \TypeError if $newCommentId is not an int
	 */
	public function setCommentId(int $newCommentId = null) {
		//base case: If $newCommentId is null, this is a new comment
		if($newCommentId === null) {
			$this->commentId = null;
			return;
		}
		//verify the comment id is positive
		if ($newCommentId <= 0) {
			throw(new \RangeException("comment id is not positive"));
		}
		$this->commentId = $newCommentId;
	}

	/**
	 * accessor method for image id
	 * @return int value of image id
	 */
	public function getCommentImageId() {
		return $this->commentImageId;
	}

	/**
	 * mutator method for comment image id
	 *
	 * @param int $newCommentImageId
	 * @throws \RangeException if $newCommentImageId is not positive
	 * @throws \TypeError if $newCommentImageId is not an int
	 */
	public function setCommentImageId(int $newCommentImageId) {
		//Verify $newCommentImageId is positive
		if($newCommentImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}
		$this->commentImageId = $newCommentImageId;
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int value of profile id
	 */
	public function getCommentProfileId() {
		return $this->commentProfileId;
	}

	/**
	 * mutator method for comment profile id
	 *
	 * @param int $newCommentProfileId
	 * @throws \RangeException if $newCommentProfileId is not positive
	 * @throws \TypeError if $newCommentProfileId is not an int
	 */
	public function setCommentProfileId(int $newCommentProfileId) {
		//verify $newCommentProfileId is positive
		if($newCommentProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		$this->commentProfileId = $newCommentProfileId;
	}

	public function jsonSerialize() {
		//TODO finish this
		return(null);
	}
}