<?php  namespace Mentordeveloper\Authentication\Models;
/**
 * Class BaseModel
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use Illuminate\Database\Eloquent\Model;
use Mentordeveloper\Library\Traits\OverrideConnectionTrait;

class BaseModel extends Model
{
    use OverrideConnectionTrait;
} 