<?php  namespace Mentordeveloper\Authentication\Controllers;
/**
 * Class PermissionController
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use Mentordeveloper\Library\Form\FormModel;
use Mentordeveloper\Authentication\Models\Permission;
use Mentordeveloper\Authentication\Validators\PermissionValidator;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;
use View, Input, Redirect, App, Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PermissionController extends \Controller
{
    /**
     * @var \Mentordeveloper\Authentication\Repository\PermissionGroupRepository
     */
    protected $r;
    /**
     * @var \Mentordeveloper\Authentication\Validators\PermissionValidator
     */
    protected $v;

    public function __construct(PermissionValidator $v)
    {
        $this->r = App::make('permission_repository');
        $this->v = $v;
        $this->f = new FormModel($this->v, $this->r);
    }

    public function getList()
    {
        $objs = $this->r->all();

        return View::make('laravel-authentication-acl::admin.permission.list')->with(["permissions" => $objs]);
    }

    public function editPermission()
    {
        try
        {
            $obj = $this->r->find(Input::get('id'));
        }
        catch(MentordeveloperExceptionsInterface $e)
        {
            $obj = new Permission;
        }

        return View::make('laravel-authentication-acl::admin.permission.edit')->with(["permission" => $obj]);
    }

    public function postEditPermission()
    {
        $id = Input::get('id');

        try
        {
            $obj = $this->f->process(Input::all());
        }
        catch(MentordeveloperExceptionsInterface $e)
        {
            $errors = $this->f->getErrors();
            // passing the id incase fails editing an already existing item
            return Redirect::route("permission.edit", $id ? ["id" => $id]: [])->withInput()->withErrors($errors);
        }

        return Redirect::action('Mentordeveloper\Authentication\Controllers\PermissionController@editPermission',["id" => $obj->id])->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.permission_permission_edit_success'));
    }

    public function deletePermission()
    {
        try
        {
            $this->f->delete(Input::all());
        }
        catch(MentordeveloperExceptionsInterface $e)
        {
            $errors = $this->f->getErrors();
            return Redirect::action('Mentordeveloper\Authentication\Controllers\PermissionController@getList')->withErrors($errors);
        }
        return Redirect::action('Mentordeveloper\Authentication\Controllers\PermissionController@getList')->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.permission_permission_delete_success'));
    }
} 