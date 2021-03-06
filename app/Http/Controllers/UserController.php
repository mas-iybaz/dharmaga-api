<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->middleware('auth', ['except' => 'store']);
    }

    //
    public function index(Request $request)
    {
        $users = User::orderBy('created_at', 'desc')->when($request->q, function ($users) use ($request) {
            $users = $users->where('name', 'LIKE', '%' . $request->q . '%');
        })->paginate(5);

        return response()->json([
            'status' => 'SUCCESS',
            'data' => $users
        ], 200);
    }

    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'message' => 'SUCCESS',
            'data' => $user
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'identity_id' => 'required|string|unique:users',
            'gender' => 'required',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone_number' => 'required|string',
            'role' => 'required',
            'status' => 'required'
        ]);

        $filename = null;

        if ($request->hasFile('photo')) {
            $filename = Str::random(5) . $request->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filename);
        }

        User::create([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filename,
            'email' => $request->email,
            'password' => app('hash')->make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'SUCCESS',
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:50',
            'identity_id' => 'required|string|unique:users',
            'gender' => 'required',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'phone_number' => 'required|string',
            'role' => 'required',
            'status' => 'required'
        ]);

        $user = User::find($id);

        $filename = $user->photo;

        if ($request->hasFile('photo')) {
            $filename = Str::random(5) . $request->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images/'), $filename);

            unlink(base_path('public/images/' . $user->photo));
        }

        $user->update([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filename,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'SUCCESS'
        ], 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user->photo) {
            unlink(base_path('public/images/' . $user->photo));
        }

        $user->delete();

        return response()->json([
            'message' => 'SUCCESS'
        ], 200);
    }

    public function getUserLogin(Request $request)
    {
        return response()->json([
            'status' => 'SUCCESS',
            'data' => $request->user()
        ]);
    }
}
