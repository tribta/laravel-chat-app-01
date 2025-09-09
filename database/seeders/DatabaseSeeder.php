<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('conversation_user')->truncate();
        DB::table('messages')->truncate();
        DB::table('conversations')->truncate();
        DB::table('users')->truncate();

        Schema::enableForeignKeyConstraints();

        // 1) Users
        $users = User::factory(10)->create();

        // 2) Conversations (một số direct, một số group)
        $conversations = Conversation::factory(5)->create([
            'created_by' => fn () => $users->random()->id,
        ]);

        // 3) Gán users vào conversations (nhiều-nhiều)
        $conversations->each(function ($conversation) use ($users) {
            // chọn ngẫu nhiên 2–5 user tham gia
            $conversation->users()->attach(
                $users->random(rand(2, 5))->pluck('id')->toArray()
            );
        });

        // 4) Messages (mỗi conversation có 5–15 messages)
        $conversations->each(function ($conversation) use ($users) {
            Message::factory(rand(5, 15))->create([
                'conversation_id' => $conversation->id,
                'user_id' => $conversation->users->random()->id,
            ]);
        });
    }
}
