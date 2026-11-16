<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event_Details;

class HomeController extends Controller
{
    /**
     * Display the home page with completed events
     */
    public function index()
    {
        // Get events from database
        $completedEvents = Event_Details::where('EventStatus', 'Completed')
                                       ->select('EventID', 'EventName', 'EventDescription', 'EventStartDate', 'EventEndDate', 'EventLocation')
                                       ->orderBy('EventStartDate', 'desc')
                                       ->get();
        
        return view('home', compact('completedEvents'));
    }
}