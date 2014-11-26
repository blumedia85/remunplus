<?php  namespace Mentordeveloper\Library\Tests;

use Mentordeveloper\Library\Traits\ConnectionTrait;

/**
 * Test ConnectionTraitTest
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
class ConnectionTraitTest extends TestCase {

  protected $connection_helper;

  public function setUp()
  {
    parent::setUp();
    $this->connection_helper = new ConnectionTraitStub();
  }

  /**
   * @test
   **/
  public function itReturnTestinConnectionNameOnTesting()
  {
    $this->assertEquals($this->connection_helper->getConnectionName(), 'testbench');
  }

  /**
   * @test
   **/
  public function itReturnAuthenticationOnOtherEnv()
  {
    $this->app['env'] = 'production';
    $this->assertEquals($this->connection_helper->getConnectionName(), 'authentication');
  }
}

class ConnectionTraitStub
{
  use ConnectionTrait;
}
 