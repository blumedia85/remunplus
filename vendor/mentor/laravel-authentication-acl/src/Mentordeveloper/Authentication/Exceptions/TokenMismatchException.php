<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class UseTokenMismatchExceptionrExistsException
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class TokenMismatchException extends Exception implements MentordeveloperExceptionsInterface {}