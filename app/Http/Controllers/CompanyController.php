<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('company.index', [
            'companies' => Company::paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:company|email',
            'logo' => 'required|dimensions:min_width=100,min_height=100|mimes:jpg,jpeg,png',
            'website' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('company.create'))
                ->withErrors($validator)
                ->withInput($request->all());
        }
        $company = Company::create($request->except('logo'));

        if ($request->hasFile('logo')) {
            $company->addMediaFromRequest('logo')
                ->toMediaCollection('logo', 'public');
        }

        return redirect()->route('company.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        return view('company.update', [
            'model' => Company::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:company,email,' . $id,
            'logo' => 'dimensions:min_width=100,min_height=100|mimes:jpg,jpeg,png',
            'website' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('company.edit', $id))
                ->withErrors($validator)
                ->withInput($request->all());
        }
        $company = Company::findOrFail($id);
        $company->update($request->except('logo'));

        if ($request->hasFile('logo')) {
            $company->deleteMedia($company->getFirstMedia('logo'));
            $company->addMediaFromRequest('logo')
                ->toMediaCollection('logo');
        }

        return redirect()->route('company.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return redirect()->route('company.index')->with('error', 'Company not found');
        }
        $employeesCount = $company->employees()->count();

        if ($employeesCount > 0) {
            return redirect()->route('company.index')->with('error', 'Cannot delete company with related employees');
        }
        $company->deleteMedia($company->getFirstMedia('logo'));
        $company->delete();

        return redirect()->route('company.index')->with('success', 'Company has been deleted successfully');
    }

    public function getData()
    {
        $data = Company::query();

        return DataTables::of($data)
            ->addColumn('actions', fn($company) => view('company.actions', [
                'id' => $company->id,
            ]))
            ->rawColumns(['actions'])
            ->make();
    }
}
