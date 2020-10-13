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
        $data = collect($request->validated());
        $event = Event::create($data->except('organizers')->all());
        $event->organizers()->sync($data->get('organizers'));

        return response()->json([
            'success' => true,
            'data' => new EventResource($event->load('organizers')),
        ], 201);
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
        $validated = collect($request->validated());
        $event->update($validated->except('organizers')->all());

        $event->organizers()->sync($validated->get('organizers'));

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
        $deleted = $event->delete();

        return response()->json(['success' => $deleted]);
    }
}
