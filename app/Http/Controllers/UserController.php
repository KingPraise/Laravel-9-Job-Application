<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\RegistrationFormRequest;


class UserController extends Controller
{
    const JOB_SEEKER = 'seeker';
    const JOB_POSTER = 'employer';
    public function createSeeker()
    {
        return view('user.seeker-register');
    }
    public function createEmployer()
    {
        return view('user.employer-register');
    }

    public function storeSeeker(RegistrationFormRequest $request)
    {

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_SEEKER
        ]);

        // $user->sendEmailVerificationNotification();
        return response()->json('success');

        // return redirect()->route('login')->with('successMessage', 'Your Account was Created');
    }

    public function storeEmployer(RegistrationFormRequest $request)
    {

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'user_type' => self::JOB_POSTER,
            'user_trial' => now()->addWeek()
        ]);
        // $user->sendEmailVerificationNotification();
        return response()->json('success');

        // return redirect()->route('login')->with('successMessage', 'Your Account was Created');
    }

    public function login()
    {
        return view('user.login');
    }

    public  function postLogin(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'

        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->user_type == 'employer') {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/');
            }
        }
        return "Wrong Email or Password";
    }

    public  function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function jobApplied()
    {
        $users = User::with('listings')->where('id', auth()->user()->id)->get();
        return view('seeker.job-applied', compact('users'));
    }




    public function changePassword(Request $request)
    {
        // Validate the request
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Get the authenticated user
        $user = Auth::user();
        if (!$user) {
            return back()->with('error', 'User not authenticated');
        }

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your password has been updated successfully');
    }



    public function uploadResume(Request $request)
    {
        $this->validate($request, [
            "resume" => 'required|mimes:pdf,doc,docx',
        ]);
        if ($request->hasFile('resume')) {
            $resume = $request->file('resume')->store('resume', 'public');

            User::find(auth()->user()->id)->update(['resume' => $resume]);
            return back()->with('success', "Your Resume has been uploaded");
        }
    }





    public function profile()
    {
        return view('profile.index');
    }

    public function seekerProfile()
    {
        return view('seeker.profile');
    }

    public function update(Request $request)
    {

        // dd($request->all());


        if ($request->hasFile('profile_pic')) {
            // dd($request->hasFile('profile_pic'));
            $imagepath = $request->file('profile_pic')->store('profile', "public");

            User::find(auth()->user()->id)->update(['profile_pic' => $imagepath]);
        }
        User::find(auth()->user()->id)->update($request->except('profile_pic'));

        return back()->with('success', "Your Profile has been updated");
    }
}