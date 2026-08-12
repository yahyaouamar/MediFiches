<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        try {
            $this->call(RelationSeeder::class);
        } catch (\Exception $e) {
            $this->command->error("Seeding failed: " . $e->getMessage());
        }
        try {
            $this->call(RoleSeeder::class);
        } catch (\Exception $e) {
            $this->command->error("Seeding failed: " . $e->getMessage());
        }
        try {
            $this->call(AnimatorSeeder::class);
        } catch (\Exception $e) {
            $this->command->error("Seeding failed: " . $e->getMessage());
        }
        try {
            $this->call(FormFieldSeeder::class);
        } catch (\Exception $e) {
            $this->command->error("Seeding failed: " . $e->getMessage());
        }
        try {
            $this->call(FormRuleSeeder::class);
        } catch (\Exception $e) {
            $this->command->error("Seeding failed: " . $e->getMessage());
        }
    }
}
