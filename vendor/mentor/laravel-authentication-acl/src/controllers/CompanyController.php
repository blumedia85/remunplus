<?php
namespace Mentordeveloper\Authentication\Controllers;

/**
 * Class UserController
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use Illuminate\Support\MessageBag;
use Mentordeveloper\Authentication\Exceptions\PermissionException;
use Mentordeveloper\Authentication\Exceptions\ProfileNotFoundException;
use Mentordeveloper\Authentication\Helpers\DbHelper;
use Mentordeveloper\Authentication\Models\UserProfile;
use Mentordeveloper\Authentication\Presenters\UserPresenter;
use Mentordeveloper\Authentication\Services\UserProfileService;
use Mentordeveloper\Authentication\Validators\UserProfileAvatarValidator;
use Mentordeveloper\Library\Exceptions\NotFoundException;
use Mentordeveloper\Library\Form\FormModel;
use Mentordeveloper\Authentication\Models\User;
use Mentordeveloper\Authentication\Models\Company;
use Mentordeveloper\Authentication\Helpers\FormHelper;
use Mentordeveloper\Authentication\Exceptions\UserNotFoundException;
use Mentordeveloper\Authentication\Validators\UserValidator;
use Mentordeveloper\Authentication\Validators\CompanyValidator;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;
use Mentordeveloper\Authentication\Validators\UserProfileValidator;
use View, Input, Redirect, App, Config, Controller;
use Mentordeveloper\Authentication\Interfaces\AuthenticateInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class CompanyController extends Controller {
/**
     * @var \Mentordeveloper\Authentication\Repository\SentryUserRepository
     */
    protected $user_repository;
    protected $company_repository;
    protected $user_validator;
    protected $company_validator;
    /**
     * @var \Mentordeveloper\Authentication\Helpers\FormHelper
     */
    protected $form_helper;
    protected $profile_repository;
    protected $profile_validator;
    /**
     * @var use Mentordeveloper\Authentication\Interfaces\AuthenticateInterface;
     */
    protected $auth;
    protected $register_service;
    protected $custom_profile_repository;
    public function __construct(UserValidator $v, CompanyValidator $c_v, FormHelper $fh, UserProfileValidator $vp, AuthenticateInterface $auth) {
        $this->company_repository = App::make('company_repository');
        $this->user_repository = App::make('user_repository');
        $this->user_validator = $v;
        $this->company_validator = $c_v;
        $this->c_f = App::make('form_model', [$this->company_validator, $this->company_repository]);
        $this->f = App::make('form_model', [$this->user_validator, $this->user_repository]);
        $this->form_helper = $fh;
        $this->profile_validator = $vp;
        $this->profile_repository = App::make('profile_repository');
        $this->auth = $auth;
        $this->register_service = App::make('register_service');
        $this->custom_profile_repository = App::make('custom_profile_repository');
    }
    public function getList(){
        $companys = $this->company_repository->all(Input::except(['page']));

        return View::make('laravel-authentication-acl::admin.company.list')->with(["users" => $companys]);

    }
    public function editCompany(){
        try
        {
            $user = $this->company_repository->find(Input::get('id'));
        } catch(MentordeveloperExceptionsInterface $e)
        {
            $user = new Company;
        }
        $presenter = new UserPresenter($user);

        return View::make('laravel-authentication-acl::admin.company.edit')->with(["user" => $user]);
    }
    public function postEditCompany()
    {
        $id = Input::get('id');
        DbHelper::startTransaction();
        try
        {
            print_r(Input::all());
            $company = $this->c_f->process(Input::all());
            print_r($company);
            exit;
            $user = $this->f->process(Input::all());
            $this->profile_repository->attachEmptyProfile($user);
        } catch(MentordeveloperExceptionsInterface $e)
        {
            DbHelper::rollback();
            $c_errors = $this->c_f->getErrors();
//            $errors = $this->f->getErrors();
            
            // passing the id incase fails editing an already existing item
            return Redirect::route("client.edit", $id ? ["id" => $id] : [])->withInput()->withErrors($c_errors);
        }

        DbHelper::commit();

        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@editUser', ["id" => $user->id])
                       ->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.user_edit_success'));
    }

    public function deleteCompany()
    {
        try
        {
            $this->f->delete(Input::all());
        } catch(MentordeveloperExceptionsInterface $e)
        {
            $errors = $this->f->getErrors();
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@getList')->withErrors($errors);
        }
        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@getList')
                       ->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.user_delete_success'));
    }

    public function editPermission()
    {
        // prepare input
        $input = Input::all();
        $operation = Input::get('operation');
        $this->form_helper->prepareSentryPermissionInput($input, $operation);
        $id = Input::get('id');

        try
        {
            $obj = $this->user_repository->update($id, $input);
        } catch(MentordeveloperExceptionsInterface $e)
        {
            return Redirect::route("users.edit")->withInput()
                           ->withErrors(new MessageBag(["permissions" => Config::get('laravel-authentication-acl::messages.flash.error.user_permission_not_found')]));
        }
        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@editUser', ["id" => $obj->id])
                       ->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.user_permission_add_success'));
    }

    public function editProfile()
    {
        $user_id = Input::get('user_id');

        try
        {
            $user_profile = $this->profile_repository->getFromUserId($user_id);
        } catch(UserNotFoundException $e)
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@getList')
                           ->withErrors(new MessageBag(['model' => Config::get('laravel-authentication-acl::messages.flash.error.user_user_not_found')]));
        } catch(ProfileNotFoundException $e)
        {
            $user_profile = new UserProfile(["user_id" => $user_id]);
        }
        $custom_profile_repo = App::make('custom_profile_repository', $user_profile->id);

        return View::make('laravel-authentication-acl::admin.user.profile')->with([
                                                                                          'user_profile'   => $user_profile,
                                                                                          "custom_profile" => $custom_profile_repo
                                                                                  ]);
    }

    public function postEditProfile()
    {
        $input = Input::all();
        $service = new UserProfileService($this->profile_validator);

        try
        {
            $service->processForm($input);
        } catch(MentordeveloperExceptionsInterface $e)
        {
            $errors = $service->getErrors();
            return Redirect::back()
                           ->withInput()
                           ->withErrors($errors);
        }
        return Redirect::back()
                       ->withInput()
                       ->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.user_profile_edit_success'));
    }

    public function editOwnProfile()
    {
        $logged_user = $this->auth->getLoggedUser();

        $custom_profile_repo = App::make('custom_profile_repository', $logged_user->user_profile()->first()->id);

        return View::make('laravel-authentication-acl::admin.user.self-profile')
                   ->with([
                                  "user_profile"   => $logged_user->user_profile()
                                                                  ->first(),
                                  "custom_profile" => $custom_profile_repo
                          ]);
    }

    public function signup()
    {
        $enable_captcha = Config::get('laravel-authentication-acl::captcha_signup');

        if($enable_captcha)
        {
            $captcha = App::make('captcha_validator');
            return View::make('laravel-authentication-acl::client.auth.signup')->with('captcha', $captcha);
        }

        return View::make('laravel-authentication-acl::client.auth.signup');
    }

    public function postSignup()
    {
        $service = App::make('register_service');

        try
        {
            $service->register(Input::all());
        } catch(MentordeveloperExceptionsInterface $e)
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@signup')->withErrors($service->getErrors())->withInput();
        }

        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@signupSuccess');
    }

    public function signupSuccess()
    {
        $email_confirmation_enabled = Config::get('laravel-authentication-acl::email_confirmation');
        return $email_confirmation_enabled ? View::make('laravel-authentication-acl::client.auth.signup-email-confirmation') : View::make('laravel-authentication-acl::client.auth.signup-success');
    }

    public function emailConfirmation()
    {
        $email = Input::get('email');
        $token = Input::get('token');

        try
        {
            $this->register_service->checkUserActivationCode($email, $token);
        } catch(MentordeveloperExceptionsInterface $e)
        {
            return View::make('laravel-authentication-acl::client.auth.email-confirmation')->withErrors($this->register_service->getErrors());
        }
        return View::make('laravel-authentication-acl::client.auth.email-confirmation');
    }

    public function addCustomFieldType()
    {
        $description = Input::get('description');
        $user_id = Input::get('user_id');

        try
        {
            $this->custom_profile_repository->addNewType($description);
        } catch(PermissionException $e)
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@postEditProfile', ["user_id" => $user_id])
                           ->withErrors(new MessageBag(["model" => $e->getMessage()]));
        }

        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@postEditProfile', ["user_id" => $user_id])
                       ->with('message', Config::get('laravel-authentication-acl::messages.flash.success.custom_field_added'));
    }

    public function deleteCustomFieldType()
    {
        $id = Input::get('id');
        $user_id = Input::get('user_id');

        try
        {
            $this->custom_profile_repository->deleteType($id);
        } catch(ModelNotFoundException $e)
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@postEditProfile', ["user_id" => $user_id])
                           ->withErrors(new MessageBag(["model" => Config::get('laravel-authentication-acl::messages.flash.error.custom_field_not_found')]));
        } catch(PermissionException $e)
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@postEditProfile', ["user_id" => $user_id])
                           ->withErrors(new MessageBag(["model" => $e->getMessage()]));
        }

        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@postEditProfile', ["user_id" => $user_id])
                       ->with('message', Config::get('laravel-authentication-acl::messages.flash.success.custom_field_removed'));
    }

    public function changeAvatar()
    {
        $user_id = Input::get('user_id');
        $profile_id = Input::get('user_profile_id');

        // validate input
        $validator = new UserProfileAvatarValidator();
        if(!$validator->validate(Input::all()))
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@editProfile', ['user_id' => $user_id])
                           ->withInput()->withErrors($validator->getErrors());
        }

        // change picture
        try
        {
            $this->profile_repository->updateAvatar($profile_id);
        } catch(NotFoundException $e)
        {
            return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@editProfile', ['user_id' => $user_id])->withInput()
                           ->withErrors(new MessageBag(['avatar' => Config::get('laravel-authentication-acl::messages.flash.error.')]));
        }

        return Redirect::action('Mentordeveloper\Authentication\Controllers\UserController@editProfile', ['user_id' => $user_id])
                       ->withMessage(Config::get('laravel-authentication-acl::messages.flash.success.avatar_edit_success'));
    }

    public function refreshCaptcha()
    {
        return View::make('laravel-authentication-acl::client.auth.captcha-image')
                   ->with(['captcha' => App::make('captcha_validator')]);
    }


}
