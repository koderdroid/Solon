<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nombre'   => 'Administrador',
            'email'    => 'admin@senape.gob.bo',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'rol'      => 'admin',
            'activo'   => true,
        ];
        $this->db->table('usuarios')->insert($data);
    }
}