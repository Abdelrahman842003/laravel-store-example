<?php

    namespace Database\Seeders;

    use App\Models\Category;
    use App\Models\Product;
    use App\Models\Store;
    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;

    class DatabaseSeeder extends Seeder
    {
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
            //\App\Models\User::factory(2)->create();

            // \App\Models\User::factory()->create([
            //     'name' => 'Test User',
            //     'email' => 'test@example.com',
            // ]);

            Store::factory(5)->create();
            Category::factory(5)->create();
            Product::factory(5)->create();

            //$this->call(UserSeeder::class);
        }
    }
