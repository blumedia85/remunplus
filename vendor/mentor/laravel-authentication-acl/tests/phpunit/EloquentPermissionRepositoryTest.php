<?php  namespace Mentordeveloper\Authentication\Tests\Unit;

/**
 * Test PermissionRepositoryTest
 *
 * @author mentor beschi mentordeveloper@gmail.com
 */
use Mentordeveloper\Authentication\Models\User;
use Mockery as m;
use App, Event, DB;
use Mentordeveloper\Authentication\Models\Permission;
use Mentordeveloper\Authentication\Repository\EloquentPermissionRepository as PermissionRepository;

class EloquentPermissionRepositoryTest extends DbTestCase {

    protected $faker;

    public function setUp()
    {
        parent::setUp();
        $active = 1;
        $this->createUserWithPerm(["_perm" => $active]);
        $group_class = 'Mentordeveloper\Authentication\Models\Group';
        $this->make($group_class, $this->getModelGroupStub());
    }

    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     **/
    public function checkIfPermissionIsNotAssociatedToGroup()
    {
        $perm_repo = new PermissionRepository();
        $permission_obj = new Permission(["description" => "desc", "permission" => []]);
        $perm_repo->checkIsNotAssociatedToAnyGroup($permission_obj);
    }

    /**
     * @test
     * @expectedException \Mentordeveloper\Authentication\Exceptions\PermissionException
     **/
    public function IfAssociatedToGroupThrowsException()
    {
        $perm_repo = new PermissionRepository();
        $permission_obj = new Permission(["description" => "desc", "permission" => "_perm"]);
        $perm_repo->checkIsNotAssociatedToAnyGroup($permission_obj);
    }

    /**
     * @test
     **/
    public function checkIfUserIsNotAssociatedToUser()
    {
        $perm_repo = new PermissionRepository();
        $permission_obj = new Permission(["description" => "desc", "permission" => []]);
        $perm_repo->checkIsNotAssociatedToAnyUser($permission_obj);
    }

    /**
     * @test
     * @expectedException \Mentordeveloper\Authentication\Exceptions\PermissionException
     **/
    public function ifAssociatedToUserThrowsException()
    {
        $perm_repo = new PermissionRepository();
        $permission_obj = new Permission(["description" => "desc", "permission" => "_perm" ]);
        $perm_repo->checkIsNotAssociatedToAnyUser($permission_obj);
    }

    /**
     * @test
     **/
    public function validateThatPermissionIsNotAssociatedToAnyGroupAndAnyUser_OnRepositoryUpdate()
    {
        $false_stub = new FalseGetterStub;
        Event::fire('repository.updating', [$false_stub]);
    }

    /**
     * @test
     **/
    public function validateThatPermissionIsNotAssociatedToAnyGroupAndAnyUser_OnRepositoryDelete()
    {
        $false_stub = new FalseGetterStub;
        Event::fire('repository.deleting', [$false_stub]);
    }

    protected function getModelGroupStub()
    {
        return [
            "name" => $this->faker->name(),
            "permissions" => ["_perm" => "1"]
        ];
    }

    protected function getModelStub()
    {
        // we merge this with the other methods
        return [];
    }

    private function createUserWithPerm(array $perm)
    {
        DB::table('users')->insert([
                                   "email"      => $this->faker->email(),
                                   "password"   => $this->faker->text(10), "activated" => 1,
                                   "permissions" => json_encode($perm),
                                   "created_at" => $this->getNowDateTime(), "updated_at" => $this->getNowDateTime()
                                   ]);
        return User::first();
    }
}

class FalseGetterStub
{
    public function __get($key)
    {
        return false;
    }
}