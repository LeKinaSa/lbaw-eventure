<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\File;
use App\Policies\FilePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller {
    public static function validator(Request $request) {
        return Validator::make($request->all(), [
            'file' => 'file|max:5000',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        $event = Event::find($id);
        if (is_null($event)) {
            return response('Event with the specified ID does not exist.', 404);
        }

        if (!FilePolicy::create(Auth::user(), $event)) {
            return response('No permission to perform this request.', 403);
        }

        // Get file from request
        $uploadedFile = $request->file('file');

        // Get file data as hex string
        $hex = unpack('H*', file_get_contents($uploadedFile));
        $hex = current($hex);

        try {
            $file = File::create([
                'id_event' => $id,
                'name' => $uploadedFile->getClientOriginalName(),
                'data' => '\x' . $hex,
            ]);
            $file->save();
        }
        catch (QueryException $ex) {
            return response('A database error occurred.', 500);
        }

        return view('');
    }

    public function download(Request $request, $id, $fileName) {
        $event = Event::findOrFail($id);
        $file = File::where([['id_event', $id], ['name', $fileName]])->firstOrFail();

        $user = Auth::user() ?? Auth::guard('admin')->user();
        $this->authorizeForUser($user, 'view', [$file, $event]);

        $fileData = stream_get_contents($file->data);
        return response($fileData)->withHeaders(['Content-Type' => 'application/octet-stream']);
    }
}
