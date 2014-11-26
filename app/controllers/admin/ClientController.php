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
use Mentordeveloper\Authentication\Helpers\FormHelper;
use Mentordeveloper\Authentication\Exceptions\UserNotFoundException;
use Mentordeveloper\Authentication\Validators\UserValidator;
use Mentordeveloper\Library\Exceptions\MentordeveloperExceptionsInterface;
use Mentordeveloper\Authentication\Validators\UserProfileValidator;
use View, Input, Redirect, App, Config, Controller;
use Mentordeveloper\Authentication\Interfaces\AuthenticateInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientController extends BaseController {

	/**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Grade Model
     * @var Grades
     */
    protected $grade;

    /**
     * Category Model
     * @var Categories
     */
    protected $category;

    /**
     * Inject the models.
     * @param User $user
     * @param Category $categor
     * @param Grades $grade
     */
    public function __construct(User $user, Grade $grade, Category $cate) {
        parent::__construct();
        $this->user = $user;
        $this->grade = $grade;
        $this->category = $cate;
    }


}
