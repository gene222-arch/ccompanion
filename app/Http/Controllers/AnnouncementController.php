<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Administrator|Administrator');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.announcement.index', [
            'announcements' => Announcement::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.announcement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AnnouncementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementRequest $request)
    {
        $path = '';

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            
            $origName = $image->getClientOriginalName();
            $imageName = pathinfo($origName, PATHINFO_FILENAME);
            $ext = $image->extension();

            $newFileName = $imageName . '-' . time() . ".{$ext}";

            $image->storeAs('public/announcement-images/', $newFileName);
            $path = "announcement-images/{$newFileName}";
        }

        $data = array_merge($request->validated(), [
            'user_id' => auth()->id(),
            'image_path' => $path
        ]);
        
        Announcement::create($data);

        return Redirect::route('announcements.index')
            ->with([
                'successMessage' => 'Announcement created successfully.'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return view('app.announcement.edit', [
            'announcement' => $announcement
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AnnouncementRequest  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $announcementHeader = $announcement->header;
        $path = $announcement->image_path;

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            
            $origName = $image->getClientOriginalName();
            $imageName = pathinfo($origName, PATHINFO_FILENAME);
            $ext = $image->extension();

            $newFileName = $imageName . '-' . time() . ".{$ext}";

            $image->storeAs('public/announcement-images/', $newFileName);
            $path = "announcement-images/{$newFileName}";
        }

        $data = array_merge($request->validated(), [
            'user_id' => auth()->id(),
            'image_path' => $path
        ]);
        
        $announcement->update($data);

        return Redirect::route('announcements.index')
            ->with([
                'successMessage' => $announcementHeader . ' updated successfully.'
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function toggleEnable(Announcement $announcement)
    {
        $message = !$announcement->enabled ? 'enabled' : 'disabled';

        $announcement->update([
            'enabled' => !$announcement->enabled
        ]);

        return Redirect::route('announcements.index')
            ->with([
                'successMessage' => "{$announcement->header} {$message} successfully."
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $announcementHeader = $announcement->header;
        $announcement->delete();

        return Redirect::route('announcements.index')
            ->with([
                'successMessage' => $announcementHeader . ' deleted successfully.'
            ]);
    }
}
