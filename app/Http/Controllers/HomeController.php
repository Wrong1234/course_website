<?php
namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    /**
     * Display the homepage with courses and WhatsApp integration
     */
    public function index()
    {
        try {
            // Get courses with module count
            $courses = Course::withCount('modules')->latest()->paginate(3);
            
            // Return view with WhatsApp integration
            return $this->viewWithWhatsApp('courses.index', [
                'courses' => $courses
            ], 'Hello! Welcome to our website!');
            
        } catch (\Exception $e) {
            // Fallback without WhatsApp integration
            $courses = Course::withCount('modules')->latest()->paginate(3);
            
            return view('courses.index', [
                'courses' => $courses,
                'whatsAppUrl' => null,
                'isAvailable' => false,
                'errors' => ['WhatsApp service unavailable']
            ]);
        }
    }

    /**
     * Display contact page with WhatsApp integration
     */
    public function contact()
    {
        // Get WhatsApp data for contact page
        $whatsAppData = $this->getWhatsAppData(
            'Hello! I want to contact you.',
            'Contact Us on WhatsApp',
            'btn btn-primary btn-lg'
        );

        return view('contact', array_merge([
            'pageTitle' => 'Contact Us'
        ], $whatsAppData));
    }
}

