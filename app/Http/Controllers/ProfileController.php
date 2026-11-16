<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_Details;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display profile creation form
     */
    public function getCreateProfile()
    {
        return view('profile.create-profile');
    }

    /**
     * Store a newly created profile (Admin only)
     */
    public function postCreateProfile(Request $request)
    {
        $validated = $request->validate([
            'UserID' => 'required|string|max:12|unique:user_details,UserID',
            'UserEmail' => 'required|email:rfc,filter|max:255|unique:user_details,UserEmail',
            'UserPassword' => 'required|string|min:8|max:64|confirmed',
            'UserRole' => 'required|in:Volunteer,Event Coordinator,Administrator',
            'UserFullName' => 'nullable|string|max:80',
            'UserDateOfBirth' => 'nullable|date',
            'UserGender' => 'nullable|in:Male,Female',
            'UserPhoneNumber' => 'nullable|string|max:20',
            'UserAddress' => 'nullable|string|max:300',
            'UserOccupation' => 'nullable|string|max:100',
            'UserTransport' => 'nullable|in:I have my own vehicle,I can arrange my own transport,I rely on public transport,I do not have reliable transportation',
            'UserShirtSize' => 'nullable|in:XS,S,M,L,XL,XXL',
            'UserDietaryRequirements' => 'nullable|string|max:200',
            'UserMedicalConditions' => 'nullable|string|max:300',
            'UserSkillsAndExperiences' => 'nullable|string',
        ]);

        // Hash the password before storing
        $validated['UserPassword'] = Hash::make($validated['UserPassword']);
        
        User_Details::create($validated);
        
        return redirect()->route('get-read-profile')->with('success', 'Profile created successfully!');
    }

    /**
     * Display list of volunteer's profile
     */
    public function getReadProfile(Request $request)
    {
        // Get current user's data or all users for administrators
        $userRole = session('user_role');
        
        if ($userRole === 'Administrator') {
            // Build query for administrators
            $query = User_Details::select([
                'UserID',
                'UserFullName',
                'UserDateOfBirth',
                'UserGender',
                'UserEmail',
                'UserPhoneNumber',
                'UserAddress',
                'UserOccupation',
                'UserTransport',
                'UserShirtSize',
                'UserDietaryRequirements',
                'UserMedicalConditions',
                'UserSkillsAndExperiences',
                'UserRole',
                'CreatedAt',
                'UpdatedAt'
            ]);
            
            // Handle search functionality
            if ($request->has('search') && !empty($request->search_user_id)) {
                $searchUserID = trim($request->search_user_id);
                $query->where('UserID', $searchUserID);
            }
            
            $users = $query->orderBy('UserFullName')->get();
            
            return view('profile.read-profile', compact('users'));
        }
    }

    /**
     * Display volunteer's profile form
     */
    public function getUpdateProfile($id = null)
    {
        $userRole = session('user_role');
        
        if ($userRole === 'Administrator' && $id) {
            // Administrator updating another user's profile
            $user = User_Details::find($id);
            if (!$user) {
                return redirect()->route('get-read-profile')->with('error', 'User not found.');
            }
        } else {
            // Regular user updating their own profile
            $userId = session('user_id');
            $user = User_Details::find($userId);
        }
        
        return view('profile.update-profile', compact('user'));
    }

    /**
     * Update volunteer's profile
     */
    public function putUpdateProfile(Request $request, $id = null)
    {
        $userRole = session('user_role');
        
        if ($userRole === 'Administrator' && $id) {
            // Administrator updating another user's profile
            $userId = $id;
        } else {
            // Regular user updating their own profile
            $userId = session('user_id');
        }
        
        $validationRules = [
            'UserFullName' => 'required|string|max:80',
            'UserDateOfBirth' => 'required|date',
            'UserGender' => 'required|in:Male,Female',
            'UserEmail' => 'required|email:rfc,filter|max:255|unique:user_details,UserEmail,' . $userId . ',UserID',
            'UserPhoneNumber' => 'required|string|max:20',
            'UserAddress' => 'required|string|max:300',
            'UserOccupation' => 'required|string|max:100',
            'UserTransport' => 'required|in:I have my own vehicle,I can arrange my own transport,I rely on public transport,I do not have reliable transportation',
            'UserShirtSize' => 'required|in:XS,S,M,L,XL,XXL',
            'UserDietaryRequirements' => 'nullable|string|max:200',
            'UserMedicalConditions' => 'nullable|string|max:300',
            'UserSkillsAndExperiences' => 'required|string',
        ];
        
        // Administrators may change the role of other users (never their own, to avoid locking themselves out)
        $canChangeRole = $userRole === 'Administrator' && $id && $id !== session('user_id');
        if ($canChangeRole) {
            $validationRules['UserRole'] = 'required|in:Volunteer,Event Coordinator,Administrator';
        }
        
        $validated = $request->validate($validationRules);

        $user = User_Details::find($userId);
        if (!$user) {
            return redirect()->route('get-read-profile')->with('error', 'User not found.');
        }
        
        $user->update($validated);

        if ($userRole === 'Administrator' && $id) {
            return redirect()->route('get-read-profile')->with('success', 'Profile updated successfully!');
        } else {
            return redirect()->route('get-update-profile')->with('success', 'Profile updated successfully!');
        }
    }

    /**
     * Display volunteer's profile deletion confirmation form
     */
    public function getDeleteProfile($id = null)
    {
        if ($id) {
            $user = User_Details::find($id);
            if (!$user) {
                return redirect()->route('get-read-profile')->with('error', 'User not found.');
            }
            return view('profile.delete-profile', compact('user'));
        }
        
        return view('profile.delete-profile');
    }

    /**
     * Delete volunteer's profile
     */
    public function deleteProfile($id)
    {
        $user = User_Details::find($id);
        
        if (!$user) {
            return redirect()->route('get-read-profile')->with('error', 'User not found.');
        }
        
        // Prevent deleting your own account
        if ($user->UserID === session('user_id')) {
            return redirect()->route('get-read-profile')->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('get-read-profile')->with('success', 'Profile deleted successfully!');
    }
}