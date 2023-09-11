<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Barcode;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BarcodeController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'barcodeInput' => 'required|max:255|min:1',
        ]);
        Barcode::create([
            'barcodeString' => $request->barcodeInput,
            'pathToFile' => '',
        ])->createImage();

        return redirect('/')->with('status', 'Sukcess!');
    }

    public function archive(): View
    {
        return view('archives', ['barcodes' => Barcode::latest()->get()]);
    }

    public function show(Barcode $barcode): StreamedResponse
    {
        return Storage::download("barcode/{$barcode->id}/barcode.webp", $barcode->barcodeString . ".webp");
    }
}
