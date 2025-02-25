<?php

namespace App\Services;

use App\Models\Announcement;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class AnnouncementService
{
    public function __construct(protected FileService $fileService)
    {
    }

    public function create($params)
    {
        try {
            $params["user_id"] = auth()->user()->id;
            $announcement = Announcement::create($params);
            foreach ($params["attachment"] as $attachment) {
                $name = $this->fileService->upload($attachment, "attachments/");
                $announcement->attachment()->create([
                    "path" => $name,
                ]);
            }
            return $announcement->with("attachment")->first();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . " on time: " . Carbon::now()->format("Y-m-d H:i:s"));
            return false;
        }
    }

    public function index($params = null)
    {
        $attachment = new Announcement();
        if (!is_null($params)){
            if (isset($params["status"])){
                $attachment->where("status", $params["status"]);
            }
            if (isset($params["location"])){
                $attachment->where("location", $params["location"]);
            }
            if (isset($params["price_from"])){
                $attachment->where("price", ">", $params["price_from"]);
            }
            if (isset($params["price_to"])){
                $attachment->where("price", "<", $params["price_to"]);
            }
            if (isset($params["category_id"])){
                $attachment->where("category_id", $params["category_id"]);
            }
        }

        return $attachment->paginate(10);
    }

    public function show($slug)
    {
        $announcement = Announcement::where("slug", $slug)
            ->where("status", "active")
            ->with("attachment")
            ->first();

        $cacheKey = 'announcement_view_' . $announcement->id . '_' . request()->ip();
        if (!cache()->has($cacheKey)) {
            $announcement->increment("view_count");
            cache()->put($cacheKey, true, now()->addMinutes(5));
        }

        return $announcement;
    }

    public function update(array $all, Announcement $announcement)
    {
        try {
            $announcement->update($all);
            if (isset($all["attachment"])) {
                foreach ($all["attachment"] as $attachment) {
                    $name = $this->fileService->upload($attachment, "attachments/");
                    $announcement->attachment()->create([
                        "path" => $name,
                    ]);
                }
            }
            return $announcement->with("attachment")->first();
        } catch (Exception $e) {
            Log::error($e->getMessage() . " on time: " . Carbon::now()->format("Y-m-d H:i:s"));
            return false;
        }
    }
}
