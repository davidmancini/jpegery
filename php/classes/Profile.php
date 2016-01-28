<?php
/**
 * Created by PhpStorm.
 * User: zleyba
 * Date: 1/28/16
 * Time: 1:35 PM
 */
//namespace Edu\Cnm\
include_once("autoload.php");

/**
 * Class Profile
 * @authors David Mancini, Jacob Findley, Michael Kemm, Zach Leyba
 *
 *The User's profile
 */
class Profile implements JsonSerializable {

	/**
	 * id for profile, the primary key
	 * @var int $profileId
	 */
	private $profileId;

	/**
	 * what the user goes by
	 *
	 * @var string $profileHandle
	 */
	private $profileHandle;

	/**
	 * the user's name
	 *
	 * @var string $profileName
	 */
	private $profileName;

	/**
	 * the user's password
	 *
	 * @var string $profilePassword
	 */
	private $profilePassword;

	/**
	 * the user's phone number
	 *
	 * @var string $profilePhone
	 */
	private $profilePhone;

	/**
	 * the user's email address
	 * @var string $profileEmail
	 */
	private $profileEmail;

	/**
	 * Whether or not the user is an admin (Locked at null for now)
	 *
	 * @var bool $adminNull
	 */
	private $adminNull;

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 */
	public function getProfileId() {
		return $this->profileId;
	}

	public function setProfileId( $profileId) {
		$this->profileId = $profileId;
	}

	public function jsonSerialize() {
		//TODO finish this
		return(null);
	}
}