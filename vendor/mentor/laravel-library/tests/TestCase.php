<?php namespace Mentordeveloper\Library\Tests;
/**
 * Test TestCase
 *
 * @author mentor beschi mentor@mentorbeschi.com
 */
class TestCase extends \Orchestra\Testbench\TestCase  {

    public function setUp()
    {
        parent::setUp();
    }

    protected function getPackageProviders()
    {
        return [
            'Mentordeveloper\Library\LibraryServiceProvider',
        ];
    }

    protected function getPackageAliases()
    {
        return [
        ];
    }

    /**
     * @test
     **/
    public function dummy()
    {

    }
}