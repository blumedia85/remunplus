<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class UserExistsException
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class UserExistsException extends Exception implements MentordeveloperExceptionsInterface {}