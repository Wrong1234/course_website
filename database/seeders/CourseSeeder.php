<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Module;
use App\Models\Content;
use Illuminate\Support\Facades\Schema;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        // Content::truncate();
        // Module::truncate();
        // Course::truncate();
        // Schema::enableForeignKeyConstraints();
        // Create sample course
        $course = Course::create([
            'title' => 'Complete Web Development Bootcamp',
            'description' => 'Learn web development from scratch including HTML, CSS, JavaScript, PHP, Laravel and more. Build real-world projects and become a full-stack developer.',
            'duration' => '12 weeks',
            'price' => 299.99,
            'thumbnail' => 'uploads/courses/web-development-bootcamp.jpg',
        ]);

        // Create Module 1
        $module1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Frontend Fundamentals',
            'description' => 'Learn the basics of HTML, CSS, and JavaScript',
            'duration' => '3 weeks',
        ]);

        // Contents for Module 1
        Content::create([
            'module_id' => $module1->id,
            'title' => 'HTML Introduction',
            'type' => Content::TYPE_TEXT,
            'content' => 'HTML (HyperText Markup Language) is the standard markup language for creating web pages...',
        ]);

        Content::create([
            'module_id' => $module1->id,
            'title' => 'CSS Styling Basics',
            'type' => Content::TYPE_VIDEO,
            'content' => 'Learn how to style your HTML elements with CSS',
            'url' => 'https://youtube.com/watch?v=example1',
        ]);

        Content::create([
            'module_id' => $module1->id,
            'title' => 'JavaScript Fundamentals',
            'type' => Content::TYPE_TEXT,
            'content' => 'JavaScript is a programming language that adds interactivity to your website...',
        ]);

        Content::create([
            'module_id' => $module1->id,
            'title' => 'HTML Cheat Sheet',
            'type' => Content::TYPE_FILE,
            'content' => 'Download this comprehensive HTML cheat sheet for quick reference',
            'url' => 'uploads/html-cheat-sheet.pdf',
        ]);

        // Create Module 2
        $module2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Backend Development with PHP',
            'description' => 'Learn server-side programming with PHP and MySQL',
            'duration' => '4 weeks',
        ]);

        // Contents for Module 2
        Content::create([
            'module_id' => $module2->id,
            'title' => 'PHP Introduction',
            'type' => Content::TYPE_TEXT,
            'content' => 'PHP is a server-side scripting language designed for web development...',
        ]);

        Content::create([
            'module_id' => $module2->id,
            'title' => 'Database Basics with MySQL',
            'type' => Content::TYPE_VIDEO,
            'content' => 'Learn how to work with MySQL databases',
            'url' => 'https://youtube.com/watch?v=example2',
        ]);

        Content::create([
            'module_id' => $module2->id,
            'title' => 'PHP Assignment 1',
            'type' => Content::TYPE_ASSIGNMENT,
            'content' => 'Build a simple contact form using PHP. Requirements: Form validation, email sending, and database storage.',
        ]);

        // Create Module 3
        $module3 = Module::create([
            'course_id' => $course->id,
            'title' => 'Laravel Framework',
            'description' => 'Master the Laravel PHP framework for modern web applications',
            'duration' => '5 weeks',
        ]);

        // Contents for Module 3
        Content::create([
            'module_id' => $module3->id,
            'title' => 'Laravel Installation & Setup',
            'type' => Content::TYPE_TEXT,
            'content' => 'Learn how to install and set up Laravel framework...',
        ]);

        Content::create([
            'module_id' => $module3->id,
            'title' => 'MVC Architecture Explained',
            'type' => Content::TYPE_VIDEO,
            'content' => 'Understanding the Model-View-Controller pattern in Laravel',
            'url' => 'https://youtube.com/watch?v=example3',
        ]);

        Content::create([
            'module_id' => $module3->id,
            'title' => 'Laravel Documentation',
            'type' => Content::TYPE_LINK,
            'content' => 'Official Laravel documentation for reference',
            'url' => 'https://laravel.com/docs',
        ]);

        Content::create([
            'module_id' => $module3->id,
            'title' => 'Final Project Quiz',
            'type' => Content::TYPE_QUIZ,
            'content' => 'Test your knowledge of Laravel concepts before the final project',
            'url' => 'https://example.com/quiz',
            'video_length' => '15 minutes',
        ]);
    }
}
