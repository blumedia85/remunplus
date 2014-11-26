<?php

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
