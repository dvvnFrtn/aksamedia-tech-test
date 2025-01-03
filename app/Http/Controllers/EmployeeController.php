<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page') ?? 10;

        $employees = Employee::with('division')
            ->when(request('name'), function($query, $name) {
                return $query->where('name', 'like', "%$name%");
            })
            ->when(request('division_id'), function($query, $division_id) {
                return $query->where('division_id', $division_id);
            })
            ->paginate($perPage);

        return ApiResponse::success(
            new EmployeeCollection($employees), 
            'Employees retrieve successful'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $validated = $request->validated();   
        
        $originalName = $request->file('image')->getClientOriginalName();
        $extension = $request->file('image')->getClientOriginalExtension();
        $uniqueName = Str::uuid() . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;
        $imagePath = $request->file('image')->storeAs('employees', $uniqueName, 'public');

        $employee = new Employee();
        $division = Division::findOrFail($validated['division_id']);

        $employee->name = $validated['name'];
        $employee->phone = $validated['phone'];
        $employee->position = $validated['position'];
        $employee->image = $imagePath;
        $employee->division()->associate($division);
        $employee->save();

        return ApiResponse::success(
            new EmployeeResource($employee),
            'Employee create successful',
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $uuid)
    {
        $employee = Employee::findOrFail( $uuid );
        $validated = $request->validated();

        if ($employee->image && Storage::exists($employee->image)) {
            Storage::delete($employee->image);
        }
        $originalName = $request->file('image')->getClientOriginalName();
        $extension = $request->file('image')->getClientOriginalExtension();
        $uniqueName = Str::uuid() . '_' . pathinfo($originalName, PATHINFO_FILENAME) . '.' . $extension;

        $imagePath = $request->file('image')->storeAs('employees', $uniqueName, 'public');
        $validated['image'] = $imagePath;
        

        $employee->update($validated);

        return ApiResponse::success(
            new EmployeeResource($employee),
            'Employee update successful',
            Response::HTTP_CREATED
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
