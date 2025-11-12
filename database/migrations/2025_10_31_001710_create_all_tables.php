<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
        });

        // Tabla users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('sexo');
            $table->string('direccion');
            $table->date('fecha_nacimiento');
            $table->foreignId('rol')->nullable()->constrained('roles'); // Relación con la tabla roles
            $table->string('password');
            $table->rememberToken();
        });
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Tabla aulas
        Schema::create('aulas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->integer('capacidad');
            $table->string('ubicacion');
            $table->string('estado');
        });

        // Tabla materias
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique()->nullable();
            $table->unsignedTinyInteger('creditos');
            $table->unsignedTinyInteger('hps');
        });

        Schema::create('gestiones', function (Blueprint $table) {
            $table->id();
            $table->year('year');  // Año del periodo (ej. 2023)
            $table->string('periodo');  // Periodo del año (ej. "1/2023")
            $table->date('inicio');  // Fecha de inicio del periodo (ej. "2023-11-10")
            $table->date('fin');  // Fecha de fin del periodo (ej. "2024-01-10")
            $table->enum('estado', ['abierto', 'cerrado', 'en curso'])->default('cerrado');  // Estado del periodo
        });
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');  // Relación con la tabla 'users'
            $table->string('registro')->unique();  // Registro único del docente
            $table->string('especialidad')->nullable();  // Especialidad del docente (opcional)
        });
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias');  // Relación con la tabla 'materias'
            $table->foreignId('gestion_id')->constrained('gestiones');  // Relación con la tabla 'gestiones'
            $table->string('codigo')->unique(); // Código del grupo
            $table->integer('capacidad'); // Capacidad máxima de estudiantes
            $table->string('modalidad'); // Modalidad del grupo (presencial, virtual, híbrido, etc.)
            $table->foreignId('docente_id')->nullable()->constrained('docentes');  // Relación con la tabla 'docentes', permitiendo nulos
            $table->foreignId('aula_id')->constrained('aulas');  // Relación con la tabla 'aulas'
        });
        Schema::create('grupo_horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos'); // Relación con la tabla 'grupos'
            $table->string('dia');             // Día de la clase (lunes, martes, etc.)
            $table->time('hora_inicio');       // Hora de inicio
            $table->time('hora_fin');          // Hora de fin
        });
        Schema::create('asistencias_docentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('docente_id')->constrained('docentes');
            $table->foreignId('grupo_id')->constrained('grupos');
            $table->foreignId('grupo_horario_id')->constrained('grupo_horarios');
            $table->enum('estado', ['presente', 'ausente', 'justificado']);
            $table->date('fecha');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('docentes');
        Schema::dropIfExists('grupos');
        Schema::dropIfExists('gestiones');
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('aulas');
        Schema::dropIfExists('materias');
        Schema::dropIfExists('carga_horarias');
        Schema::dropIfExists('asistencias_docentes');
    }
};
