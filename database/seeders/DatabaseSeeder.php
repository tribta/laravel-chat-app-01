<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('conversation_user')->truncate();
        DB::table('conversations')->truncate();
        DB::table('users')->truncate();
        DB::table('messages')->truncate();
        Schema::enableForeignKeyConstraints();

        # 1 - users
        $users = User::factory(10)->create();

        # 2 - conversations
        $conversations = Conversation::factory(5)->create([
            'created_by' => fn() => $users->random()->id
        ]);

        # 3 - Chèn nhiều users vào 1 conversation
        $conversations->each(function ($conversation) use ($users) {
            // Chọn random từ 2 -> 5 users
            $conversation->users()->attach(
                $users->random(rand(2, 5))->pluck('id')->toArray()
            );
        });

        # 4 - messages
        $conversations->each(function ($conversation) use ($users) {
            Message::factory(rand(5, 15))->create([
                'conversation_id' => $conversation->id,
                'user_id' => $conversation->users->random()->id
            ]);
        });
    }
}
