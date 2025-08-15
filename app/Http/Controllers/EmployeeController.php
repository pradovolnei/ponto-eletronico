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
        $employees = User::where('role', 'employee')->paginate(15);
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

        try {
            $data = $request->only([
                'name',
                'cpf',
                'email',
                'cargo',
                'birth_date',
                'cep',
                'street',
                'number',
                'complement',
                'neighborhood',
                'city',
                'state'
            ]);

            $data['password'] = Hash::make($request->password);
            $data['manager_id'] = $request->user()->id;
            $data['role'] = 'employee';

            User::create($data);

            return redirect()->route('employees.index')->with('success', 'Funcionário criado com sucesso.');

        } catch (\Exception $e) {
            // Logar o erro para depuração
            \Log::error('Erro ao criar funcionário: ' . $e->getMessage());

            // Redirecionar com uma mensagem de erro
            return redirect()->back()->with('error', 'Ocorreu um erro ao criar o funcionário. Por favor, tente novamente.');
        }
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
        try {
            
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'cpf' => ['required', new ValidCpf, Rule::unique('users', 'cpf')->ignore($employee->id)],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($employee->id)],
                'cargo' => 'required|string|max:255',
                'birth_date' => 'required|date',
                'password' => 'nullable|min:8',
                'cep' => 'required|string|max:9', 
                'street' => 'required|string|max:255',
                'number' => 'required|string|max:10',
                'complement' => 'nullable|string|max:255', 
                'neighborhood' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:2',
            ]);            

            // Remove a senha do array de dados para evitar que seja atualizada se não for enviada
            unset($validatedData['password']);

            // Se o campo de senha foi preenchido, adicione a senha criptografada
            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($request->password);
            }

            // Atualiza o funcionário com os dados validados
            $employee->update($validatedData);

            return redirect()->route('employees.index')->with('success', 'Funcionário atualizado.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Lida com erros de banco de dados
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro ao atualizar o funcionário. Por favor, tente novamente.');

        } catch (\Exception $e) {
            // Lida com outros tipos de exceções
            return redirect()->back()->withInput()->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.');
        }
    }

    public function destroy(User $employee)
    {
        try {
            $employee->delete();
            return redirect()->route('employees.index')->with('success', 'Funcionário removido com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->with('error', 'Ocorreu um erro ao remover o funcionário.');
        }
    }
}
