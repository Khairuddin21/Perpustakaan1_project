<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories first
        $categories = [
            'Teknologi & Pemrograman',
            'Fiksi & Sastra',
            'Bisnis & Ekonomi',
            'Sains & Matematika',
            'Sejarah',
            'Biografi',
            'Kesehatan',
            'Pendidikan'
        ];

        foreach ($categories as $categoryName) {
            Category::firstOrCreate(['name' => $categoryName]);
        }

        // Get categories for reference
        $tech = Category::where('name', 'Teknologi & Pemrograman')->first();
        $fiction = Category::where('name', 'Fiksi & Sastra')->first();
        $business = Category::where('name', 'Bisnis & Ekonomi')->first();
        $science = Category::where('name', 'Sains & Matematika')->first();
        $history = Category::where('name', 'Sejarah')->first();
        $biography = Category::where('name', 'Biografi')->first();
        $health = Category::where('name', 'Kesehatan')->first();
        $education = Category::where('name', 'Pendidikan')->first();

        // Sample books with cover images
        $books = [
            [
                'title' => 'Laravel: Up & Running',
                'author' => 'Matt Stauffer',
                'isbn' => '9781491936672',
                'category_id' => $tech->id,
                'description' => 'A comprehensive guide to building modern web applications with Laravel framework.',
                'stock' => 5,
                'available' => 3,
                'publisher' => "O'Reilly Media",
                'published_year' => 2019,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9781491936672-L.jpg'
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'category_id' => $tech->id,
                'description' => 'A handbook of agile software craftsmanship with best practices for writing clean, maintainable code.',
                'stock' => 8,
                'available' => 6,
                'publisher' => 'Prentice Hall',
                'published_year' => 2008,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780132350884-L.jpg'
            ],
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '9780743273565',
                'category_id' => $fiction->id,
                'description' => 'A classic American novel set in the summer of 1922 on Long Island and in New York City.',
                'stock' => 10,
                'available' => 8,
                'publisher' => 'Scribner',
                'published_year' => 1925,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780743273565-L.jpg'
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '9780061120084',
                'category_id' => $fiction->id,
                'description' => 'A gripping tale of racial injustice and childhood innocence in the American South.',
                'stock' => 7,
                'available' => 5,
                'publisher' => 'Harper Perennial',
                'published_year' => 1960,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780061120084-L.jpg'
            ],
            [
                'title' => 'Think and Grow Rich',
                'author' => 'Napoleon Hill',
                'isbn' => '9781585424337',
                'category_id' => $business->id,
                'description' => 'The classic guide to achieving success and wealth through positive thinking.',
                'stock' => 6,
                'available' => 4,
                'publisher' => 'Jeremy P. Tarcher',
                'published_year' => 1937,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9781585424337-L.jpg'
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'isbn' => '9780307887894',
                'category_id' => $business->id,
                'description' => 'How todays entrepreneurs use continuous innovation to create radically successful businesses.',
                'stock' => 4,
                'available' => 2,
                'publisher' => 'Crown Business',
                'published_year' => 2011,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780307887894-L.jpg'
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'isbn' => '9780553380163',
                'category_id' => $science->id,
                'description' => 'From the Big Bang to black holes, a journey through the universe.',
                'stock' => 5,
                'available' => 3,
                'publisher' => 'Bantam',
                'published_year' => 1988,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780553380163-L.jpg'
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9780062316097',
                'category_id' => $history->id,
                'description' => 'How Homo sapiens became the dominant species on Earth.',
                'stock' => 8,
                'available' => 6,
                'publisher' => 'Harper',
                'published_year' => 2014,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780062316097-L.jpg'
            ],
            [
                'title' => 'Steve Jobs',
                'author' => 'Walter Isaacson',
                'isbn' => '9781451648539',
                'category_id' => $biography->id,
                'description' => 'The exclusive biography of Apple co-founder Steve Jobs.',
                'stock' => 3,
                'available' => 1,
                'publisher' => 'Simon & Schuster',
                'published_year' => 2011,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9781451648539-L.jpg'
            ],
            [
                'title' => 'Becoming',
                'author' => 'Michelle Obama',
                'isbn' => '9781524763138',
                'category_id' => $biography->id,
                'description' => 'An intimate, powerful, and inspiring memoir by the former First Lady.',
                'stock' => 6,
                'available' => 4,
                'publisher' => 'Crown',
                'published_year' => 2018,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9781524763138-L.jpg'
            ],
            [
                'title' => 'JavaScript: The Good Parts',
                'author' => 'Douglas Crockford',
                'isbn' => '9780596517748',
                'category_id' => $tech->id,
                'description' => 'A guide to the elegant parts of JavaScript and how to use them effectively.',
                'stock' => 4,
                'available' => 2,
                'publisher' => "O'Reilly Media",
                'published_year' => 2008,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780596517748-L.jpg'
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'isbn' => '9780061122415',
                'category_id' => $fiction->id,
                'description' => 'A mystical story about Santiago, an Andalusian shepherd boy who follows his dreams.',
                'stock' => 9,
                'available' => 7,
                'publisher' => 'HarperOne',
                'published_year' => 1988,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780061122415-L.jpg'
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '9780735211292',
                'category_id' => $health->id,
                'description' => 'An easy and proven way to build good habits and break bad ones.',
                'stock' => 7,
                'available' => 5,
                'publisher' => 'Avery',
                'published_year' => 2018,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780735211292-L.jpg'
            ],
            [
                'title' => 'Educated',
                'author' => 'Tara Westover',
                'isbn' => '9780399590504',
                'category_id' => $education->id,
                'description' => 'A memoir about a woman who grows up in a survivalist family and eventually earns a PhD.',
                'stock' => 5,
                'available' => 3,
                'publisher' => 'Random House',
                'published_year' => 2018,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9780399590504-L.jpg'
            ],
            [
                'title' => 'The 7 Habits of Highly Effective People',
                'author' => 'Stephen R. Covey',
                'isbn' => '9781982137274',
                'category_id' => $business->id,
                'description' => 'Powerful lessons in personal change for achieving effectiveness in life and work.',
                'stock' => 6,
                'available' => 4,
                'publisher' => 'Simon & Schuster',
                'published_year' => 1989,
                'cover_image' => 'https://covers.openlibrary.org/b/isbn/9781982137274-L.jpg'
            ]
        ];

        foreach ($books as $bookData) {
            Book::firstOrCreate(['isbn' => $bookData['isbn']], $bookData);
        }
    }
}
