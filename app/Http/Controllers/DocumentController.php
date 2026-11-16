<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GrahamCampbell\Markdown\Facades\Markdown;

class DocumentController extends Controller
{
    public function show($filename)
    {
    // Check if the requested file exists
    $path = base_path("docs/{$filename}.md");

    if (!file_exists($path)) {
    abort(404, 'Documentation not found');
    }
    // Read the markdown file content
    $content = file_get_contents($path);

    // Convert markdown to HTML
    $htmlContent = Markdown::convertToHtml($content);

    // Return the HTML content to a view
    return view('show', compact('htmlContent'));
    // Make sure
    }
}