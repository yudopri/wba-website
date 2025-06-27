<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    public function testHalamanUtama()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Selamat Datang')
                    ->screenshot('halaman-utama');
        });
    }
}
