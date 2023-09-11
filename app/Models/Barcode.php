<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Barcode extends Model
{
    use HasUuids;

    protected $fillable = [
        'barcodeString',
        'pathToFile'
    ];

    public function createImage(): Void
    {
        $now = Carbon::now();
        $this->pathToFile = "barcode/{$this->id}/barcode";

        $generator = new BarcodeGeneratorPNG();
        $generator->useGd();
        $imagePng = $generator->getBarcode($this->barcodeString, $generator::TYPE_CODE_128);

        Storage::put("{$this->pathToFile}.png", $imagePng);

        $this->convertPngToWebP();

        $this->pathToFile = "barcode/{$this->id}/barcode.webp";

        $this->save();
    }

    private function convertPngToWebP(): Void
    {
        $image = imagecreatefrompng(storage_path("app/{$this->pathToFile}.png"));
        $w = imagesx($image);
        $h = imagesy($image);
        $im = imagecreatetruecolor($w, $h);
        imagealphablending($im, false);
        imagesavealpha($im, true);
        $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
        imagefilledrectangle($im, 0, 0, $w - 1, $h - 1, $trans);
        imagecopy($im, $image, 0, 0, 0, 0, $w, $h);
        imagewebp($im, storage_path("app/{$this->pathToFile}.webp"), 100);
        imagedestroy($image);
        imagedestroy($im);
        Storage::delete("{$this->pathToFile}.png");
    }
}
