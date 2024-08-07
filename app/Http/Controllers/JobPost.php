<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobPost
{
    protected $listing;
    public function __construct(Listing $listing)
    {
        $this->listing = $listing;
    }
}
