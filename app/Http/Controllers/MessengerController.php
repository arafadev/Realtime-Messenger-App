<?php

namespace App\Http\Controllers;

use view;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    public function index()
    {
        return view('messenger.index');
    }

    function search(Request $request)
    {

        $getRecords = null;
        $input = $request['query'];
        $records = User::where('id', '!=', Auth::user()->id)
            ->where('name', 'LIKE', '%' . $input . '%')
            ->orWhere('name', 'LIKE', '%' . $input . '%')
            ->paginate(10);

        if ($records->total() < 1) {
            $getRecords .= "<p class='text-center'>Noting to show.</p>";
        }

        foreach ($records as $record) {

            $getRecords .= view('messenger.components.search-item', compact('record'))->render();
        }

        return response()->json(
            [
                'records' => $getRecords,
                'last_page' => $records->lastPage()
            ]
        );

    }


    function fetchIdInfo(Request $request)
    {

        $fetch = User::where('id', $request['id'])->first();
        return response()->json([
            'fetch' => $fetch
        ]);
    }

    function sendMessage(Request $request)
    {
        dd($request->all());
      
    }

}
