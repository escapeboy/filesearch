<?php

namespace FileSearch\Tests;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FileSearchTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testNormal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('filesearch.index'))
                ->assertTitle('FileSearch');
            $browser->visit(route('filesearch.index'))
                ->type('q', 'controller')
                ->press('Search')
                ->pause(1000)
                ->assertQueryStringHas('q', 'controller')
                ->assertSee('app/Providers/RouteServiceProvider.php');
        });
    }

    public function testNotFound()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('filesearch.index'))
                ->type('q', 'blahbalh')
                ->press('Search')
                ->pause(1000)
                ->assertQueryStringHas('q', 'blahbalh')
                ->assertSee('No results found');
        });
    }
}
