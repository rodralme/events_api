<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $events = Event::all();

        return response()->json(EventResource::collection($events));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EventRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(EventRequest $request)
    {
        Event::create($request->validated());

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Event $event)
    {
        $event->load('organizers');

        return response()->json(new EventResource($event));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EventRequest $request
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Event $event)
    {
        return response()->json(['success' => true]);
    }
}
