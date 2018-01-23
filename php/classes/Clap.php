<?php
namespace Edu\Cnm\DataDesign;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
class Clap {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id of the blog that this clap is for; this is a foreign key
	 * @var Uuid $clapblogId
	 **/
	private $clapblogId;
	/**
	 * id of the Profile that sent this clap; this is a foreign key
	 * @var Uuid $clapProfilId
	 **/
	private $clapProfileId;
	/**
	 * accessor method for clap blog id
	 *
	 * @return Uuid value of clap blog id
	 **/
	public function getClapblogId() : Uuid{
		return($this->clapblogId);
	}
	/**
	 * mutator method for clap blog id
	 *
	 * @param string | Uuid $newClapblogId new value of clap blog id
	 * @throws \RangeException if $newClapblogId is not positive
	 * @throws \TypeError if $newClapblogId is not an integer
	 **/
	public function setClapblogId($newClapblogId) : void {
		try {
			$uuid = self::validateUuid($newClapblogId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->clapblogId= $uuid;
	}
	/**
	 * accessor method for clap profile id
	 *
	 * @return Uuid value of clap profile id
	 **/
	public function getClapProfileId() : Uuid{
		return($this->clapProfileId);
	}
	/**
	 * mutator method for clap profile id
	 *
	 * @param string | Uuid $newClapProfileId new value of clap profile id
	 * @throws \RangeException if $newClapProfileId is not positive
	 * @throws \TypeError if $newClapProfileId is not an integer
	 **/
	public function setClapProfileId($newClapProfileId) : void {
		try {
			$uuid = self::validateUuid($newClapProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->clapProfileId = $uuid;
	}
}