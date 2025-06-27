<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VisitorController extends Controller
{
    // Set the visitor cookie and store the ID in the database
    public function setVisitorCookie(Request $request)
    {
        // Check if a visitor ID cookie exists
        $visitorId = $request->cookie('visitor_id');

        if (!$visitorId) {
            // If no visitor ID, generate a new one
            $visitorId = uniqid();

            // Save the visitor ID to the database
            Visitor::create(['visitor_id' => $visitorId]);

            // Set the visitor ID in the cookie for 30 days
            Cookie::queue('visitor_id', $visitorId, 43200); // 30 days in minutes
        }

        return response('Visitor cookie has been set.');
    }
}
