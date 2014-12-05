<?php 
namespace Mentordeveloper\Authentication\Models;
/**
 * Class Company
 *
 * @author mentor umair mentordeveloper@gmail.com
 */
use Cartalyst\Sentry\Company\Eloquent\Company as CartaCompany;
use Mentordeveloper\Library\Traits\OverrideConnectionTrait;
use Cartalyst\Sentry\Company\CompanyExistsException;


class Company extends BaseModel {

    use OverrideConnectionTrait;

    protected $fillable = ["username", "pass", "company_name","emp_name","emp_number","address","parish", "contact_number", "sub_start_date", "sub_end_date", "is_active"];

    protected $table = "clients";

    protected $guarded = ["id",'pass'];

    

}