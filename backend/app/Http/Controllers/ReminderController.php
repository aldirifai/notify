<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReminderRequest;
use App\Models\Reminder;

class ReminderController extends Controller
{
    public function index()
    {
        $reminders = Reminder::when(auth('sanctum')->user()->role !== 'admin', function ($query) {
            return $query->where('created_by', auth('sanctum')->user()->id);
        })->orderBy('created_at', 'desc')->with(['createdBy', 'category'])->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil ditampilkan',
            'data' => $reminders
        ]);
    }

    public function store(ReminderRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth('sanctum')->user()->role === 'admin' ? $validated['created_by'] : auth('sanctum')->user()->id;

        if($request->has('is_important')) {
            $validated['is_important'] = $request->is_important == "true" || $request->is_important ? 1 : 0;
        }

        $reminder = Reminder::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil ditambahkan',
            'data' => $reminder
        ], 201);
    }

    public function show(Reminder $reminder)
    {
        if(!$this->checkAccess($reminder)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses'
            ], 403);
        }
        $reminder->load(['createdBy', 'category']);

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil ditampilkan',
            'data' => $reminder
        ]);
    }

    public function update(ReminderRequest $request, Reminder $reminder)
    {
        if(!$this->checkAccess($reminder)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses'
            ], 403);
        }

        $validated = $request->validated();
        $validated['created_by'] = auth('sanctum')->user()->role === 'admin' ? $validated['created_by'] : auth('sanctum')->user()->id;

        if($request->has('is_important')) {
            $validated['is_important'] = $request->is_important == "true" || $request->is_important ? 1 : $reminder->is_important;
        }

        $reminder->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil diperbarui',
            'data' => $reminder
        ]);
    }

    public function destroy(Reminder $reminder)
    {
        if(!$this->checkAccess($reminder)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses'
            ], 403);
        }
        $reminder->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil dihapus'
        ]);
    }

    public function done(Reminder $reminder)
    {
        if(!$this->checkAccess($reminder)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses'
            ], 403);
        }

        $reminder->update([
            'is_done' => !$reminder->is_done,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil diperbarui',
            'data' => $reminder
        ]);
    }

    public function important(Reminder $reminder)
    {
        if(!$this->checkAccess($reminder)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak akses'
            ], 403);
        }

        $reminder->update([
            'is_important' => !$reminder->is_important,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reminder berhasil diperbarui',
            'data' => $reminder
        ]);
    }

    private function checkAccess(Reminder $reminder)
    {
        if (auth('sanctum')->user()->role !== 'admin' && $reminder->created_by !== auth('sanctum')->user()->id) {
            return false;
        } else {
            return true;
        }
    }
}
