<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Crypt;
use DataTables;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the home page for regular users.
     */
    public function index()
    {
        $messages = Message::all();
        $users = User::all();
        return view('home', compact('messages', 'users'));
    }

    /**
     * Show the home page for administrators.
     */
    public function adminHome()
    {
        $messages = Message::all();
        $departments = Department::all()->toArray();
        $tree = $this->buildTree($departments);
        $users = User::all();

        return view('admin.aHome', compact('tree', 'messages', 'users'));
    }

    /**
     * Create the department tree.
     */
    protected function buildTree(array $elements, $parentId = null)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * Fetch the messages from the database.
     */
    public function getMessages()
    {
        $userId = auth()->user()->id;

        $messages = Message::where(function ($query) use ($userId) {
            $query->where('to_user_id', $userId)
                ->orWhere('from_user_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Decrypt the chat messages
        $messages->transform(function ($message) {
            $message->chat_message = Crypt::decrypt($message->chat_message);
            return $message;
        });

        $messages->load('fromUser:id,name', 'toUser:id,name');

        return response()->json(['messages' => $messages]);
    }


    /**
     * Send and store messages to the database.
     */
    public function sendMessage(Request $request)
    {
        $message = new Message();
        $message->to_user_id = $request->to_user_id;
        $message->from_user_id = auth()->user()->id;
        $message->chat_message = Crypt::encrypt($request->chat_message);
        $message->save();

        return response()->json(['success' => true]);
    }
}
