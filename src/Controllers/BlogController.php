<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController
{
    public function index()
    {
        $posts = BlogPost::all();
        $categories = BlogCategory::all();

        return View::render('blog/index', [
            'title' => 'Blog & Haberler',
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function show(string $slug)
    {
        $post = BlogPost::findBySlug($slug);

        if (!$post) {
            return "404 - Blog Yazısı Bulunamadı";
        }

        return View::render('blog/show', [
            'title' => $post['title'],
            'post' => $post
        ]);
    }
}
