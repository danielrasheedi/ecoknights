<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event_Participation;
use App\Models\Event_Details;
use App\Models\User_Details;

class VolunteerController extends Controller
{
    /**
     * Display list of upcoming volunteer events
     */
    public function getCreateVolunteer()
    {
        // Query upcoming events with coordinator relationship
        $upcomingEvents = Event_Details::where('EventStatus', 'Upcoming')
                                      ->with('coordinator')
                                      ->withCount(['participations as approved_count' => function ($query) {
                                          $query->where('ApprovalStatus', 'Approved');
                                      }])
                                      ->orderBy('EventStartDate', 'asc')
                                      ->get();
        
        return view('volunteer.create-volunteer', compact('upcomingEvents'));
    }

    /**
     * Sign up volunteer for an event
     */
    public function postCreateVolunteer(Request $request, $eventId)
    {
        $userId = session('user_id');
        
        // Get user details to check profile completeness
        $user = User_Details::find($userId);

        // Event coordinators are assigned to events by administrators
        if ($user->UserRole === 'Event Coordinator') {
            return redirect()->back()->with('error', 'Event coordinators are assigned to events by administrators.');
        }

        // Event must exist and still be open for registration
        $event = Event_Details::where('EventID', $eventId)
                              ->where('EventStatus', 'Upcoming')
                              ->first();

        if (!$event) {
            return redirect()->back()->with('error', 'This event is not available for registration.');
        }

        // Enforce the volunteer limit
        if ($event->MaxVolunteers) {
            $approvedCount = $event->participations()->where('ApprovalStatus', 'Approved')->count();
            if ($approvedCount >= $event->MaxVolunteers) {
                return redirect()->back()->with('error', 'Registration is closed for this event.');
            }
        }

        // Check if profile is complete excluding dietary requirements and medical conditions
        if (!$this->isProfileComplete($user)) {
            return redirect()->route('get-update-profile')->with('error', 'Please fill up all required fields before signing up for events.');
        }
        
        // Check if user is already signed up for this event
        $existingParticipation = Event_Participation::where('VolunteerID', $userId)
                                                   ->where('EventID', $eventId)
                                                   ->first();
        
        if ($existingParticipation) {
            return redirect()->back()->with('error', 'You are already signed up for the event.');
        }
        
        // Create new participation record
        Event_Participation::create([
            'VolunteerID' => $userId,
            'EventID' => $event->EventID,
            'ApprovalStatus' => 'Pending'
        ]);
        
        return redirect()->back()->with('success', 'Thanks for signing up. We have received your registration and it is now pending approval.');
    }

    /**
     * Display list of volunteer participations (Admin only)
     */
    public function getReadVolunteer(Request $request)
    {
        // Build query for administrators
        $query = Event_Participation::with(['volunteer', 'event'])
            ->select([
                'ParticipationID',
                'VolunteerID',
                'EventID',
                'EventRole',
                'ApprovalStatus',
                'AttendanceStatus',
                'CreatedAt',
                'UpdatedAt'
            ]);
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search_volunteer_id)) {
            $searchVolunteerID = trim($request->search_volunteer_id);
            $query->where('VolunteerID', $searchVolunteerID);
        }
        
        // Order by ParticipationID ascending
        $participations = $query->orderBy('ParticipationID', 'asc')->get();
        
        return view('volunteer.read-volunteer', compact('participations'));
    }

    /**
     * Display volunteer participation update form
     */
    public function getUpdateVolunteer($participationId)
    {
        $participation = Event_Participation::with(['volunteer', 'event'])->find($participationId);
        
        if (!$participation) {
            return redirect()->route('get-read-volunteer')->with('error', 'Participation record not found.');
        }
        
        return view('volunteer.update-volunteer', compact('participation'));
    }

    /**
     * Update volunteer participation
     */
    public function putUpdateVolunteer(Request $request, $participationId)
    {
        $validated = $request->validate([
            'EventRole' => 'nullable|string|max:100',
            'ApprovalStatus' => 'required|in:Pending,Approved,Rejected',
            'AttendanceStatus' => 'nullable|in:Attended,Absent',
        ]);

        $participation = Event_Participation::find($participationId);
        
        if (!$participation) {
            return redirect()->route('get-read-volunteer')->with('error', 'Participation record not found.');
        }
        
        $participation->update($validated);
        
        return redirect()->route('get-read-volunteer')->with('success', 'Volunteer participation updated successfully!');
    }

    /**
     * Display volunteer participation deletion confirmation form
     */
    public function getDeleteVolunteer($participationId)
    {
        $participation = Event_Participation::with(['volunteer', 'event'])->find($participationId);
        
        if (!$participation) {
            return redirect()->route('get-read-volunteer')->with('error', 'Participation record not found.');
        }
        
        return view('volunteer.delete-volunteer', compact('participation'));
    }

    /**
     * Delete volunteer participation
     */
    public function deleteVolunteer($participationId)
    {
        $participation = Event_Participation::find($participationId);
        
        if (!$participation) {
            return redirect()->route('get-read-volunteer')->with('error', 'Participation record not found.');
        }
        
        $participation->delete();
        
        return redirect()->route('get-read-volunteer')->with('success', 'Volunteer participation deleted successfully!');
    }

    /**
     * Check if user profile is complete
     */
    private function isProfileComplete($user)
    {
        // Required fields (excluding UserDietaryRequirements and UserMedicalConditions)
        $requiredFields = [
            'UserFullName',
            'UserDateOfBirth', 
            'UserGender',
            'UserEmail',
            'UserPhoneNumber',
            'UserAddress',
            'UserOccupation',
            'UserTransport',
            'UserShirtSize',
            'UserSkillsAndExperiences'
        ];
        
        foreach ($requiredFields as $field) {
            if (empty($user->$field)) {
                return false;
            }
        }
        
        return true;
    }
}