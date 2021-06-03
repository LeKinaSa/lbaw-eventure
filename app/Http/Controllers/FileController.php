<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller {
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id) {
        $event = Event::findOrFail($id);
        $this->authorize('create', [File::class, $event]);

        $request->validate(['file' => 'file|max:3000']);

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
            return back()->withErrors(['file' => 'A database error occurred.']);
        }

        return back();
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
