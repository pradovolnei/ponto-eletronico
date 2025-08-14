<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Rules\ValidCpf;

class EmployeeController extends Controller
{
    public function index()
    {
        // lista todos os funcionários (paginado)
        $employees = User::where('role','employee')->paginate(15);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => ['required', new ValidCpf, 'unique:users,cpf'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'cargo' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'cep' => 'required|string',
        ]);
        $data = $request->only([
            'name','cpf','email','cargo','birth_date','cep',
            'street','number','complement','neighborhood','city','state'
        ]);
        $data['password'] = Hash::make($request->password);
        $data['manager_id'] = $request->user()->id;
        $data['role'] = 'employee';

        User::create($data);

        return redirect()->route('employees.index')->with('success','Funcionário criado.');
    }

    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => ['required', new ValidCpf, Rule::unique('users','cpf')->ignore($employee->id)],
            'email' => ['required','email', Rule::unique('users','email')->ignore($employee->id)],
            'cargo' => 'required|string|max:255',
            'birth_date' => 'required|date',
        ]);

        $employee->update($request->only([
            'name','cpf','email','cargo','birth_date','cep',
            'street','number','complement','neighborhood','city','state'
        ]));

        return redirect()->route('employees.index')->with('success','Funcionário atualizado.');
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success','Funcionário removido.');
    }
}
