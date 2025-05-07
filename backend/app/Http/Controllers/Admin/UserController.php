<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the list of users
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index')->with([
            'users' => $users
        ]);
    }

    /**
     * Delete users
     */
    public function delete(User $user)
    {
        //check if the profile image exists and remove it
        if(File::exists(public_path($user->profile_image))) {
            File::delete(public_path($user->profile_image));
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with([
            'success' => 'User has been deleted successfully'
        ]);
    }
}
