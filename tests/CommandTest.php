<?php
namespace FileSearch\Tests;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
class CommandTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCommandWorking()
    {
        Artisan::call('search', [
            'query' => 'controller',
            '--path' => 'app',
        ]);

        $this->assertContains( 'Controller.php', trim(Artisan::output()));
    }
}
