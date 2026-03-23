<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Save a new employee
     */
    public function saveEmployee(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'employee_id' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', Rule::in(['cashier', 'stock', 'manager'])],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Handle profile image upload
        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profiles'), $imageName);
            $profileImage = $imageName;
        }

        // Create the user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'employee_id' => $validated['employee_id'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'profile_image' => $profileImage,
        ]);

        return redirect()->back()->with('success', 'Employee added successfully!');
    }

    /**
     * Display list of employees
     */
    public function showEmployees()
    {
        $employees = User::where('status', 1)->get();
        return view('master.employees', compact('employees'));
    }
    
    /**
     * Show the form for editing the specified employee
     */
    public function editEmployee($id)
    {
        $employee = User::findOrFail($id);
        return view('master.editemployee', compact('employee'));
    }
    
    /**
     * Update the specified employee in storage
     */
    public function updateEmployee(Request $request, $id)
    {
        $employee = User::findOrFail($id);
        
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'employee_id' => 'required|string|max:50|unique:users,employee_id,' . $id,
            'role' => ['required', Rule::in(['cashier', 'stock', 'manager'])],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        
        // Update employee data
        $employee->name = $validated['name'];
        $employee->email = $validated['email'];
        $employee->employee_id = $validated['employee_id'];
        $employee->role = $validated['role'];
        
        // Update password if provided
        if (!empty($validated['password'])) {
            $employee->password = Hash::make($validated['password']);
        }
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($employee->profile_image && file_exists(public_path('images/profiles/' . $employee->profile_image))) {
                unlink(public_path('images/profiles/' . $employee->profile_image));
            }
            
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/profiles'), $imageName);
            $employee->profile_image = $imageName;
        }
        
        $employee->save();
        
        return redirect()->route('master.employees')->with('success', 'Employee updated successfully!');
    }
    
    /**
     * Delete the specified employee from storage
     */
    public function deleteEmployee($id)
    {
        try {
            $employee = User::findOrFail($id);
            
            // Don't allow deactivation of the currently logged-in user
            if (Auth::id() == $id) {
                return redirect()->back()->with('error', 'You cannot deactivate your own account!');
            }
            
            // Instead of deleting, change status to 0 (inactive)
            $employee->status = 0;
            $employee->save();
            
            return redirect()->route('master.employees')->with('success', 'Employee deactivated successfully!');
        } catch (\Exception $e) {
            Log::error('Error deactivating employee: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to deactivate employee. ' . $e->getMessage());
        }
    }
} 