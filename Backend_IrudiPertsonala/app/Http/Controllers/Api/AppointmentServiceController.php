<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AppointmentService;
use Illuminate\Validation\ValidationException;

class AppointmentServiceController extends Controller
{
    private function validationRules(): array
    {
        return [
            'appointment_id' => 'required|exists:appointments,id',
            'service_id' => 'required|exists:services,id',
            'comments' => 'nullable|string',
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => AppointmentService::all()
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        AppointmentService::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'AppointmentService sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $appointmentService = AppointmentService::find($id);

        if (!$appointmentService) {
            return response()->json([
                'success' => false,
                'message' => 'AppointmentService id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $appointmentService
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $appointmentService = AppointmentService::find($id);

        if (!$appointmentService) {
            return response()->json([
                'success' => false,
                'message' => 'AppointmentService id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $appointmentService->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'AppointmentService eguneratu da'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $appointmentService = AppointmentService::find($id);

        if (!$appointmentService) {
            return response()->json([
                'success' => false,
                'data' => 'AppointmentService id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $appointmentService->delete();

        return response()->json([
            'success' => true,
            'data' => 'AppointmentService ezabatuta'
        ], Response::HTTP_OK);
    }
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => AppointmentService::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }
    public function deletedShow(string $id)
    {
        $appointmentService = AppointmentService::onlyTrashed()->find($id);

        if (!$appointmentService) {
            return response()->json([
                'success' => false,
                'message' => 'AppointmentService ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $appointmentService
        ], Response::HTTP_OK);
    }

}
