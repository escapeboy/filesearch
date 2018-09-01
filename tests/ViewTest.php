<?php
namespace FileSearch\Tests;
use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testRoute()
    {
        $response = $this->get(route('filesearch.index'));
        $response->assertStatus(200);
    }

    public function testSearch()
    {
        $response = $this->get(route('filesearch.index', ['q' => 'controller']));
        $response->assertStatus(200);
        $response->assertSeeText('RouteServiceProvider');
    }

    public function testNoResultsFound()
    {
        $response = $this->get(route('filesearch.index', ['q' => 'blqhblqh']));
        $response->assertStatus(200);
        $response->assertSeeText('No results found');
    }

    public function testEmptyQueryString()
    {
        $response = $this->get(route('filesearch.index', ['q' => '']));
        $response->assertStatus(500);
        $response->withException(new \Exception('No query specified.', 406));
    }
}
