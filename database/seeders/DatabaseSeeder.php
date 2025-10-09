<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the BookSeeder which includes categories and books
        $this->call([
            BookSeeder::class,
        ]);
        
        // Create Users
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@library.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
            'is_active' => true,
        ]);

        $pustakawan = User::create([
            'name' => 'Pustakawan',
            'email' => 'pustakawan@library.com',
            'password' => Hash::make('pustakawan123'),
            'role' => 'pustakawan',
            'phone' => '081234567891',
            'address' => 'Jl. Pustakawan No. 2',
            'is_active' => true,
        ]);

        $anggota = User::create([
            'name' => 'Anggota Test',
            'email' => 'anggota@library.com',
            'password' => Hash::make('anggota123'),
            'role' => 'anggota',
            'phone' => '081234567892',
            'address' => 'Jl. Anggota No. 3',
            'is_active' => true,
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Teknologi', 'description' => 'Buku-buku tentang teknologi'],
            ['name' => 'Sejarah', 'description' => 'Buku-buku sejarah'],
            ['name' => 'Sastra', 'description' => 'Buku-buku sastra dan novel'],
            ['name' => 'Sains', 'description' => 'Buku-buku sains dan penelitian'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Books
        $books = [
            [
                'title' => 'Pemrograman Web dengan Laravel',
                'author' => 'John Doe',
                'isbn' => '978-1-234567-89-0',
                'category_id' => 1,
                'description' => 'Panduan lengkap Laravel',
                'stock' => 5,
                'available' => 3,
                'publisher' => 'Tech Publisher',
                'published_year' => 2023,
            ],
            [
                'title' => 'Sejarah Indonesia',
                'author' => 'Jane Smith',
                'isbn' => '978-1-234567-90-6',
                'category_id' => 2,
                'description' => 'Sejarah lengkap Indonesia',
                'stock' => 3,
                'available' => 2,
                'publisher' => 'History Press',
                'published_year' => 2022,
            ],
            [
                'title' => 'Novel Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-1-234567-91-3',
                'category_id' => 3,
                'description' => 'Novel inspiratif',
                'stock' => 10,
                'available' => 8,
                'publisher' => 'Bentang Pustaka',
                'published_year' => 2005,
            ],
        ];

        foreach ($books as $bookData) {
            Book::create($bookData);
        }

        // Create Sample Loans (untuk testing pengembalian)
        $book1 = Book::find(1);
        $book2 = Book::find(2);

        // Loan 1: Normal (belum jatuh tempo)
        Loan::create([
            'user_id' => $anggota->id,
            'book_id' => $book1->id,
            'loan_date' => Carbon::now()->subDays(3),
            'due_date' => Carbon::now()->addDays(4),
            'status' => 'borrowed',
        ]);

        // Loan 2: Overdue (sudah jatuh tempo)
        Loan::create([
            'user_id' => $anggota->id,
            'book_id' => $book2->id,
            'loan_date' => Carbon::now()->subDays(10),
            'due_date' => Carbon::now()->subDays(3),
            'status' => 'overdue',
        ]);

        // Loan 3: Already returned (untuk riwayat)
        Loan::create([
            'user_id' => $anggota->id,
            'book_id' => Book::find(3)->id,
            'loan_date' => Carbon::now()->subDays(20),
            'due_date' => Carbon::now()->subDays(13),
            'return_date' => Carbon::now()->subDays(14),
            'status' => 'returned',
            'condition' => 'good',
            'notes' => 'Buku dikembalikan dalam kondisi baik',
        ]);
    }
}
