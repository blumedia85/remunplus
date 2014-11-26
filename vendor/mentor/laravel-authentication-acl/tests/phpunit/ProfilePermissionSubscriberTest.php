<?php  namespace Mentordeveloper\Authentication\Tests\Unit;
use Mentordeveloper\Authentication\Classes\CustomProfile\Events\ProfilePermissionSubscriber;
use Mockery as m;
use App;
/**
 * Test ProfilePermissionSubscriberTest
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
class ProfilePermissionSubscriberTest extends TestCase {

    public function tearDown()
    {
        m::close();
    }

    /**
     * @test
     **/
    public function checkIfHasProfileTypePermission()
    {
        $has_edit_profile_permssion = m::mock('StdClass')
                ->shouldReceive('checkCustomProfileEditPermission')
                ->andReturn(true)
                ->getMock();
        App::instance('authentication_helper', $has_edit_profile_permssion);

        $subscriber = new ProfilePermissionSubscriber();
        $subscriber->checkProfileTypePermission();
    }

    /**
     * @test
     * @expectedException \Mentordeveloper\Authentication\Exceptions\PermissionException
     **/
    public function throwsExceptionIfTypePermissionFails()
    {
        $subscriber = new ProfilePermissionSubscriber();

        $subscriber->checkProfileTypePermission();
    }

}
 