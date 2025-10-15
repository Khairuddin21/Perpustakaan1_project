<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookRating;
use App\Models\BookComment;
use App\Models\User;

class BookDetailsSeeder extends Seeder
{
    public function run(): void
    {
        // Get first book
        $book = Book::first();
        
        if (!$book) {
            $this->command->warn('No books found. Please run BookSeeder first.');
            return;
        }

        // Get users
        $users = User::take(5)->get();
        
        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please create users first.');
            return;
        }

        // Add sample ratings
        foreach ($users as $index => $user) {
            BookRating::updateOrCreate(
                ['user_id' => $user->id, 'book_id' => $book->id],
                ['rating' => rand(3, 5)]
            );
        }

        // Add sample comments
        $comments = [
            'Buku yang sangat menarik dan informatif. Sangat direkomendasikan!',
            'Penyampaiannya mudah dipahami, cocok untuk pemula.',
            'Salah satu buku terbaik yang pernah saya baca di perpustakaan ini.',
            'Isi bukunya lengkap dan detail. Terima kasih perpustakaan!',
            'Buku yang bagus untuk menambah wawasan.',
        ];

        foreach ($users as $index => $user) {
            if ($index < count($comments)) {
                BookComment::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'comment' => $comments[$index]
                ]);
            }
        }

        $this->command->info('Book details seeded successfully!');
    }
}
