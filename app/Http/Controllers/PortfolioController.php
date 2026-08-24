<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function home()
    {
        $profile = Profile::first();
        $education = Education::where('is_visible', true)->orderBy('start_date', 'desc')->get();
        $categories = SkillCategory::where('is_visible', true)->with(['skills' => fn ($query) => $query->where('is_visible', true)])->get();
        $experiences = Experience::where('is_visible', true)->orderBy('start_date', 'desc')->get();
        $projects = Project::where('is_visible', true)->with(['images', 'skills', 'experience'])->get();

        return Inertia::render('Portfolio/Home', [
            'profile' => $profile,
            'education' => $education,
            'categories' => $categories,
            'experiences' => $experiences,
            'projects' => $projects,
        ]);
    }

    public function about()
    {
        return redirect()->route('home', ['#about']);
    }

    public function skills()
    {
        return redirect()->route('home', ['#skills']);
    }

    public function experience()
    {
        return redirect()->route('home', ['#experience']);
    }

    public function projects()
    {
        return redirect()->route('home', ['#projects']);
    }
    
    public function contact()
    {
        return redirect()->route('home', ['#contact']);
    }

    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $message = \App\Models\Message::create($validated);

        $users = \App\Models\User::all();
        if ($users->isNotEmpty()) {
            \Illuminate\Support\Facades\Notification::send($users, new \App\Notifications\NewContactMessageNotification($message));
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
