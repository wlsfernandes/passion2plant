<?php

namespace App\Http\Controllers;

use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderby('created_at', 'desc')->get();   // Code to list members

        return view('admin.members.index', compact('members'));
    }
}
