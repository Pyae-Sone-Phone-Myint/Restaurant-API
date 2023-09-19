<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserDetailResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function userLists()
    {
        if (Auth::user()->role->position !== "admin") {
            return response()->json([
                "message" => "You Are Not Allowed"
            ], 403);
        }

        $users = User::get();
        return UserDetailResource::collection($users);
    }

    public function userProfile()
    {
        $user = Auth::user();
        return new UserDetailResource($user);
    }

    public function checkUserProfile($id)
    {
        $user = User::find($id);
        Gate::authorize('admin-only');
        if (is_null($user)) {
            return response()->json([
                "error" => "User not found"
            ], 404);
        }

        return new UserDetailResource($user);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:20",
            "phone" => "nullable|min:8",
            "date_of_birth" => "nullable",
            "gender" => "required",
            "address" => "nullable",
            "email" => "email|required|unique:users",
            "password" => "required|confirmed|min:6",
            "role_id" => "required",
            'user_photo' => "nullable",
        ]);

        Gate::authorize("admin-only");

        $user = User::create([
            "name" => $request->name,
            "phone" => $request->phone,
            "date_of_birth" => $request->date_of_birth,
            "gender" => $request->gender,
            "address" => $request->address,
            'role_id' => $request->role_id,
            "banned" => false,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "user_photo" => $request->user_photo
        ]);


        return response()->json([
            "message" => "user register successfully",
            "data" => $user
        ]);
    }

    public function editYourProfile(Request $request)
    {
        $userId = Auth::id();
        return $this->editProfileService($request, $userId);
    }

    public function editProfile(Request $request, $id)
    {
        Gate::authorize('admin-only');
        return $this->editProfileService($request, $id);
    }

    public function banUser($id)
    {
        Gate::authorize("admin-only");
        $user = User::find($id);
        if ($user->role->position === 'admin') {
            return response()->json([
                "message" => "Don't be a fool. It will be okay!"
            ]);
        }
        $user->banned = true;
        $user->update();

        return response()->json(['message' => 'User has been banned']);
    }

    public function unBanUser($id)
    {
        Gate::authorize("admin-only");
        $user = User::find($id);
        if ($user->role->position === 'admin') {
            return response()->json([
                "message" => "Don't be a fool. It will be okay!"
            ]);
        }
        $user->banned = false;
        $user->update();

        return response()->json(['message' => 'User has been unbanned']);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "email|required",
            "password" => "required|min:6",
        ]);

        if (!Auth::attempt($request->only('email', "password"))) {
            return response()->json([
                "message" => "User Name or Password Wrong",
            ]);
        };

        $token = $request->user()->createToken($request->has("device") ? $request->device : 'unknown');

        return response()->json([
            "message" => "login successfully",
            "device_name" => $token->accessToken->name,
            "token" => $token->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "logout successful",
        ]);
    }

    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            "message" => "Logout All Successfully",
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', "current_password"],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Password Updated",
        ]);
    }

    // EDIT PROFILE REUSABLE FUNCTION
    public function editProfileService($request, $id)
    {
        $request->validate([
            "name" => "required|min:3|max:20",
            "phone" => "nullable|min:8",
            "date_of_birth" => "nullable",
            "address" => "nullable",
            'user_photo' => "nullable",
        ]);

        $user = User::find($id);
        if (is_null($user)) {
            return response()->json([
                "message" => "user not found"
            ], 404);
        }
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }
        if ($request->has('address')) {
            $user->address = $request->address;
        }
        if ($request->has('date_of_birth')) {
            $user->date_of_birth = $request->date_of_birth;
        }
        if ($request->has('gender')) {
            $user->gender = $request->gender;
        }
        if ($request->has('user_photo')) {
            $user->user_photo = $request->user_photo;
        }

        $user->update();

        return response()->json([
            "message" => "update user successfully",
            "data" => $user
        ]);
    }
}
