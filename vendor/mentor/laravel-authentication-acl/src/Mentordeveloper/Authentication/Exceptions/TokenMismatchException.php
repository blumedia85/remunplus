<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class UseTokenMismatchExceptionrExistsException
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class TokenMismatchException extends Exception implements MentordeveloperExceptionsInterface {}