<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    //
    public function index()
    {
        return view('auth.account.index');
    }

    public function editProfile()
    {
        return view('frontend.account.edit');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload Avatar
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('avatar')) {

            if ($user->avatar) {

                Storage::disk('public')
                    ->delete($user->avatar);
            }

            $avatar = $request
                ->file('avatar')
                ->store('avatars', 'public');

            $user->avatar = $avatar;
        }

        /*
        |--------------------------------------------------------------------------
        | Update User
        |--------------------------------------------------------------------------
        */

        $user->name = $request->name;

        $user->save();

        return redirect('/account')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
