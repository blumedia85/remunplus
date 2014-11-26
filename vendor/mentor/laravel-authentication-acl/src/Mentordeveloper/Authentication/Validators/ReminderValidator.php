<?php namespace Mentordeveloper\Authentication\Validators;

use Mentordeveloper\Library\Validators\OverrideConnectionValidator;

class ReminderValidator extends OverrideConnectionValidator
{
    protected static $rules = array(
        "password" => ["required", "min:6"],
    );
}