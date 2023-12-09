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
        // roles 
        Role::create(['name' => 'coordinator']);
        Role::create(['name' => 'kaprodi']);
        Role::create(['name' => 'lecturer']);
        Role::create(['name' => 'student']);

        // users
        Permission::create(['name' => 'read-user']);
        Permission::create(['name' => 'add-user']);
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);

        // lecturers
        Permission::create(['name' => 'read-lecturer']);
        Permission::create(['name' => 'add-lecturer']);
        Permission::create(['name' => 'edit-lecturer']);
        Permission::create(['name' => 'delete-lecturer']);
        Permission::create(['name' => 'show-lecturer']);

        // students 
        Permission::create(['name' => 'read-student']);
        Permission::create(['name' => 'add-student']);
        Permission::create(['name' => 'edit-student']);
        Permission::create(['name' => 'delete-student']);

        // topics 
        Permission::create(['name' => 'read-topic']);
        Permission::create(['name' => 'add-topic']);
        Permission::create(['name' => 'edit-topic']);
        Permission::create(['name' => 'delete-topic']);

        // proposals 
        Permission::create(['name' => 'read-proposal']);
        Permission::create(['name' => 'add-proposal']);
        Permission::create(['name' => 'edit-proposal']);
        Permission::create(['name' => 'delete-proposal']);

        // proposal submit 
        Permission::create(['name' => 'read-proposal-submit']);
        Permission::create(['name' => 'add-proposal-submit']);
        Permission::create(['name' => 'edit-proposal-submit']);
        Permission::create(['name' => 'similarity-submit']);
        Permission::create(['name' => 'add-similarity-submit']);

        // check proposals 
        Permission::create(['name' => 'read-check-proposal']);
        Permission::create(['name' => 'check-check-proposal']);
        Permission::create(['name' => 'history-check-proposal']);

        // assignment advisor 
        Permission::create(['name' => 'read-assignment-advisor']);
        Permission::create(['name' => 'check-assignment-advisor']);
        

        $roleCoordinator = Role::findByName('coordinator');
            // user 
            $roleCoordinator->givePermissionTo('read-user');
            $roleCoordinator->givePermissionTo('add-user');
            $roleCoordinator->givePermissionTo('edit-user');
            $roleCoordinator->givePermissionTo('delete-user');
            // lecturer 
            $roleCoordinator->givePermissionTo('read-lecturer');
            $roleCoordinator->givePermissionTo('add-lecturer');
            $roleCoordinator->givePermissionTo('edit-lecturer');
            $roleCoordinator->givePermissionTo('delete-lecturer');
            $roleCoordinator->givePermissionTo('show-lecturer');
            // student 
            $roleCoordinator->givePermissionTo('read-student');
            $roleCoordinator->givePermissionTo('add-student');
            $roleCoordinator->givePermissionTo('edit-student');
            $roleCoordinator->givePermissionTo('delete-student');
            // topic 
            $roleCoordinator->givePermissionTo('read-topic');
            $roleCoordinator->givePermissionTo('add-topic');
            $roleCoordinator->givePermissionTo('edit-topic');
            $roleCoordinator->givePermissionTo('delete-topic');
            // proposal 
            $roleCoordinator->givePermissionTo('read-proposal');
            $roleCoordinator->givePermissionTo('add-proposal');
            $roleCoordinator->givePermissionTo('edit-proposal');
            $roleCoordinator->givePermissionTo('delete-proposal');
            // check proposals 
            $roleCoordinator->givePermissionTo('read-check-proposal');
            $roleCoordinator->givePermissionTo('check-check-proposal');
            $roleCoordinator->givePermissionTo('history-check-proposal');


        $roleCoordinator = Role::findByName('kaprodi');
            // user 
            $roleCoordinator->givePermissionTo('read-user');
            $roleCoordinator->givePermissionTo('add-user');
            $roleCoordinator->givePermissionTo('edit-user');
            $roleCoordinator->givePermissionTo('delete-user');
            // lecturer 
            $roleCoordinator->givePermissionTo('read-lecturer');
            $roleCoordinator->givePermissionTo('add-lecturer');
            $roleCoordinator->givePermissionTo('edit-lecturer');
            $roleCoordinator->givePermissionTo('delete-lecturer');
            $roleCoordinator->givePermissionTo('show-lecturer');
            // student 
            $roleCoordinator->givePermissionTo('read-student');
            $roleCoordinator->givePermissionTo('add-student');
            $roleCoordinator->givePermissionTo('edit-student');
            $roleCoordinator->givePermissionTo('delete-student');
            // topic 
            $roleCoordinator->givePermissionTo('read-topic');
            $roleCoordinator->givePermissionTo('add-topic');
            $roleCoordinator->givePermissionTo('edit-topic');
            $roleCoordinator->givePermissionTo('delete-topic');
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


        
        $roleStudent = Role::findByName('student');
            // lecturer 
            $roleStudent->givePermissionTo('read-lecturer');
            $roleStudent->givePermissionTo('show-lecturer');
            // student 
            $roleStudent->givePermissionTo('read-student');
            // proposal 
            $roleStudent->givePermissionTo('read-proposal');
            // proposal submit 
            $roleStudent->givePermissionTo('read-proposal-submit');
            $roleStudent->givePermissionTo('add-proposal-submit');
            $roleStudent->givePermissionTo('edit-proposal-submit');
            $roleStudent->givePermissionTo('similarity-submit');
            $roleStudent->givePermissionTo('add-similarity-submit');


        $roleLecturer = Role::findByName('lecturer');
            // lecturer 
            $roleLecturer->givePermissionTo('read-lecturer');
            $roleLecturer->givePermissionTo('show-lecturer');
            // student 
            $roleLecturer->givePermissionTo('read-student');
            // proposal 
            $roleLecturer->givePermissionTo('read-proposal');

    }
}
