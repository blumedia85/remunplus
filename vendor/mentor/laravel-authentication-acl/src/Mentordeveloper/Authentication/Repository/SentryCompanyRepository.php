<?php
namespace Mentordeveloper\Authentication\Repository;

/**
 * Class UserRepository
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use App;
use Cartalyst\Sentry\Users\UserExistsException as CartaUserExists;
use Cartalyst\Sentry\Users\UserNotFoundException;
use DateTime;
use Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Config;
use Mentordeveloper\Authentication\Exceptions\UserExistsException;
use Mentordeveloper\Authentication\Exceptions\UserNotFoundException as NotFoundException;
use Mentordeveloper\Authentication\Models\Group;
use Mentordeveloper\Authentication\Models\User;
use Mentordeveloper\Authentication\Models\Company;
use Mentordeveloper\Authentication\Repository\Interfaces\UserRepositoryInterface;
use Mentordeveloper\Authentication\Repository\Interfaces\CompanyRepositoryInterface;
use Mentordeveloper\Library\Repository\EloquentBaseRepository;

class SentryCompanyRepository extends EloquentBaseRepository implements CompanyRepositoryInterface
{
    /**
     * Sentry instance
     *
     * @var
     */
    protected $sentry;

    public function __construct()
    {
        $this->sentry = App::make('sentry');
        return parent::__construct(new Company);
    }

    /**
     * Create a new object
     *
     * @return mixed
     * @override
     */
    public function create(array $input)
    {
        $data = array(
                "username"     => $input["email"],
                "pass"  => $input["password"],
                "company_name"  => $input["c_name"],
                "emp_name"  => $input["emp_name"],
                "emp_number"  => $input["emp_number"],
                "address"  => $input["address"],
                "contact_number"  => $input["contact_number"],
                "parish"  => $input["parish"],
                "sub_start_date"  => $input["start_date"],
                "sub_end_date"  => $input["end_date"],
                "is_active"    => isset($input["is_active"]) ? $input["is_active"] : 0
        );

        try
        {
            $client = $this->sentry->createUser($data);
        } catch(CartaUserExists $e)
        {
            throw new CompanyExistsException;
        }

        return $client;
    }

    /**
     * Update a new object
     *
     * @param       id
     * @param array $data
     * @throws \Mentordeveloper\Authentication\Exceptions\UserNotFoundException
     * @return mixed
     * @override
     */
    public function update($id, array $data)
    {
        $this->ClearEmptyPassword($data);
        $obj = $this->find($id);
        Event::fire('repository.updating', [$obj]);
        $obj->update($data);
        return $obj;
    }

    /**
     * @override
     * @param array $input_filter
     * @return mixed
     */
    public function all(array $input_filter = [], $user_repository_search = null)
    {
        $per_page = Config::get('laravel-authentication-acl::users_per_page');
        $user_repository_search = $user_repository_search ? $user_repository_search : new UserRepositorySearchFilter($per_page);
        return $user_repository_search->all($input_filter);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function ClearEmptyPassword(array &$data)
    {
        if(empty($data["password"])) unset($data["password"]);
    }

    /**
     * Add a group to the user
     *
     * @param $id group id
     * @throws \Mentordeveloper\Authentication\Exceptions\UserNotFoundException
     */
    public function addGroup($user_id, $group_id)
    {
        try
        {
            $group = Group::findOrFail($group_id);
            $user = User::findOrFail($user_id);
            $user->addGroup($group);
        } catch(ModelNotFoundException $e)
        {
            throw new NotFoundException;
        }
    }

    /**
     * Remove a group to the user
     *
     * @param $id group id
     * @throws \Mentordeveloper\Authentication\Exceptions\UserNotFoundException
     */
    public function removeGroup($user_id, $group_id)
    {
        try
        {
            $group = Group::findOrFail($group_id);
            $user = User::findOrFail($user_id);
            $user->removeGroup($group);
        } catch(ModelNotFoundException $e)
        {
            throw new NotFoundException;
        }
    }

    /**
     * Activates a user
     *
     * @param string login_name
     * @return mixed
     * @throws \Mentordeveloper\Library\Exceptions\NotFoundException
     */
    public function activate($login_name)
    {
        $user = $this->findByLogin($login_name);

        $user->activation_code = null;
        $user->activated = true;
        $user->activated_at = new DateTime;
        return $user->save();
    }

    /**
     * @param $login_name
     * @throws \Mentordeveloper\Authentication\Exceptions\UserNotFoundException
     */
    public function findByLogin($login_name)
    {
        try
        {
            $user = $this->sentry->findUserByLogin($login_name);
        } catch(UserNotFoundException $e)
        {
            throw new NotFoundException;
        }

        return $user;
    }

    /**
     * Obtain a list of user from a given group
     *
     * @param String $group_name
     * @throws \Mentordeveloper\Authentication\Exceptions\UserNotFoundException
     * @return mixed
     */
    public function findFromGroupName($group_name)
    {
        $group = $this->sentry->findGroupByName($group_name);
        if(!$group) throw new UserNotFoundException;

        return $group->users;
    }
    /**
     * Obtain a list of users for specific Company
     *
     * @param String $clientID
     * @throws \Mentordeveloper\Authentication\Exceptions\UserNotFoundException
     * @return mixed
     */
    public function findFromClientID($clientID)
    {
        $group = $this->sentry->findGroupByName($clientID);
        if(!$group) throw new UserNotFoundException;

        return $group->users;
    }

    public function allModel()
    {
        return $this->model->all();
    }
}