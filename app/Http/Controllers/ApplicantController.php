<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicantController extends Controller
{
    public function index()
    {
        $listings = Listing::latest()->withCount('users')->where("user_id", auth()->user()->id)->get();
        return view('applicants.index', compact('listings'));
    }

    public function show($slug)
    {
        $listing =  Listing::with('users')->where('slug', $slug)->first();
        return view('applicants.show', compact('listing'));
    }
    public function shortlist($listingId, $userId)
    {

        $listing = Listing::find($listingId);
        if ($listing) {
            $listing->users()->updateExistingPivot($userId, ['shortlisted' => true]);
            return back()->with('success', 'user is shortlisted successfully');
        }
        return back();
    }
}