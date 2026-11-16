<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event_Participation;
use App\Models\Event_Feedback;
use App\Models\Event_Details;
use App\Models\User_Details;

class FeedbackController extends Controller
{
    /**
     * Display feedback form
     */
    public function getCreateFeedback()
    {
        $userId = session('user_id');
        $user = User_Details::find($userId);
        
        $completedEvents = collect();
        
        // Get events based on user role
        if ($user->UserRole === 'Event Coordinator' || $user->UserRole === 'Administrator') {
            // Get events that event coordinators coordinated
            $coordinatedEvents = Event_Details::where('CoordinatorID', $userId)
                ->where('EventStatus', 'Completed')
                ->whereDoesntHave('feedbacks', function($query) use ($userId) {
                    $query->where('UserID', $userId);
                })
                ->orderBy('EventStartDate', 'desc')
                ->get();
            
            $completedEvents = $completedEvents->merge($coordinatedEvents);
        }
        
        if ($user->UserRole === 'Volunteer' || $user->UserRole === 'Event Coordinator') {
            // Get events volunteers participated in
            $participatedEvents = Event_Details::whereHas('participations', function($query) use ($userId) {
                    $query->where('VolunteerID', $userId)
                          ->where('ApprovalStatus', 'Approved');
                })
                ->where('EventStatus', 'Completed')
                ->whereDoesntHave('feedbacks', function($query) use ($userId) {
                    $query->where('UserID', $userId);
                })
                ->orderBy('EventStartDate', 'desc')
                ->get();
            
            $completedEvents = $completedEvents->merge($participatedEvents);
        }
        
        // Remove duplicates in case event coordinator also volunteered for their own event
        $completedEvents = $completedEvents->unique('EventID');
        
        return view('feedback.create-feedback', compact('completedEvents'));
    }

    /**
     * Store feedback
     */
    public function postCreateFeedback(Request $request)
    {
        $userId = session('user_id');
        $user = User_Details::find($userId);
        
        $validated = $request->validate([
            'EventID' => 'required|integer|exists:event_details,EventID',
            'EventRating' => 'required|integer|min:1|max:5',
            'EventComments' => 'required|string|max:1000',
        ]);

        // Check if user can provide feedback for this event
        $canProvideFeedback = false;
        
        // Check if user coordinated this event
        if (in_array($user->UserRole, ['Event Coordinator', 'Administrator'])) {
            $coordinatedEvent = Event_Details::where('EventID', $validated['EventID'])
                ->where('CoordinatorID', $userId)
                ->first();
            
            if ($coordinatedEvent) {
                $canProvideFeedback = true;
            }
        }
        
        // Check if user participated in this event as volunteer
        if (in_array($user->UserRole, ['Volunteer', 'Event Coordinator'])) {
            $participation = Event_Participation::where('VolunteerID', $userId)
                ->where('EventID', $validated['EventID'])
                ->where('ApprovalStatus', 'Approved')
                ->first();
            
            if ($participation) {
                $canProvideFeedback = true;
            }
        }
        
        if (!$canProvideFeedback) {
            return redirect()->back()->with('error', 'You can only provide feedback for events you coordinated or participated in.');
        }

        // Check if feedback already exists
        $existingFeedback = Event_Feedback::where('UserID', $userId)
            ->where('EventID', $validated['EventID'])
            ->first();

        if ($existingFeedback) {
            return redirect()->back()->with('error', 'You have already provided feedback for this event.');
        }
        
        // Create feedback
        Event_Feedback::create([
            'UserID' => $userId,
            'EventID' => $validated['EventID'],
            'EventRating' => $validated['EventRating'],
            'EventComment' => $validated['EventComments'],
        ]);
        
        return redirect()->route('get-create-feedback')->with('success', 'Thank you for your feedback!');
    }

    /**
     * Display list of feedback records (Admin only)
     */
    public function getReadFeedback(Request $request)
    {
        // Build query for administrators
        $query = Event_Feedback::with(['user', 'event'])
            ->select([
                'FeedbackID',
                'UserID',
                'EventID',
                'EventRating',
                'EventComment',
                'CreatedAt',
                'UpdatedAt'
            ]);
        
        // Handle search functionality
        if ($request->has('search') && !empty($request->search_user_id)) {
            $searchUserID = trim($request->search_user_id);
            $query->where('UserID', $searchUserID);
        }
        
        // Order by FeedbackID ascending
        $feedbacks = $query->orderBy('FeedbackID', 'asc')->get();
        
        return view('feedback.read-feedback', compact('feedbacks'));
    }

    /**
     * Display feedback update form
     */
    public function getUpdateFeedback($feedbackId)
    {
        $feedback = Event_Feedback::with(['user', 'event'])->find($feedbackId);
        
        if (!$feedback) {
            return redirect()->route('get-read-feedback')->with('error', 'Feedback record not found.');
        }
        
        return view('feedback.update-feedback', compact('feedback'));
    }

    /**
     * Update feedback
     */
    public function putUpdateFeedback(Request $request, $feedbackId)
    {
        $validated = $request->validate([
            'EventRating' => 'required|integer|min:1|max:5',
            'EventComment' => 'required|string|max:1000',
        ]);

        $feedback = Event_Feedback::find($feedbackId);
        
        if (!$feedback) {
            return redirect()->route('get-read-feedback')->with('error', 'Feedback record not found.');
        }
        
        $feedback->update($validated);
        
        return redirect()->route('get-read-feedback')->with('success', 'Feedback updated successfully!');
    }

    /**
     * Display feedback deletion confirmation form
     */
    public function getDeleteFeedback($feedbackId)
    {
        $feedback = Event_Feedback::with(['user', 'event'])->find($feedbackId);
        
        if (!$feedback) {
            return redirect()->route('get-read-feedback')->with('error', 'Feedback record not found.');
        }
        
        return view('feedback.delete-feedback', compact('feedback'));
    }

    /**
     * Delete feedback
     */
    public function deleteFeedback($feedbackId)
    {
        $feedback = Event_Feedback::find($feedbackId);
        
        if (!$feedback) {
            return redirect()->route('get-read-feedback')->with('error', 'Feedback record not found.');
        }
        
        $feedback->delete();
        
        return redirect()->route('get-read-feedback')->with('success', 'Feedback deleted successfully!');
    }
}