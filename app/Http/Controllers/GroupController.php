<?php

namespace App\Http\Controllers;

use App\Events\GroupCreated;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public function getGroup()
    {
        $groups = Auth::user()->groups;
        return response()->json($groups);
    }


    public function store(Request $request)
    {
        $group = Group::create(['name' => $request->get('name')]);

        $users = collect(request('users'));
        $users->push(auth()->user()->id);

        $group->users()->attach($users);


        broadcast(new GroupCreated($group))->toOthers();

        return response()->json($group);
    }

}
