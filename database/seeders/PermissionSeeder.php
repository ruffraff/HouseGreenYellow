<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'receive_booking_notifications',
            'description' => 'Riceve notifiche per le prenotazioni'
        ]);
        // Aggiungi altri permessi se necessario
    }
}
