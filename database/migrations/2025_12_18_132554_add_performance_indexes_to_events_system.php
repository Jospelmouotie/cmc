<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPerformanceIndexesToEventsSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // // Add indexes to events table
        // Schema::table('events', function (Blueprint $table) {
        //     // Single column indexes for foreign keys
        //     $table->index('user_id', 'idx_events_user_id');
        //     $table->index('patient_id', 'idx_events_patient_id');
        //     $table->index('statut', 'idx_events_statut');
            
        //     // Composite index for date range queries (start and end)
        //     $table->index(['start', 'end'], 'idx_events_start_end');
            
        //     // Composite index for user-specific date queries (most common query pattern)
        //     $table->index(['user_id', 'start', 'end'], 'idx_events_user_dates');
            
        //     // Index for state column if you use it for filtering
        //     $table->index('state', 'idx_events_state');
        // });

        // // Add indexes to patients table
        // Schema::table('patients', function (Blueprint $table) {
        //     // Individual indexes for name search
        //     $table->index('name', 'idx_patients_name');
        //     $table->index('prenom', 'idx_patients_prenom');
        // });
        
        // // Add full-text index for better patient search (MySQL/MariaDB only)
        // // Only add if you're using MySQL or MariaDB
        // if (DB::connection()->getDriverName() === 'mysql') {
        //     DB::statement('ALTER TABLE patients ADD FULLTEXT INDEX idx_patients_fulltext (name, prenom)');
        // }

        // // Add indexes to users table
        // Schema::table('users', function (Blueprint $table) {
        //     // Index for role-based queries
        //     $table->index('role_id', 'idx_users_role_id');
            
        //     // Composite index for medecin listing queries
        //     $table->index(['role_id', 'name', 'prenom'], 'idx_users_role_name');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // public function down()
    // {
    //     // Drop indexes from events table
    //     Schema::table('events', function (Blueprint $table) {
    //         $table->dropIndex('idx_events_user_id');
    //         $table->dropIndex('idx_events_patient_id');
    //         $table->dropIndex('idx_events_statut');
    //         $table->dropIndex('idx_events_start_end');
    //         $table->dropIndex('idx_events_user_dates');
    //         $table->dropIndex('idx_events_state');
    //     });

    //     // Drop indexes from patients table
    //     Schema::table('patients', function (Blueprint $table) {
    //         $table->dropIndex('idx_patients_name');
    //         $table->dropIndex('idx_patients_prenom');
    //     });
        
    //     // Drop full-text index
    //     if (DB::connection()->getDriverName() === 'mysql') {
    //         DB::statement('ALTER TABLE patients DROP INDEX idx_patients_fulltext');
    //     }

    //     // Drop indexes from users table
    //     Schema::table('users', function (Blueprint $table) {
    //         $table->dropIndex('idx_users_role_id');
    //         $table->dropIndex('idx_users_role_name');
    //     });
    // }
}