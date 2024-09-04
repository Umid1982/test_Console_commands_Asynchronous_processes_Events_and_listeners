<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $roles = ['admin', 'user'];

        foreach ($roles as $role) {
            if (!Role::where('name', $role)->exists()) {
                Role::create(['name' => $role]);
            }
        }
        $emailArray = [
            'dima_37373845@gmail.com',
            'Melnikau21@gmail.com',
            'Gevondyan32@gmail.com',
            'Comlef12@gmail.com',
            'gauf23@gmail.com',
            'evgeniy47@gmail.com',
            'colesnik37@gmail.com',
            'kozmenko879@gmail.com',
            'Savina41@gmail.com',
            'Gulmira26@gmail.com',
        ];

        foreach ($emailArray as $email) {
            // Проверяем, существует ли уже пользователь с таким email
            if (User::where('email', $email)->exists()) {
                continue;
            }

            $user = User::create([
                'name' => 'User ' . substr(md5($email), 0, 6), // Генерируем случайное имя
                'email' => $email,
                'password' => Hash::make('password123'),
            ]);

            $user->assignRole('admin');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::whereIn('email', [
            'dima_37373845@gmail.com',
            'Melnikau21@gmail.com',
            'Gevondyan32@gmail.com',
            'Comlef12@gmail.com',
            'gauf23@gmail.com',
            'evgeniy47@gmail.com',
            'colesnik37@gmail.com',
            'kozmenko879@gmail.com',
            'Savina41@gmail.com',
            'Gulmira26@gmail.com',
        ])->delete();

        Role::whereIn('name', ['admin', 'user'])->delete();
    }
};
