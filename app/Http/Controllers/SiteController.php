<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function services(): View
    {
        return view('pages.services');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks! IronVault will follow up within one business day.');
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('category')->orderBy('title')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'session_id' => ['nullable', 'string', 'max:80'],
        ]);

        $result = $ai->chat($data['message'], $data['session_id'] ?? null);

        return response()->json($result);
    }

    /** @return array<string, array<string, string>> */
    protected function serviceCatalog(): array
    {
        return [
            'garage-epoxy' => [
                'title' => 'Garage Epoxy Flooring',
                'summary' => 'Full-flake and solid-color systems built for hot tires, oil, and daily family traffic.',
                'body' => 'IronVault diamond-grinds every slab, repairs cracks, and installs multi-coat epoxy with UV-stable polyaspartic topcoats so your garage stays bright and easy to clean for years.',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1600&q=80',
            ],
            'commercial-epoxy' => [
                'title' => 'Commercial & Retail Floors',
                'summary' => 'Showroom-ready metallic and solid systems for retail, auto, and office spaces.',
                'body' => 'From dealership showrooms to boutique retail, we engineer coatings that look premium under LED lighting while standing up to carts, lifts, and foot traffic.',
                'image' => 'https://images.unsplash.com/photo-1504328345607-821a24d1f566?auto=format&fit=crop&w=1600&q=80',
            ],
            'warehouse-industrial' => [
                'title' => 'Warehouse & Light Industrial',
                'summary' => 'High-build epoxy with chemical-resistant topcoats for docks and production floors.',
                'body' => 'We phase installs around shipping schedules, specify abrasion-resistant systems, and can add line striping and safety markings for forklift aisles.',
                'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1600&q=80',
            ],
            'metallic-systems' => [
                'title' => 'Metallic Epoxy Systems',
                'summary' => 'Depth and movement for lobbies, studios, and high-end residential spaces.',
                'body' => 'Custom metallic pigment blends create one-of-a-kind floors. Ideal when the floor is part of the brand experience.',
                'image' => 'https://images.unsplash.com/photo-1615874959474-d609969a20ed?auto=format&fit=crop&w=1600&q=80',
            ],
            'concrete-prep' => [
                'title' => 'Concrete Prep & Moisture Control',
                'summary' => 'Diamond grinding, crack repair, and vapor barriers that protect the coating.',
                'body' => 'Most coating failures start under the film. Our prep protocol includes profile testing and moisture readings before any resin hits the slab.',
                'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1600&q=80',
            ],
            'polyaspartic-topcoat' => [
                'title' => 'Polyaspartic Topcoats',
                'summary' => 'Fast-cure UV protection for high-traffic residential and commercial floors.',
                'body' => 'When downtime matters, polyaspartic topcoats deliver rapid return-to-service with excellent UV stability—perfect for Texas sun exposure in open bays.',
                'image' => 'https://images.unsplash.com/photo-1621905252507-b35492a56f0b?auto=format&fit=crop&w=1600&q=80',
            ],
        ];
    }
}
