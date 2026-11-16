<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\User_Details;

class AdministratorOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in first
        if (!$request->session()->has('user_id')) {
            return redirect()->route('get-log-in')->with('error', 'Please login first.');
        }

        // Get user details to check role
        $userId = $request->session()->get('user_id');
        $user = User_Details::find($userId);
        
        if (!$user || $user->UserRole !== 'Administrator') {
            return redirect()->route('home')->with('error', 'Administrator access required.');
        }
        
        return $next($request);
    }
}
