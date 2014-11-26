<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class UserExistsException
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class UserExistsException extends Exception implements MentordeveloperExceptionsInterface {}