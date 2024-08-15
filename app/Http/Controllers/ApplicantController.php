<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use App\Mail\ShortlistMail;
use Illuminate\Support\Facades\Mail;

class ApplicantController extends Controller
{
    public function index()
    {
        $listings = Listing::latest()->withCount('users')->where("user_id", auth()->user()->id)->get();
        return view('applicants.index', compact('listings'));
    }

    public function show($slug)
    {
        $this->authorize('view', $slug);
        if ($slug->user_id != auth()->id()) {
            abort(403);
        }
        $listing =  Listing::with('users')->where('slug', $slug)->first();
        return view('applicants.show', compact('listing'));
    }
    public function shortlist($listingId, $userId)
    {

        $listing = Listing::find($listingId);
        $user = User::find($userId);
        if ($listing) {
            $listing->users()->updateExistingPivot($userId, ['shortlisted' => true]);
            Mail::to($user->email)->queue(new ShortlistMail($user->name, $listing->title));

            return back()->with('success', 'user is shortlisted successfully');
        }
        return back();
    }
    public function apply($listingId)
    {
        $user = auth()->user();
        $user->listings()->syncWithoutDetaching($listingId);
        return back()->with('success', 'you have applied successfully');
    }
}