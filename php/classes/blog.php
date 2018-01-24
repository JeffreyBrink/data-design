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
			$this->setblogProfileId($newblogProfileId);
			$this->setblogContent($newblogContent);
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
		// convert and store the blog id
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
	 * @throws \TypeError if $newblogProfileId is not an integer
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
		// verify the blog content is secure
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
	 * inserts this blog into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO blog(blogId,blogProfileId, blogContent, blogDate) VALUES(:blogId, :blogProfileId, :blogContent, :blogDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->blogDate->format("Y-m-d H:i:s.u");
		$parameters = ["blogId" => $this->blogId->getBytes(), "blogProfileId" => $this->blogProfileId->getBytes(), "blogContent" => $this->blogContent, "blogDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this blog from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM blog WHERE blogId = :blogId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["blogId" => $this->blogId->getBytes()];
		$statement->execute($parameters);
	}


	/**
	 * updates this blog in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		// create query template
		$query = "UPDATE blog SET blogProfileId = :blogProfileId, blogContent = :blogContent, WHERE blogId = :blogId";
		$statement = $pdo->prepare($query);
		$parameters = ["blogId" => $this->blogId->getBytes(), "blogProfileId" => $this->blogProfileId->getBytes(), "blogContent" => $this->blogContent, "blogDate"];
		$statement->execute($parameters);
	}


	/**
	 * gets the blog by blogId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $blogId blog id to search for
	 * @return blog|null blog found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getblogByblogId(\PDO $pdo, string $blogId): ?blog {
		// sanitize the blogId before searching
		try {
			$blogId = self::validateUuid($blogId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT blogId, blogProfileId, blogContent, blogDate FROM blog WHERE blogId = :blogId";
		$statement = $pdo->prepare($query);
		// bind the blog id to the place holder in the template
		$parameters = ["blogId" => $blogId->getBytes()];
		$statement->execute($parameters);
		// grab the blog from mySQL
		try {
			$blog = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$blog = new blog($row["blogId"], $row["blogProfileId"], $row["blogContent"], $row["blogDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($blog);
	}


	/**
	 * gets the blog by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $blogProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of blogs found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getblogByblogProfileId(\PDO $pdo, string $blogProfileId): \SPLFixedArray {
		try {
			$blogProfileId = self::validateUuid($blogProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT blogId, blogProfileId, blogContent, FROM blog WHERE blogProfileId = :blogProfileId";
		$statement = $pdo->prepare($query);
		// bind the blog profile id to the place holder in the template
		$parameters = ["blogProfileId" => $blogProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of blogs
		$blogs = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$blog = new blog($row["blogId"], $row["blogProfileId"], $row["blogContent"], $row["blogDate"]);
				$blogs[$blogs->key()] = $blog;
				$blogs->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($blogs);
		}

		/**
 * gets the blog by content
 * @param \PDO $pdo PDO connection object
 * @param string $blogContent blog content to search for
 * @return \splFixedArray splFixedArray of blogs found
 * @throws \PDOException when mySQL related error occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getblogByblogContent(\PDO $pdo, string $blogContent) : \SPLFixedArray {
	// sanitize the description before searching
	$blogContent = trim($blogContent);
	$blogContent = filter_var($blogContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if(empty($blogContent) === true) {
		throw(new \PDOException("blog content is invalid"));
	}
	// escape any mySQL wild cards
	$blogContent = str_replace("_", "\\_", str_replace("%", "\\%", $blogContent));
	// create query template
	$query = "SELECT blogId, blogProfileId, blogContent, blogDate FROM blog WHERE blogContent LIKE :blogContent";
	$statement = $pdo->prepare($query);
	// bind the blog content to the place holder in the template
	$blogContent = "%$blogContent%";
	$parameters = ["blogContent" => $blogContent];
	$statement->execute($parameters);
	// build an array of blogs
	$blogs = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$blog = new blog($row["blogId"], $row["blogProfileId"], $row["blogContent"], $row["blogDate"]);
			$blogs[$blogs->key()] = $blog;
			$blogs->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return($blogs);
}

/**
 * gets all blogs
 *
 * @param \PDO $pdo PDO connection object
 * @return \SplFixedArray SplFixedArray of blogs found or null if not found
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError when variables are not the correct data type
 **/
public static function getAllblogs(\PDO $pdo) : \SPLFixedArray {
	// create query template
	$query = "SELECT blogId, blogProfileId, blogContent FROM blog";
	$statement = $pdo->prepare($query);
	$statement->execute();

	// build an array of blogs
	$blogs = new \SplFixedArray($statement->rowCount());
	$statement->setFetchMode(\PDO::FETCH_ASSOC);
	while(($row = $statement->fetch()) !== false) {
		try {
			$blog = new blog($row["blogId"], $row["blogProfileId"], $row["blogContent"]);
			$blogs[$blogs->key()] = $blog;
			$blogs->next();
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
	}
	return ($blogs);
}

/**
 * formats the state variables for JSON serialization
 *
 * @return array resulting state variables to serialize
 **/
public function jsonSerialize() {
	$fields = get_object_vars($this);
	$fields["blogId"] = $this->blogId;
	$fields["blogProfileId"] = $this->blogProfileId;
	//format the date so that the front end can consume it
	return($fields);
		}
}



