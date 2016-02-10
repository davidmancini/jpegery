<?php

namespace Edu\Cnm\Jpegery;

require_once("autoload.php");

/**
 * Class Profile
 * @author Michael Kemm
 * @author David Mancini
 * @author Jacob Findley
 * @author Zach Leyba
 *
 *The User's profile
 */

class Profile implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id for profile, the primary key
	 * @var int $profileId
	 */

	private $profileId;

	/**
	 * profile admin (null)
	 *
	 * @var bool $profileAdmin
	 */

	private $profileAdmin;

	/**
	 * date the user created the profile
	 *
	 * @var \DateTime $profileCreateDate
	 */

	private $profileCreateDate;

	/**
	 * user's email address
	 *
	 * @var string $profileEmail
	 */

	private $profileEmail;

	/**
	 * user's @handle
	 *
	 * @var string $profileHandle
	 */

	private $profileHandle;

	/**
	 * hash for the password
	 *
	 * @var string $profileHash
	 */

	private $profileHash;

	/**
	 * user's profile picture
	 *
	 * @var $profileImage
	 */
	private $profileImageId;

	/**
	 * user name
	 *
	 * @var string $profileName
	 */

	private $profileName;

	/**
	 * user's phone number
	 *
	 * @var string $profilePhone
	 */

	private $profilePhone;

	/**
	 * salt for the password
	 *
	 * @var string $profileSalt
	 */

	private $profileSalt;

	/**
	* verification method for profile
	*
	* @var $profileVerify
	*/

	private $profileVerify;


	public function __construct(int $newProfileId = null, bool $newProfileAdmin, $newProfileCreateDate = null, string $newProfileEmail, string $newProfileHandle, string $newProfileHash,  $newProfileImageId = null, string $newProfileName, $newProfilePhone = null, string $newProfileSalt, string $newProfileVerify) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileAdmin($newProfileAdmin);
			$this->setProfileCreateDate($newProfileCreateDate);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHandle($newProfileHandle);
			$this->setProfileHash($newProfileHash);
			$this->setprofileImageId($newProfileImageId);
			$this->setProfileName($newProfileName);
			$this->setProfilePhone($newProfilePhone);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileVerify($newProfileVerify);
		}
			//Rethrow the exception to the caller
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
	 * accessor method for profile id
	 *
	 * @return int value of profile id
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
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}
		//verify the profile id is positive
		if($newProfileId <= 0) {
			throw(new \RangeException("Profile Id is not positive"));
		}
		// convert and store the profile id
		$this->profileId = $newProfileId;
	}

	/**
	 * accessor method for profile admin
	 *
	 * @return bool the value of profile admin
	 */

	public function getProfileAdmin() {
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
	 * accessor method for profile creation date
	 *
	 * @return \DateTime value of profile creation date
	 */

	public function getProfileCreateDate() {
		return($this->profileCreateDate);
	}

	/**
	 * mutator method for profile creation date
	 *
	 * @param \DateTime|null $newProfileCreateDate
	 *
	 *
	 */

	public function setProfileCreateDate($newProfileCreateDate = null) {

		if($newProfileCreateDate === null) {
			$this->profileCreateDate = new \DateTime();
		}

		// save the profile creation date
		try {
			$newProfileCreateDate = $this->validateDate($newProfileCreateDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}

		// save date
		$this->profileCreateDate = $newProfileCreateDate;
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
			throw(new \InvalidArgumentException("email is empty, insecure, or not a valid email"));
		}
		// save email
		$this->profileEmail = $newProfileEmail;
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
		if(empty($newProfileHandle) === true) {
			throw(new \InvalidArgumentException("profile handle is empty or insecure"));
		}

		// verify handle length
		if(strlen($newProfileHandle) > 18) {
			throw(new \RangeException("profile handle is too long"));
		}

		// save handle
		$this->profileHandle = $newProfileHandle;
	}

	/**
	 * accessor method for profile hash
	 *
	 * @return string value of profile hash
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

		// save profile hash
		$this->profileHash = $newProfileHash;
	}

	/**
	 * accessor method for profile image
	 * @return int value of image id
	 */

	public function getProfileImageId() {
		return $this->profileImageId;
	}


	/**
	 * mutator method for profile image
	 * @param
	 * @throws
	 */

	public function setProfileImageId(int $newProfileImageId) {
		// verify that the image id is positive
		if($newProfileImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		// save profile image id
		$this->profileImageId = $newProfileImageId;
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

		// verify valid name length
		if(strlen($newProfileName) > 50) {
			throw(new \RangeException("Your name is too long"));
		}
		// save profile name
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
		// verify the profile phone number is a proper phone number
		$newProfilePhone = trim($newProfilePhone);
		$newProfilePhone = filter_var($newProfilePhone, FILTER_SANITIZE_STRING);
		if(empty($newProfilePhone) === true) {
			throw(new \InvalidArgumentException("phone content is empty or insecure"));
		}
		// save profile phone #
		$this->profilePhone = $newProfilePhone;
	}

	/**
	 * accessor method for profile salt
	 *
	 * @return string value profile salt
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
		// verify that the profile salt is valid
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = filter_var($newProfileSalt, FILTER_SANITIZE_STRING);
		if(empty($newProfileSalt) === true) {
			throw(new \InvalidArgumentException("profile salt is empty or insecure"));
		}

		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * accessor method for profile verification
	 *
	 * @return string $profileVerify
	 */

	public function getProfileVerify() {
		return $this->profileVerify;
	}

	/**
	 * mutator method for profile verification
	 *
	 * @param string $newProfileVerify the value of profile verification content
	 * @throws \InvalidArgumentException if verification content is empty or insecure
	 */

	public function setProfileVerify(string $newProfileVerify) {
		// verify that verification content is secure
		$newProfileVerify = trim($newProfileVerify);
		$newProfileVerify = filter_var($newProfileVerify, FILTER_SANITIZE_STRING);
		if(empty($newProfileVerify) === true) {
			throw(new\InvalidArgumentException("verification content is empty or insecure"));
		}

		// save the verification content
		$this->profileVerify = $newProfileVerify;

	}

	/**
	 * inserts this comment into mySQL
	 *
	 * @param \PDO $pdo PDO profile object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo) {
		// enforce that the profile id is null
		if($this->profileId !== null) {
			throw(new \PDOException("Not a new profile."));
		}
		// create query template
		$query = "INSERT INTO profile(profileId, profileAdmin, profileCreateDate, profileEmail, profileHandle, profileHash, profileImageId, profileName, profilePhone, profileSalt, profileVerify) VALUES(:profileId, :profileAdmin, :profileCreateDate, :profileEmail :profileHandle, :profileHash, :profileImageId, :profileName, :profilePhone, :profileSalt, :profileverify)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder
		$formattedDate = $this->profileCreateDate->format("Y-m-d H:i:s");
		$parameters = ["profileId" => $this->profileId, "profileAdmin" => $this->profileAdmin, "profileCreateDate" => $formattedDate, "profileEmail" => $this->profileEmail, "profileHandle" => $this->profileHandle, "profileHash" => $this->profileHash, "profileImageId" => $this->profileImageId, "profileName" => $this->profileName, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);

		// save profile id given by mySQL
		$this->profileId = intval($pdo->lastInsertId());
	}

	/**
	 * delets this profile from mySQL
	 *
	 * @param \PDO $pdo PDO profile object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) {
		//enforce that the profile id is not null
		if($this->profileId === null) {
			throw(new \PDOException("The profile you are attempting to delete does not exist."));
		}
		// create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the placeholder
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}


	/**
	 * update this profile in mySQL
	 *
	 * @param \PDO $pdo PDO profile object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function update(\PDO $pdo) {
		// enforce that the profile id is not null
		if($this->profileId === null) {
			throw(new \PDOException("The profile you are attempting to update does not exist."));
		}

		// create query template
		$query = " UPDATE profile SET profileId = :profileId, profileAdmin = :profileAdmin, profileCreateDate = :profileCreateDate, profileEmail = :profileEmail, profileHandle = :profileHandle, profileHash = :profileHash, profileImageId = :profileImageId, profileName = :profileName, profilePhone = :profilePhone, profileSalt = :profilesalt, profileVerify = :profileVerify";
		$statement = $pdo->prepare($query);

		// bind the number variables to the placeholders
		$parameters = ["profileId" => $this->profileId, "profileAdmin" => $this->profileAdmin, "profileCreateDate" => $this->profileCreateDate, "profileEmail" => $this->profileEmail, "profileHandle" => $this->profileHandle, "profileHash" => $this->profileHash, "profileImageId" => $this->profileImageId, "profileName" => $this->profileName, "profilePhone" => $this->profilePhone, "profileSalt" => $this->profileSalt, "profileVerify" => $this->profileVerify];
		$statement->execute($parameters);

	}

	/**
	 * get Comment by comment id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId primary key of the profile
	 * @return profile|null profile found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getProfileByProfileId(\PDO $pdo, int $profileId) {
		//Sanitize the profile id before seaching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}

		//Create query template
		$query = "SELECT profileId, profileAdmin, profileCreateDate, profileEmail, profileHandle, profileHash, profileImageId, profileName, profilePhone, profileSalt, profileVerify FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		//Bind the comment id to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		//Grab the comment from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileAdmin"], $row["profileCreateDate"], $row["profileEmail"], $row["profileHandle"], $row["profileHash"], $row["profileImageId"], $row["profileName"], $row["profilePhone"], $row["profileSalt"], $row["profileVerify"]);
			}
		} catch(\Exception $exception) {
			//If the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * formats the state variable for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields ["profileCreateDate"] = intval($this->profileCreateDate->format("U")) * 1000;
		return($fields);
	}
// the end...
}
