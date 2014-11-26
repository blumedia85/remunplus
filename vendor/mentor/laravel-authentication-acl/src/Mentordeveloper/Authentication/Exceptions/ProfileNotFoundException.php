<?php namespace Mentordeveloper\Authentication\Exceptions;
/**
 * Class ProfileNotFoundException
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */

use Exception;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;

class ProfileNotFoundException extends Exception implements MentordeveloperExceptionsInterface {}