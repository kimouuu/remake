<?php

namespace App\Http\Controllers\Admin\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Event\EventUpdateRequest;
use App\Models\Event;
use App\Http\Requests\Admin\Event\EventStoreRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        $events = Event::all();
        return view('admin.event.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event = Event::find($event->id);
        return view('admin.event.show', compact('event'));
    }
    public function create()
    {
        return view('admin.event.create');
    }

    public function store(EventStoreRequest $request)
    {
        $validated = $request->validated();
        $event = new Event();
        $event->name = $validated['name'];
        $event->description = $validated['description'];
        $event->date = $validated['date'];
        $event->location = $validated['location'];
        $event->image = null;
        $this->uploadImage($request, 'image', 'image', $event);
        $event->save();
        return to_route('admin.events.index')->with('success', 'Event created successfully.');
    }
    private function uploadImage(Request $request, $inputName, $folder, $event)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $slug = Str::slug($file->getClientOriginalName());
            $newFileName = time() . '_' . $slug;
            $file->move($folder . '/', $newFileName);
            $event->$inputName = $folder . '/' . $newFileName;
        }
    }

    public function edit(Event $event)
    {
        $event = Event::find($event->id);
        return view('admin.event.edit', compact('event'));
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        $validated = $request->validated();

        $event->name = $validated['name'];
        $event->description = $validated['description'];
        $event->date = $validated['date'];
        $event->location = $validated['location'];
        $this->updateImage($request, 'image', 'image', $event);
        $event->save();

        return to_route('admin.events.index')->with('success', 'Event updated successfully.');
    }
    private function updateImage(Request $request, $inputName, $folder, $event)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $slug = Str::slug($file->getClientOriginalName());
            $newFileName = time() . '_' . $slug;
            $file->move($folder . '/', $newFileName);
            $event->$inputName = $folder . '/' . $newFileName;
        } elseif ($request->has($inputName . '_remove')) {
            $event->$inputName = null;
        }
    }
    public function destroy(Event $event)
    {
        $event->delete();

        return to_route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
