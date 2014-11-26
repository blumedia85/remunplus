<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class UserNotFoundException
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class LoginRequiredException extends Exception implements MentordeveloperExceptionsInterface {}