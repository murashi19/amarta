<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
     public function send(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'nullable|string',
            'subjek' => 'required|string',
            'pesan' => 'required|string',
        ]);

        Mail::raw("
        Nama   : {$data['nama']}
        Email  : {$data['email']}
        Telepon: {$data['telepon']}
        Subjek : {$data['subjek']}

        Pesan:
        {$data['pesan']}
        ", function ($message) use ($data) {
            $message->to('trianapahmi@gmail.com') // ganti ke email tujuanmu
                    ->subject("Pesan Baru dari {$data['nama']}");
        });

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
