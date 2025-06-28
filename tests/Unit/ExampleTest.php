<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $this->assertTrue(true);
    }

    // Anda bisa tambahkan test lain, misalnya untuk logika aplikasi sederhana
    public function test_addition_function()
    {
        $this->assertEquals(4, 2 + 2);
    }
}