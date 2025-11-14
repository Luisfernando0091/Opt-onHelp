<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Solo los administradores pueden gestionar usuarios.
     */
    public function __construct()
    {
// [        $this->middleware(['role:admin']);
  }

    /**
     * Mostrar listado de usuarios.
     */
   public function index()
{
    // Cargamos la relación correcta (roleData)
    $usuarios = \App\Models\User::with('roles')->get();

    return view('list.Listuser', compact('usuarios'));
}


    /**
     * Mostrar formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Guardar nuevo usuario.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'LastName' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'LastName' => $validated['LastName'], // ✅ nuevo campo
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario para editar un usuario.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario existente.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role' => 'required'
        ]);

        $usuario->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $usuario->syncRoles([$validated['role']]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
    public function cambiarEstado($id)
{
    $usuario = User::findOrFail($id);

    // Si no existe el campo 'activo', avísame para crearlo
    $usuario->activo = !$usuario->activo;
    $usuario->save();

    return back()->with('success', 'Estado del usuario actualizado.');
}

}
