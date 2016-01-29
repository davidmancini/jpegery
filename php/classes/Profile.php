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
	 * @var bool $profileAdmin
	 */
	private $profileAdmin;

	/**
	 * The hash for the password
	 *
	 * @var string $profileHash
	 */
	private $profileHash;

	/**
	 * The salt for the password
	 *
	 * @var string $profileSalt
	 */
	private $profileSalt;
	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 */
	public function getProfileId() {
		return $this->profileId;
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 */
	public function setProfileId(int $newProfileId = null) {
		//Base case--if profile id is null, this is a new profile without a mySQL assigned id
		if ($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		//verify the profile id is positive
		if ($newProfileId <= 0) {
			throw(new \RangeException("Profile Id is not positive"));
		}
		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profile handle
	 * @return string value of profile handle
	 */
	public function getProfileHandle() {
		return $this->profileHandle;
	}

	/**
	 * mutator method for profile handle
	 *
	 * @param string $newProfileHandle
	 * @throws \InvalidArgumentException if profile handle is empty or insecure
	 * @throws \RangeException if profile handle is too long
	 * @throws \TypeError if profile handle is not a string
	 */
	public function setProfileHandle(string $newProfileHandle) {
		// verify the profile handle is secure
		$newProfileHandle = trim($newProfileHandle);
		$newProfileHandle = filter_var($newProfileHandle, FILTER_SANITIZE_STRING);
		if (empty($newProfileHandle) === true) {
			throw(new \InvalidArgumentException("Profile Handle is empty or insecure"));
		}

		// make sure the handle isn't too long
		if(strlen($newProfileHandle) > 100) {
			throw(new \RangeException("Stop fooling around."));
		}
		if (strlen($newProfileHandle) > 18) {
			throw(new \RangeException("Profile handle is too long"));
		}

		//Store the handle
		$this->profileHandle = $newProfileHandle;
	}

	/**
	 * accessor method for profile name
	 * @return string value of profile name
	 */
	public function getProfileName() {
		return $this->profileName;
	}

	/**
	 * mutator method for profile name
	 * 
	 * @param string $newProfileName
	 * @throws \InvalidArgumentException if profile name is empty or insecure
	 * @throws \RangeException if profile name is too long
	 * @throws \TypeError if profile name is not a string
	 */
	public function setProfileName(string $newProfileName) {
		// verify the profile name is secure
		$newProfileName = trim($newProfileName);
		$newProfileName = filter_var($newProfileName, FILTER_SANITIZE_STRING);
		if(empty($newProfileName) === true) {
			throw(new \InvalidArgumentException("Profile Name is empty or insecure"));
		}

		//Make sure the name isn't too long
		if(strlen($newProfileName) > 50) {
			throw(new \RangeException("Your name is too long"));
		}
		$this->profileName = $newProfileName;
	}

	/**
	 * accessor method for profile phone number
	 *
	 * @return string value of profile phone number
	 */
	public function getProfilePhone() {
		return $this->profilePhone;
	}

	/**
	 * @param string $newProfilePhone
	 * @throws \InvalidArgumentException if $newProfilePhone is empty or insecure
	 * @throws \
	 */
	public function setProfilePhone(string $newProfilePhone) {
		//verify the profile phone number is a proper phone number
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING);
		if(empty($newProfilePhone) === true) {
			throw(new \InvalidArgumentException("Phone is empty or insecure"));
		}
		$this->profilePhone = $newProfilePhone;
	}

	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 */
	public function getProfileEmail() {
		return $this->profileEmail;
	}

	/**
	 * mutator method for $profileEmail
	 *
	 * @param string $newProfileEmail
	 * @throws \InvalidArgumentException if email is empty or insecure or not a proper email
	 * @throws \TypeError if $newProfileEmail is not a string
	 */
	public function setProfileEmail(string $newProfileEmail) {
		//verify the email is a proper email
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("Email is empty, insecure, or not a valid email"));
		}
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile admin
	 *
	 * @return bool the value of profile admin
	 */
	public function isProfileAdmin() {
		return $this->profileAdmin;
	}

	/**
	 * mutator method for profile admin
	 *
	 * @param bool $newProfileAdmin
	 * @throws \TypeError if $newProfileAdmin is not a bool
	 */
	public function setProfileAdmin(bool $newProfileAdmin) {

		$this->profileAdmin = $newProfileAdmin;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string the value of profile hash
	 */
	public function getProfileHash() {
		return $this->profileHash;
	}

	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash the value of profile hash
	 * @throws \InvalidArgumentException if $newProfileHash is empty or insecure
	 * @throws \TypeError if $newProfileHash is not a string
	 */
	public function setProfileHash(string $newProfileHash) {
		//verify that the profile hash is valid
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("Profile hash is either empty or insecure"));
		}

		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile salt
	 *
	 * @return string the value of profile salt
	 */
	public function getProfileSalt() {
		return $this->profileSalt;
	}

	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if $newProfileSalt is empty or insecure
	 * @throws \TypeError if $newProfileSalt is not a string
	 */
	public function setProfileSalt(string $newProfileSalt) {
		//verify that the profile salt is valid
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("Profile salt is either empty or insecure"));
		}

		$this->profileSalt = $newProfileSalt;
	}
	public function jsonSerialize() {
		//TODO finish this
		return(null);
	}
}