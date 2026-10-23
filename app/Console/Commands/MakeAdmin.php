<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin 
                            {email? : Correo electrónico del administrador}
                            {--name= : Nombre del administrador}
                            {--password= : Contraseña del administrador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea o actualiza un usuario administrador para gestionar el inventario';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('==============================================');
        $this->info('    Gestión de Administrador - TiendaGrow     ');
        $this->info('==============================================');

        $email = $this->argument('email');
        while (empty($email)) {
            $email = $this->ask('Ingresa el correo electrónico del administrador');
            $validator = Validator::make(['email' => $email], [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                $this->error('Formato de correo no válido. Intenta nuevamente.');
                $email = null;
            }
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $this->warn("El usuario con email '{$email}' ya existe.");
            if (!$this->confirm('¿Deseas actualizar la contraseña de este administrador?', true)) {
                $this->info('Operación cancelada.');
                return Command::SUCCESS;
            }
        }

        $name = $this->option('name');
        if (empty($name)) {
            $name = $user ? $user->name : $this->ask('Ingresa el nombre del administrador', 'Administrador');
        }

        $password = $this->option('password');
        if (empty($password)) {
            while (true) {
                $password = $this->secret('Ingresa la contraseña (mínimo 6 caracteres)');
                if (strlen($password) < 6) {
                    $this->error('La contraseña debe tener al menos 6 caracteres.');
                    continue;
                }

                $confirmPassword = $this->secret('Confirma la contraseña');
                if ($password !== $confirmPassword) {
                    $this->error('Las contraseñas no coinciden. Intenta de nuevo.');
                    continue;
                }

                break;
            }
        }

        if ($user) {
            $user->name = $name;
            $user->password = Hash::make($password);
            $user->save();
            $action = 'Actualizado';
        } else {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);
            $action = 'Creado';
        }

        $this->newLine();
        $this->table(
            ['ID', 'Nombre', 'Email', 'Estado'],
            [[$user->id, $user->name, $user->email, "{$action} exitosamente"]]
        );

        $this->info('¡Administrador listo!');
        $this->line("Puedes iniciar sesión con estas credenciales en: <comment>/admin</comment>");

        return Command::SUCCESS;
    }
}
