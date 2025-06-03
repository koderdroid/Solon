<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function login()
    {
        helper(['form']);
        if ($this->request->getMethod() === 'post') {
            $usuarioModel = new UsuarioModel();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $usuario = $usuarioModel->getByEmail($email);

            if ($usuario && password_verify($password, $usuario['password']) && $usuario['activo']) {
                // Iniciar sesión
                session()->set([
                    'usuario_id' => $usuario['id'],
                    'usuario_nombre' => $usuario['nombre'],
                    'usuario_email' => $usuario['email'],
                    'usuario_rol' => $usuario['rol'],
                    'isLoggedIn' => true
                ]);
                return redirect()->to('/');
            } else {
                return view('auth/login', ['error' => 'Credenciales inválidas o usuario inactivo']);
            }
        }
        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
}