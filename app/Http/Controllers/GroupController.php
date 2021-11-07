<?php

namespace App\Http\Controllers;

use App\Group;
use App\GroupUser;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        //create New Group
        $group_name = $request->group_name;
        $checkVal[] = $request->checkVal;
        $description = $request->description;

        $group = new Group();
        $group->group_name = $group_name;
        $group->description = $description;
        $group->save();

        $groupuser = new GroupUser();
        $groupuser->group_id = $group->id;
        $groupuser->user_id = Auth::id();
        $groupuser->save();

        //create Group users
        foreach ($request->input('checkVal') as $role) {
            $groupuser = new GroupUser();
            $groupuser->group_id = $group->id;
            $groupuser->user_id = $role;
            $groupuser->save();
        }
        
        $user_id = Auth::id();
        $groupdata = Group::with(['users' => function($qq) use($user_id){
                $qq->select('group_id', 'is_read')->where('user_id', $user_id);
            }])->whereHas('groupUsers', function($qr) use($user_id){
                $qr->where('user_id', '=', $user_id);
            })->orderBy('id', 'desc')->get();

        return [
            'groupdata' => view('layouts.chat-group-list')->with(['groupdata' => $groupdata])->render()
        ];
    }

    // Group data get from Group chat list
    public function getGroupMessage($group_id)
    {
        GroupUser::where(['group_id' => $group_id, 'user_id' => Auth::id()])->update(['is_read' => 0]);
        // Get all Group Messages
        $messages = Conversation::where('group_id', '=', $group_id)->get();
        // Get all Group Name data 
        $user_id = Auth::id();
        $groupdata = Group::whereHas('groupUsers', function($qr) use($user_id){
            $qr->where('user_id', '=', $user_id);
        })->where('id', '=', $group_id)->first();

        // Get all Group User data
        $userdata = DB::table('group_users')
                    ->join('users', 'group_users.user_id', '=', 'users.id')
                    ->select('group_users.user_id', 'users.id', 'users.name', 'users.avatar')
                    ->where('group_users.group_id', '=', $group_id)->get();

        return [
            'view1' => view('layouts.group-message-data')->with(['messages' => $messages])->with(['groupdata' => $groupdata])->with(['userdata' => $userdata])->render(),
            'view2' => view('layouts.group-profile-details')->with(['messages' => $messages])->with(['groupdata' => $groupdata])->with(['userdata' => $userdata])->render()
        ];
    }

    public function getGroupLastMessage($group_id)
    {
        GroupUser::where(['group_id' => $group_id, 'user_id' => Auth::id()])->update(['is_read' => 0]);
        // Get all Group Messages
        $messages = Conversation::where('group_id', '=', $group_id)->orderBy('id', 'DESC')->limit(1)->get();
        // Get all Group User data
        $userdata = DB::table('group_users')->join('users', 'group_users.user_id', '=', 'users.id')->select('group_users.user_id', 'users.id', 'users.name', 'users.avatar')
            ->where('group_users.group_id', '=', $group_id)->get();
        return view('layouts.group-conversation')->with(['messages' => $messages])->with(['userdata' => $userdata]);
    }

    public function sendGroupMessage(Request $request)
    {
        $from_user_id = Auth::id();
        $group_id = $request->group_id;
        $message = $request->message;
        $file = $request->file;
        
        $data = new Conversation();
        $data->from_user_id = $from_user_id;
        $data->group_id = $group_id;
        $data->message = $message;
        if ($file != Null) {
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filepath = public_path('/Upload/');
            $file->move($filepath, $filename);
            $data->file = 'Upload/' . $filename;
        }
        $data->save();

        // Make read all unread message
        DB::table('group_users')
            ->where('group_users.group_id', '=', $group_id)
            ->where('group_users.user_id', '!=', $from_user_id)
            ->update(['group_users.is_read' => DB::raw('group_users.is_read + 1')]);

        // pusher
        $options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $userdata = DB::table('group_users')->join('users', 'group_users.user_id', '=', 'users.id')
            ->select('users.id')
            ->where('group_users.group_id', '=', $group_id)->get();
        $data = ['from_user_id' => $from_user_id, 'group_users' => $userdata, 'group_id' => $group_id]; // sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-group', $data);
        return $data;
    }

    // Group name search
    public function groupsearch(Request $request)
    {
        if ($request->ajax()) { 
            $user_id = Auth::id();
            $groupdata = Group::with(['users' => function($qq) use($user_id){
                $qq->select('group_id', 'is_read')->where('user_id', $user_id);
            }])->whereHas('groupUsers', function($qr) use($user_id){
                $qr->where('user_id', '=', $user_id);
            })->get(); 

            $htmldata = view('layouts.chat-group-list')->with('groupdata', $groupdata)->render();
            return Response($htmldata);
        }
    }

    // Group Message Delete
    public function deletegroupmessage($id)
    {
        Conversation::where('id', $id)->delete();
    }

    // Group Conversation Delete
    public function deleteGroupConversation($group_id)
    {
        $messages = Conversation::where('group_id', '=', $group_id)->delete();
    }

    // Group Messages search
    public function groupmessagesearch(Request $request)
    {
        if ($request->ajax()) {
            $messages = Conversation::where('message', 'LIKE', '%' . $request->search . "%")->get();
            // Get all Group User data
            $userdata = DB::table('group_users')->join('users', 'group_users.user_id', '=', 'users.id')
                ->select('group_users.user_id', 'users.id', 'users.name', 'users.avatar')
                ->where('group_users.group_id', '=', $request->groupid)->get();

            $htmldata = view('layouts.group-conversation')->with(['messages' => $messages])->with(['userdata' => $userdata])->render();
            return Response($htmldata);
        }
    }
}
