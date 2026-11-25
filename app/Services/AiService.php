<?php

namespace App\Services;

use App\Models\ChatLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    /** @var array<int, array{q: string, a: string}> */
    protected array $faq = [
        [
            'q' => 'how long epoxy cure dry time',
            'a' => 'IronVault epoxy systems typically accept light foot traffic in 24 hours and vehicle traffic in 72 hours, depending on temperature and product system. Full chemical cure is usually 5–7 days.',
        ],
        [
            'q' => 'garage floor cost price estimate',
            'a' => 'Most residential garage epoxy projects in the DFW area run about $6–$12 per sq ft installed, depending on prep, flake package, and topcoat. Request a free on-site measure for an exact quote.',
        ],
        [
            'q' => 'flake metallic solid color systems',
            'a' => 'We install solid-color, full-flake, and metallic epoxy systems for garages, showrooms, warehouses, and commercial kitchens. Flake is most popular for garages; metallic for showrooms and lobbies.',
        ],
        [
            'q' => 'prep grinding moisture vapor',
            'a' => 'Every IronVault job starts with diamond grinding, crack repair, and moisture testing. If vapor transmission is high, we install a moisture vapor barrier before the base coat.',
        ],
        [
            'q' => 'warranty maintenance clean',
            'a' => 'Residential installs include a 5-year workmanship warranty. Clean with a neutral pH cleaner—avoid harsh solvents and steam mops for the first week after install.',
        ],
        [
            'q' => 'commercial warehouse industrial',
            'a' => 'For warehouses and light industrial floors we specify high-build epoxy with urethane or polyaspartic topcoats for abrasion and chemical resistance. We can phase work to keep docks operational.',
        ],
        [
            'q' => 'schedule appointment quote contact',
            'a' => 'Call or text (817) 555-0148, use the contact form, or WhatsApp us. Site visits for Fort Worth, Dallas, Arlington, and surrounding DFW cities are usually available within 2–3 business days.',
        ],
        [
            'q' => 'hot tire pickup peeling bubbles',
            'a' => 'Hot-tire pickup and peeling almost always trace back to poor surface prep or trapped moisture. Our diamond grind + moisture test process is designed to prevent those failures.',
        ],
    ];

    public function chat(string $message, ?string $sessionId = null): array
    {
        $reply = null;
        $source = 'demo';

        if ($key = config('services.openai.key')) {
            try {
                $reply = $this->callOpenAi($message, $key);
                $source = 'openai';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply && ($gemini = config('services.gemini.key'))) {
            try {
                $reply = $this->callGemini($message, $gemini);
                $source = 'gemini';
            } catch (\Throwable) {
                $reply = null;
            }
        }

        if (! $reply) {
            $reply = $this->demoReply($message);
            $source = 'demo';
        }

        ChatLog::query()->create([
            'session_id' => $sessionId,
            'message' => $message,
            'reply' => $reply,
            'source' => $source,
        ]);

        return ['reply' => $reply, 'source' => $source];
    }

    public function generate(string $type, string $prompt): string
    {
        $message = match ($type) {
            'blog' => "Write a concise SEO blog post outline and intro for an epoxy flooring company about: {$prompt}",
            'description' => "Write a compelling product/service description for epoxy flooring: {$prompt}",
            'automation' => "Suggest 5 practical AI automations for an epoxy flooring SME ERP related to: {$prompt}",
            'troubleshoot' => "Troubleshoot this epoxy flooring operations issue with clear steps: {$prompt}",
            default => $prompt,
        };

        $result = $this->chat($message);

        return $result['reply'];
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);
        $best = null;
        $bestScore = 0;

        foreach ($this->faq as $item) {
            $score = 0;
            foreach (explode(' ', $item['q']) as $word) {
                if ($word !== '' && str_contains($hay, $word)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $best = $item['a'];
            }
        }

        if ($best && $bestScore > 0) {
            return $best;
        }

        return 'Thanks for reaching IronVault Epoxy Systems. We install garage, commercial, and warehouse epoxy floors across DFW. Ask about cure times, flake systems, moisture prep, pricing, or scheduling—or call (817) 555-0148 for a free site visit.';
    }

    protected function callOpenAi(string $message, string $key): string
    {
        $response = Http::withToken($key)
            ->timeout(30)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are the IronVault Epoxy Systems assistant for a Fort Worth, TX epoxy flooring installer. Be concise, practical, and focused on garage/commercial/warehouse epoxy floors. Never invent illegal claims.',
                    ],
                    ['role' => 'user', 'content' => $message],
                ],
                'temperature' => 0.4,
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'choices.0.message.content', 'Unable to generate a response.');
    }

    protected function callGemini(string $message, string $key): string
    {
        $model = config('services.gemini.model', 'gemini-1.5-flash');
        $response = Http::timeout(30)
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$key}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "You are IronVault Epoxy Systems assistant (Fort Worth epoxy flooring). Answer briefly:\n{$message}"],
                        ],
                    ],
                ],
            ]);

        $response->throw();

        return (string) data_get($response->json(), 'candidates.0.content.parts.0.text', 'Unable to generate a response.');
    }
}
