<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\Parental_Link;


class GroupController extends Controller
{

    public function groups(Request $request){
        $groups = Group::allGroups();
        return view('animateur.groups', ['groups' => $groups]);
    }

    public function editGroup(Request $request){
        if(Group::getGroup($request->input('newName'))){
            return redirect()->route('groups');
        }
        $originalName = $request->input('originalName');
        $newName = $request->input('newName');
        $data = ['name'=>$newName];
        Group::createGroup($data);
        Parental_Link::updateGroupName($originalName, $newName);
        Group::deleteGroup($originalName);
        return redirect()->route('groups');
    }

    public function deleteGroup(Request $request){
        $originalName = $request->input('originalName');
        Parental_Link::updateGroupName($originalName, null);
        Group::deleteGroup($originalName);
        return redirect()->route('groups');
    }

    public function createGroup(Request $request)
{
    if(Group::getGroup($request->input('name'))){
        return redirect()->route('groups');
    }
    $validator = $request->validate([
        'name' => ['required', 'max:255'],
    ]);

    // If validation fails, it will automatically redirect back with errors.
    Group::createGroup($validator);
    return redirect()->route('groups');
}



}