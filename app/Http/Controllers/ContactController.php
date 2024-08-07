<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::get();
        return view('contact.index', compact('contacts'));
    }

    public function store()
    {
        Contact::create(
            [
                'name' => 'david123'
            ]
        );
        return back();
    }
}
