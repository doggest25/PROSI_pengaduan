<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactFormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);
    
        $contactForm = ContactForm::create($request->all());
    
        // Kirim email ke pengguna
        Mail::to($request->email)->send(new \App\Mail\ContactFormSubmitted($contactForm));
    
        return with('success', 'Message sent successfully!');
    
    }
}
