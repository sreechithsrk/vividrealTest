<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employee.index', [
            'employees' => Employee::paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::select('id', 'name')->get();

        return view('employee.create', [
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
            'email' => 'required|unique:employee|email',
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('employee.create'))
                ->withErrors($validator)
                ->withInput($request->all());
        }
        Employee::create($request->all());

        return redirect()->route('employee.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('employee.update', [
            'companies' => Company::select('id', 'name')->get(),
            'model' => Employee::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'company_id' => 'required',
            'email' => 'required|email|unique:employee,email,' . $id,
            'phone' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('employee.edit', $id))
                ->withErrors($validator)
                ->withInput($request->all());
        }
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());

        return redirect()->route('employee.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return redirect()->route('employee.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function getData()
    {
        $data = Employee::query();

        return DataTables::of($data)
            ->addColumn('actions', fn($employee) => view('employee.actions', [
                'id' => $employee->id,
            ]))
            ->addColumn('company', fn($employee) => $employee->company->name)
            ->rawColumns(['action', 'company'])
            ->toJson();
    }
}
