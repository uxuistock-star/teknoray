<?php

namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index()
    {
        // Fetch data (will use mock if DB fails)
        $projects = \App\Models\Project::all();
        $services = \App\Models\Service::all();
        $slides = \App\Models\Slider::allActive();

        return View::render('home', [
            'title' => 'Ana Sayfa',
            'projects' => $projects,
            'services' => $services,
            'slides' => $slides
        ]);
    }

    public function projects()
    {
        $projects = \App\Models\Project::all();
        return View::render('projects', ['title' => 'Projeler', 'projects' => $projects]);
    }

    public function services()
    {
        $services = \App\Models\Service::all();
        return View::render('services', ['title' => 'Hizmetler', 'services' => $services]);
    }

    public function references()
    {
        $logos = [];
        try {
            $logos = \App\Models\ReferenceLogo::all();
        } catch (\Throwable $e) {
            $logos = [];
        }

        return View::render('references', [
            'title' => 'Referanslar',
            'logos' => $logos
        ]);
    }

    public function contact()
    {
        return View::render('contact', ['title' => 'İletişim']);
    }

    public function projectDetail(string $slug)
    {
        $project = \App\Models\Project::findBySlug($slug);

        if (!$project) {
            return "404 - Proje Bulunamadı";
        }

        // Prepare project data for view
        $project = \App\Models\Project::prepareForView($project);

        return View::render('project-detail', [
            'title' => $project['title'],
            'project' => $project
        ]);
    }
}
