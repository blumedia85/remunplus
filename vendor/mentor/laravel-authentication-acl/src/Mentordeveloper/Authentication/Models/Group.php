<?php  namespace Mentordeveloper\Authentication\Models;
/**
 * Class Group
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroup;
use Mentordeveloper\Library\Traits\OverrideConnectionTrait;

class Group extends SentryGroup
{
    use OverrideConnectionTrait;

    protected $guarded = ["id"];

    protected $fillable = ["name", "permissions", "protected"];
} 