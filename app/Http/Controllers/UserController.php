<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('office', 'division', 'unit', 'sector')->find(Auth::id());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $userId): \Illuminate\Http\JsonResponse
    {
        // TODO: Add Log entry for each change
        if($request->form_type == 'account_details') {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'middle_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'name_suffix' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Form validation error',
                    'code' => 'FAILED'
                ]);
            }

            $user = User::where('id', $userId)->first();
            $user->first_name = ucfirst(trim($request->first_name));
            $user->middle_name = ucfirst(trim($request->middle_name));
            $user->last_name = ucfirst(trim($request->last_name));
            if($request->name_suffix) {
                $user->suffix = ucfirst(trim($request->name_suffix));
            }
            $user->save();
            return response()->json([
                'message' => 'Account details successfully updated',
                'code' => 'SUCCESS',
            ]);
        } else if($request->form_type == 'account_username') {
            $validator = Validator::make($request->all(), [
                'new_username' => 'required|max:255',
                'confirm_username' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Form validation error',
                    'code' => 'FAILED'
                ]);
            }

            $user = User::where('id', $userId)->first();
            if ($request->new_username == $request->confirm_username) {
                $user->username = $request->new_username;
                $user->save();
                return response()->json([
                    'message' => 'Username successfully updated',
                    'code' => 'SUCCESS'
                ]);
            } else {
                return response()->json([
                    'message' => 'Username update failed',
                    'code' => 'FAILED',
                ]);
            }

        } else {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|max:255',
                'new_password' => 'required|max:255',
                'confirm_password' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Form validation error',
                    'code' => 'FAILED'
                ]);
            }

            if($request->confirm_password != $request->new_password) {
                return response()->json([
                    'message' => 'Password update failed, password confirmation and new password do not match',
                    'code' => 'FAILED'
                ]);
            }

            $user = User::where('id', $userId)->first();
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return response()->json([
                    'message' => 'Password successfully updated',
                    'code' => 'SUCCESS'
                ]);
            }else {
                return response()->json([
                    'message' => 'Password update failed',
                    'code' => 'FAILED'
                ]);
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
