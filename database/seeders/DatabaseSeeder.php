<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $password = Hash::make('12345678');

        // 1. USUARIOS (1 Admin y 3 Recepcionistas)
        $users = [
            ['name' => 'Super Administrador', 'email' => 'admin@consultorio.com', 'password' => $password, 'role' => 'admin', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Recepción Principal', 'email' => 'recepcion1@consultorio.com', 'password' => $password, 'role' => 'recepcionista', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Recepción Piso 2', 'email' => 'recepcion2@consultorio.com', 'password' => $password, 'role' => 'recepcionista', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Recepción Urgencias', 'email' => 'recepcion3@consultorio.com', 'password' => $password, 'role' => 'recepcionista', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('users')->insert($users);

        // 2. PACIENTES (10 pacientes de prueba para agendarles citas)
        $patients = [
            ['document' => '1000111222', 'name' => 'Andrés Felipe Gómez', 'email' => 'andres@correo.com', 'phone' => '3110001111', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000222333', 'name' => 'María José Ramírez', 'email' => 'maria@correo.com', 'phone' => '3120002222', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000333444', 'name' => 'Carlos Arturo López', 'email' => 'carlos@correo.com', 'phone' => '3130003333', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000444555', 'name' => 'Diana Patricia Silva', 'email' => 'diana@correo.com', 'phone' => '3140004444', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000555666', 'name' => 'Jorge Eliécer Pérez', 'email' => 'jorge@correo.com', 'phone' => '3150005555', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000666777', 'name' => 'Laura Vanessa Castro', 'email' => 'laura@correo.com', 'phone' => '3160006666', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000777888', 'name' => 'Kevin Steven Díaz', 'email' => 'kevin@correo.com', 'phone' => '3170007777', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000888999', 'name' => 'Ana Lucía Morales', 'email' => 'ana@correo.com', 'phone' => '3180008888', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000999000', 'name' => 'Pedro Pablo León', 'email' => 'pedro@correo.com', 'phone' => '3190009999', 'created_at' => $now, 'updated_at' => $now],
            ['document' => '1000123456', 'name' => 'Sofía Margarita Rojas', 'email' => 'sofia@correo.com', 'phone' => '3200001234', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('patients')->insert($patients);

        // 3. ESPECIALIDADES (Insertamos y guardamos sus IDs para conectarlos)
        $esp_medGen = DB::table('specialties')->insertGetId(['name' => 'Medicina General', 'created_at' => $now, 'updated_at' => $now]);
        $esp_cardio = DB::table('specialties')->insertGetId(['name' => 'Cardiología', 'created_at' => $now, 'updated_at' => $now]);
        $esp_odonto = DB::table('specialties')->insertGetId(['name' => 'Odontología', 'created_at' => $now, 'updated_at' => $now]);
        $esp_pedia  = DB::table('specialties')->insertGetId(['name' => 'Pediatría', 'created_at' => $now, 'updated_at' => $now]);
        $esp_derma  = DB::table('specialties')->insertGetId(['name' => 'Dermatología', 'created_at' => $now, 'updated_at' => $now]);
        $esp_gineco = DB::table('specialties')->insertGetId(['name' => 'Ginecología', 'created_at' => $now, 'updated_at' => $now]);

        // 4. DOCTORES (Asignados a sus especialidades)
        $doctors = [
            // Medicina General
            ['name' => 'Dr. Fernando Salazar', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dra. Claudia Medina', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dr. Camilo Vargas', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            // Cardiología
            ['name' => 'Dr. Alberto Ruiz', 'specialty_id' => $esp_cardio, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dra. Elena Ortiz', 'specialty_id' => $esp_cardio, 'created_at' => $now, 'updated_at' => $now],
            // Odontología
            ['name' => 'Dr. Martín Osorio', 'specialty_id' => $esp_odonto, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dra. Juliana Ríos', 'specialty_id' => $esp_odonto, 'created_at' => $now, 'updated_at' => $now],
            // Pediatría
            ['name' => 'Dra. Sandra Milena', 'specialty_id' => $esp_pedia, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dr. Diego Quintero', 'specialty_id' => $esp_pedia, 'created_at' => $now, 'updated_at' => $now],
            // Dermatología
            ['name' => 'Dra. Valentina Torres', 'specialty_id' => $esp_derma, 'created_at' => $now, 'updated_at' => $now],
            // Ginecología
            ['name' => 'Dra. Beatriz Jaramillo', 'specialty_id' => $esp_gineco, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Dr. Luis Fernando Roa', 'specialty_id' => $esp_gineco, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('doctors')->insert($doctors);

        // 5. CONSULTORIOS (Distribuidos por especialidad)
        $rooms = [
            // Medicina General (Piso 1)
            ['name' => 'Consultorio 101 - Med General', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 102 - Med General', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 103 - Med General', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 104 - Med General', 'specialty_id' => $esp_medGen, 'created_at' => $now, 'updated_at' => $now],
            // Cardiología (Piso 2)
            ['name' => 'Consultorio 201 - Cardiología', 'specialty_id' => $esp_cardio, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 202 - Cardiología', 'specialty_id' => $esp_cardio, 'created_at' => $now, 'updated_at' => $now],
            // Odontología (Piso 2 - Equipados con sillas odontológicas)
            ['name' => 'Consultorio 205 - Odontología', 'specialty_id' => $esp_odonto, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 206 - Odontología', 'specialty_id' => $esp_odonto, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 207 - Odontología', 'specialty_id' => $esp_odonto, 'created_at' => $now, 'updated_at' => $now],
            // Pediatría (Piso 3)
            ['name' => 'Consultorio 301 - Pediatría', 'specialty_id' => $esp_pedia, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 302 - Pediatría', 'specialty_id' => $esp_pedia, 'created_at' => $now, 'updated_at' => $now],
            // Dermatología (Piso 3)
            ['name' => 'Consultorio 305 - Dermatología', 'specialty_id' => $esp_derma, 'created_at' => $now, 'updated_at' => $now],
            // Ginecología (Piso 4)
            ['name' => 'Consultorio 401 - Ginecología', 'specialty_id' => $esp_gineco, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Consultorio 402 - Ginecología', 'specialty_id' => $esp_gineco, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('consulting_rooms')->insert($rooms);
    }
}