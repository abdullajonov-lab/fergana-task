<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementCreateRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Validator;

class AnnouncementController extends Controller
{
    public function __construct(
        protected AnnouncementService $announcementService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*
         * to show that I can do all validation ways) xD
         * */
        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|string',
            'location' => 'sometimes|string',
            'price_from' => 'sometimes|numeric',
            'price_to' => 'sometimes|numeric',
            'category_id' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        return $this->announcementService->index($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementCreateRequest $request)
    {
        $ann = $this->announcementService->create($request->all());
        if ($ann) {
            return response()->json([
                'message' => 'Announcement created successfully',
                "data" => $ann
            ], 201);
        } else {
            return response()->json(['message' => 'WHOOPS Something gone wrong, our elfs are trying theis best to fix ths problem please wait...'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $id)
    {
        $announcement = $this->announcementService->show($id->slug);
        if ($announcement) {
            return response()->json([
                'message' => 'Announcement retrieved successfully',
                "data" => $announcement
            ], 200);
        } else {
            return response()->json(['message' => 'Announcement not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $id)
    {
        if (Gate::denies('is-your-announcement', $id)) {
            return response()->json([
                'message' => 'You are not authorized to update this announcement'
            ], 403);
        }
        $data = $request->validate([
            "title" => "sometimes|string",
            "description" => "sometimes|string",
            "price" => "sometimes|numeric",
            "location" => "sometimes|string",
            "category_id" => "sometimes|integer",
            "status" => "sometimes|string",
            "attachment" => "sometimes|array",
            "attachment.*" => "sometimes|file|mimes:jpg,jpeg,png,pdf|max:2048"
        ]);
        $ann = $this->announcementService->update($data, $id);
        if ($ann) {
            return response()->json([
                'message' => 'Announcement updated successfully',
                "data" => $ann
            ], 200);
        } else {
            return response()->json(['message' => 'WHOOPS Something gone wrong, our elfs are trying theis best to fix ths problem please wait...'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        if (Gate::denies('is-your-announcement', $announcement)) {
            return response()->json([
                'message' => 'You are not authorized to delete this announcement'
            ], 403);
        }
        $announcement->delete();
        return response()->json([
            'message' => 'Announcement deleted successfully'
        ], 200);
    }
}
