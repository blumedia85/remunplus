<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class UserNotFoundException
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class UserNotFoundException extends Exception implements MentordeveloperExceptionsInterface {}