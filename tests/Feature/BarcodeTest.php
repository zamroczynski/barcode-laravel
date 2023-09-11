<?php

namespace Tests\Feature;

use App\Models\Barcode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BarcodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_archive_page(): void
    {
        $response = $this->get('/archive');

        $response->assertStatus(200);
    }

    public function test_create_barcode(): void
    {
        $barcodeInput = '1234567890';

        $response = $this->post('/add', ['barcodeInput' => $barcodeInput]);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('barcodes', [
            'barcodeString' => $barcodeInput,
        ]);
        $barcode = Barcode::latest()->first();
        $this->assertEquals($barcodeInput, $barcode->barcodeString);
        $this->assertNotEmpty($barcode->pathToFile);
    }

    public function test_download_barcode(): void
    {
        Barcode::create([
            'id' => '9a1b8811-b826-46a5-920c-a5b5578f773c',
            'barcodeString' => '10101010010101',
            'pathToFile' => '',
        ])->createImage();

        $barcode = Barcode::latest()->first();

        $response = $this->get("/archive/{$barcode->id}");

        $response->assertStatus(200);
        $response->assertDownload($barcode->barcodeString . ".webp");
    }
}
