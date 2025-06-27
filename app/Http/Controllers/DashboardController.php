<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; // Make sure to import the correct Cookie facade

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check if the 'visitor_id' cookie exists
        $visitorId = $request->cookie('visitor_id');

        if (!$visitorId) {
            // If no visitor ID, generate a new one
            $visitorId = uniqid();

            // Save the visitor ID to the database
            Visitor::create(['visitor_id' => $visitorId]);

            // Set the visitor ID in the cookie for 30 days
            Cookie::queue('visitor_id', $visitorId, 43200); // 30 days in minutes
        }

        // Count total visitors in the database
        $visitorCount = Visitor::count();

        // Return the view with visitor count data
        return view('admin.dashboard', compact('visitorCount'));
    }
}

?>
