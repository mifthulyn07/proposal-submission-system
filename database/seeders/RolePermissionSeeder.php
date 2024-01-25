<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // roles(table)
        Role::create(['name' => 'coordinator']);
        Role::create(['name' => 'kaprodi']);
        Role::create(['name' => 'lecturer']);
        Role::create(['name' => 'student']);

        // Permissions(table): users
        Permission::create(['name' => 'read-user']);
        Permission::create(['name' => 'add-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);
        // Permissions(table): topics 
        Permission::create(['name' => 'read-topic']);
        Permission::create(['name' => 'add-topic']);
        Permission::create(['name' => 'edit-topic']);
        Permission::create(['name' => 'delete-topic']);
        // Permissions(table): lecturers
        Permission::create(['name' => 'read-lecturer']);
        Permission::create(['name' => 'edit-lecturer']);
        Permission::create(['name' => 'delete-lecturer']);
        Permission::create(['name' => 'show-project-students']);
        // Permissions(table): students 
        Permission::create(['name' => 'read-student']);
        Permission::create(['name' => 'edit-student']);
        Permission::create(['name' => 'delete-student']);
        // Permissions(table): proposals 
        Permission::create(['name' => 'read-proposal']);
        Permission::create(['name' => 'add-proposal']);
        Permission::create(['name' => 'edit-proposal']);
        Permission::create(['name' => 'delete-proposal']);
        // Permissions(table): submit_proposal 
        Permission::create(['name' => 'read-submit-proposal']);
        Permission::create(['name' => 'add-submit-proposal']);
        Permission::create(['name' => 'edit-submit-proposal']);
        Permission::create(['name' => 'delete-submit-proposal']);
        Permission::create(['name' => 'verification-submit-proposal']);
        Permission::create(['name' => 'result-submit-proposal']);
        // Permissions(table): check_similarity
        Permission::create(['name' => 'check-similarity']);
        // Permissions(table): check proposals 
        Permission::create(['name' => 'read-check-proposal']);
        Permission::create(['name' => 'check-check-proposal']);
        Permission::create(['name' => 'history-check-proposal']);
        // Permissions(table): assignment advisor 
        Permission::create(['name' => 'read-assignment-advisor']);
        Permission::create(['name' => 'check-assignment-advisor']);
        
        // model_has_permissions(table)
        $roleCoordinator = Role::findByName('coordinator');
            // user 
            $roleCoordinator->givePermissionTo('read-user');
            $roleCoordinator->givePermissionTo('add-user');
            $roleCoordinator->givePermissionTo('edit-user');
            $roleCoordinator->givePermissionTo('delete-user');
            // topic 
            $roleCoordinator->givePermissionTo('read-topic');
            $roleCoordinator->givePermissionTo('add-topic');
            $roleCoordinator->givePermissionTo('edit-topic');
            $roleCoordinator->givePermissionTo('delete-topic');
            // lecturer 
            $roleCoordinator->givePermissionTo('read-lecturer');
            $roleCoordinator->givePermissionTo('edit-lecturer');
            $roleCoordinator->givePermissionTo('delete-lecturer');
            $roleCoordinator->givePermissionTo('show-project-students');
            // student 
            $roleCoordinator->givePermissionTo('read-student');
            $roleCoordinator->givePermissionTo('edit-student');
            $roleCoordinator->givePermissionTo('delete-student');
            // proposal 
            $roleCoordinator->givePermissionTo('read-proposal');
            $roleCoordinator->givePermissionTo('add-proposal');
            $roleCoordinator->givePermissionTo('edit-proposal');
            $roleCoordinator->givePermissionTo('delete-proposal');
            // check proposals 
            $roleCoordinator->givePermissionTo('read-check-proposal');
            $roleCoordinator->givePermissionTo('check-check-proposal');
            $roleCoordinator->givePermissionTo('history-check-proposal');
            // check similarity 
            $roleCoordinator->givePermissionTo('check-similarity');

        $roleCoordinator = Role::findByName('kaprodi');
            // user 
            $roleCoordinator->givePermissionTo('read-user');
            $roleCoordinator->givePermissionTo('add-user');
            $roleCoordinator->givePermissionTo('edit-user');
            $roleCoordinator->givePermissionTo('delete-user');
            // topic 
            $roleCoordinator->givePermissionTo('read-topic');
            $roleCoordinator->givePermissionTo('add-topic');
            $roleCoordinator->givePermissionTo('edit-topic');
            $roleCoordinator->givePermissionTo('delete-topic');
            // lecturer 
            $roleCoordinator->givePermissionTo('read-lecturer');
            $roleCoordinator->givePermissionTo('edit-lecturer');
            $roleCoordinator->givePermissionTo('delete-lecturer');
            $roleCoordinator->givePermissionTo('show-project-students');
            // student 
            $roleCoordinator->givePermissionTo('read-student');
            $roleCoordinator->givePermissionTo('edit-student');
            $roleCoordinator->givePermissionTo('delete-student');
            // proposal 
            $roleCoordinator->givePermissionTo('read-proposal');
            $roleCoordinator->givePermissionTo('add-proposal');
            $roleCoordinator->givePermissionTo('edit-proposal');
            $roleCoordinator->givePermissionTo('delete-proposal');
            // check proposals 
            $roleCoordinator->givePermissionTo('read-check-proposal');
            $roleCoordinator->givePermissionTo('check-check-proposal');
            $roleCoordinator->givePermissionTo('history-check-proposal');
            // check proposals 
            $roleCoordinator->givePermissionTo('read-assignment-advisor');
            $roleCoordinator->givePermissionTo('check-assignment-advisor');
            // check similarity 
            $roleCoordinator->givePermissionTo('check-similarity');
        
        $roleStudent = Role::findByName('student');
            // lecturer 
            $roleStudent->givePermissionTo('read-lecturer');
            $roleStudent->givePermissionTo('show-project-students');
            // student 
            $roleStudent->givePermissionTo('read-student');
            // proposal 
            $roleStudent->givePermissionTo('read-proposal');
            // proposal submit 
            $roleStudent->givePermissionTo('read-submit-proposal');
            $roleStudent->givePermissionTo('add-submit-proposal');
            $roleStudent->givePermissionTo('edit-submit-proposal');
            $roleStudent->givePermissionTo('delete-submit-proposal');
            $roleStudent->givePermissionTo('verification-submit-proposal');
            $roleStudent->givePermissionTo('result-submit-proposal');
            // check similarity 
            $roleCoordinator->givePermissionTo('check-similarity');

        $roleLecturer = Role::findByName('lecturer' );
            // lecturer 
            $roleLecturer->givePermissionTo('read-lecturer');
            $roleLecturer->givePermissionTo('show-project-students');
            // student 
            $roleLecturer->givePermissionTo('read-student');
            // proposal 
            $roleLecturer->givePermissionTo('read-proposal');
            // check similarity 
            $roleCoordinator->givePermissionTo('check-similarity');

    }
}
