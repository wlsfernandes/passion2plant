<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            abort(403, 'Spam detected.');
        }

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:150',
            'number' => 'nullable|string|max:30',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // Send email
        Mail::raw(
            "Name: {$validated['name']}\n".
            "Email: {$validated['email']}\n".
            "Phone: {$validated['number']}\n\n".
            "Message:\n{$validated['message']}",
            function ($mail) use ($validated) {
                $mail->to('wlsfernandes@gmail.com')
                     ->subject('New Contact Message from Passion2Plant Website')
                     ->replyTo($validated['email']);
            }
        );

        return back()->with('success', 'Message sent successfully.');
    }
}
