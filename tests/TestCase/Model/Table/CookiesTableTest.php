<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CookiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CookiesTable Test Case
 */
class CookiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CookiesTable
     */
    public $Cookies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cookies'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cookies') ? [] : ['className' => CookiesTable::class];
        $this->Cookies = TableRegistry::getTableLocator()->get('Cookies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cookies);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
