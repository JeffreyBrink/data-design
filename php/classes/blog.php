<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Cross Section of a "Medium" blog
 *
 *This is a cross section of what is likely stored when a user posts an blog on Medium. This entity is a top-level entity and holds the keys to the other entities I will be using: Clap.
 *
 * @author Kenneth Keyes kkeyes1@cnm.edu updated  for /~kkeyes1/data-design
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 * @package Edu\Cnm\DataDesign
 **/
class blog {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this blog: primary key
	 * @var Uuid $blogID
	 **/
	private $blogId;
	/**
	 * this is the profile Id associated with this blog: foreign key
	 * @var Uuid $blogAuthorProfileId
	 **/
	private $blogProfileId;
	/**
	 * text content of the blog (for this exercise this attribute has been limited to 140 characters)
	 * @var string $blogContent
	 **/
	private $blogContent;
	/**
	 * date and time the blog was published in a PHP date time object
	 * @var \DateTime $blogDate
	 **/
	private $blogDate;
	/**
	 * constructor for this blog
	 *
	 * @param string|Uuid $newblogId id of this blog or null if a new blog
	 * @param string|Uuid $newblogProfileId id of the Profile that sent this blog
	 * @param string $newblogContent string containing actual blog data
	 * @param \DateTime|string|null $newblogDate date and time blog was sent or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newblogId, $newblogProfileId, string $newblogContent, $newblogDate = null) {
		try {
			$this->setblogId($newblogId);
			$this->setblogAuthorProfileId($newblogProfileId);
			$this->setblogContent($newblogContent);
			$this->setblogDate($newblogDate);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for blog id
	 *
	 * @return Uuid value of blog id
	 **/
	public function getblogId(): Uuid {
		return ($this->blogId);
	}
	/**
	 * mutator method for blog id
	 *
	 * @param Uuid/string $newblogId new value of blog id
	 * @throws \RangeException if $newblogId is not positive
	 * @throws \TypeError if $newblogId is not a uuid or string
	 **/
	public function setblogId($newblogId): void {
		try {
			$uuid = self::validateUuid($newblogId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the tweet id
		$this->blogId = $uuid;
	}
	/**
	 * accessor method for blog author's profile id
	 *
	 * @return Uuid value of blog author's profile id
	 **/
	public function getblogProfileId(): Uuid {
		return ($this->blogProfileId);
	}
	/**
	 * mutator method for blog author's profile id
	 *
	 * @param string | Uuid $newblogAuthorProfileId new value of blog author's profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newTweetProfileId is not an integer
	 **/
	public function setblogProfileId($newblogAuthorProfileId): void {
		try {
			$uuid = self::validateUuid($newblogAuthorProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->blogProfileId = $uuid;
	}
	/**
	 * accessor method for blog content
	 *
	 * @return string value of aricle content
	 **/
	public function getblogContent(): string {
		return ($this->blogContent);
	}
	/**
	 * mutator method for blog content
	 *
	 * @param string $newblogContent new value of blog content
	 * @throws \InvalidArgumentException if $enwblogContent is not a string or insecure
	 * @throws \RangeException if $newblogContent is > 140 characters (unrealistic, but that is how I build the database)
	 * @throws \TypeError if $newblogContent is not a string
	 **/
	public function setblogContent(string $newblogContent): void {
		// verify the tweet content is secure
		$newblogContent = trim($newblogContent);
		$newblogContent = filter_var($newblogContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newblogContent) === true) {
			throw(new \InvalidArgumentException("blog content is empty or insecure"));
		}
		// verify the blog content will fit in the database
		if(strlen($newblogContent) > 140) {
			throw(new \RangeException("blog content too large"));
		}
		// store the blog content
		$this->blogContent = $newblogContent;
	}
	/**
	 * accessor method for blog date
	 *
	 * @return \DateTime value of blog date
	 **/
	public function getblogDate(): \DateTime {
		return ($this->blogDate);
	}
	/**
	 * mutator method for blog date
	 *
	 * @param \DateTime|string|null $newblogDate blog date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newblogDate is not a valid object or string
	 * @throws \RangeException if $newblogDate is a date that does not exist
	 **/
	public function setblogDate($newblogDate = null): void {
		// base case: if the date is null, use the current date and time
		if($newblogDate === null) {
			$this->blogDate = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newblogDate = self::validateDateTime($newblogDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->blogDate = $newblogDate;
	}
}}