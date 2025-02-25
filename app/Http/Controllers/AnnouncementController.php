<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementCreateRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Services\FileService;
use Illuminate\Http\Request;
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
    public function show(Announcement $announcement)
    {
        return $this->announcementService->show($announcement->slug);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Announcement $announcement)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        //
    }
}
