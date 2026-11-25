<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(817) 555-0100',
            ]
        );
        $admin->syncRoles(['admin']);

        User::query()->updateOrCreate(
            ['email' => 'manager@ironvaultepoxy.com'],
            [
                'name' => 'Maya Ortiz',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(817) 555-0101',
            ]
        )->syncRoles(['manager']);

        User::query()->updateOrCreate(
            ['email' => 'crew@ironvaultepoxy.com'],
            [
                'name' => 'Derek Hale',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(817) 555-0102',
            ]
        )->syncRoles(['staff']);

        $settings = [
            'company_name' => 'IronVault Epoxy Systems',
            'company_phone' => '(817) 555-0148',
            'company_email' => 'hello@ironvaultepoxy.com',
            'whatsapp' => '18175550148',
            'service_area' => 'Fort Worth, Dallas, Arlington & DFW',
            'tax_rate' => '8.25',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => 'Industrial Epoxy Base Kit (3 gal)', 'sku' => 'EPX-BASE-3', 'category' => 'resin', 'unit_cost' => 95, 'unit_price' => 165, 'stock_qty' => 42],
            ['name' => 'Fast Hardener Pack', 'sku' => 'EPX-HARD-F', 'category' => 'hardener', 'unit_cost' => 38, 'unit_price' => 68, 'stock_qty' => 60],
            ['name' => 'Full Flake Blend — Graphite', 'sku' => 'FLK-GRP-40', 'category' => 'flake', 'unit_cost' => 52, 'unit_price' => 96, 'stock_qty' => 28],
            ['name' => 'Full Flake Blend — Ember', 'sku' => 'FLK-EMB-40', 'category' => 'flake', 'unit_cost' => 52, 'unit_price' => 96, 'stock_qty' => 21],
            ['name' => 'Metallic Pigment — Copper Drift', 'sku' => 'MET-CPR-1', 'category' => 'metallic', 'unit_cost' => 28, 'unit_price' => 54, 'stock_qty' => 35],
            ['name' => 'Polyaspartic Topcoat Kit', 'sku' => 'PAS-TOP-2', 'category' => 'topcoat', 'unit_cost' => 120, 'unit_price' => 210, 'stock_qty' => 18],
            ['name' => 'Moisture Vapor Barrier Primer', 'sku' => 'MVB-PRM-5', 'category' => 'primer', 'unit_cost' => 140, 'unit_price' => 240, 'stock_qty' => 14],
            ['name' => 'Diamond Cup Wheel Pack', 'sku' => 'TL-DCW-3', 'category' => 'tool', 'unit_cost' => 65, 'unit_price' => 110, 'stock_qty' => 12],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + ['unit' => 'kit', 'is_active' => true]);
        }

        $customers = collect([
            ['name' => 'Jordan Blake', 'email' => 'jordan@example.com', 'phone' => '(817) 555-2201', 'company' => null, 'city' => 'Fort Worth', 'state' => 'TX', 'zip' => '76107', 'address' => '1842 Crestline Dr'],
            ['name' => 'Priya Nair', 'email' => 'priya@lakeviewautos.com', 'phone' => '(214) 555-2210', 'company' => 'Lakeview Autos', 'city' => 'Dallas', 'state' => 'TX', 'zip' => '75201', 'address' => '900 Commerce St'],
            ['name' => 'Marcus Webb', 'email' => 'ops@northbaylogistics.com', 'phone' => '(817) 555-2299', 'company' => 'North Bay Logistics', 'city' => 'Arlington', 'state' => 'TX', 'zip' => '76011', 'address' => '4100 Industrial Blvd'],
            ['name' => 'Elena Ruiz', 'email' => 'elena.ruiz@example.com', 'phone' => '(682) 555-2188', 'company' => null, 'city' => 'Keller', 'state' => 'TX', 'zip' => '76248', 'address' => '55 Prairie Ridge'],
            ['name' => 'Chris Patel', 'email' => 'chris@brightbayfitness.com', 'phone' => '(469) 555-2177', 'company' => 'BrightBay Fitness', 'city' => 'Plano', 'state' => 'TX', 'zip' => '75024', 'address' => '2200 Legacy Dr'],
        ])->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $projects = [
            ['customer' => 0, 'title' => '3-car garage full flake', 'service_type' => 'garage', 'status' => 'scheduled', 'sq_ft' => 720, 'quoted_amount' => 6480],
            ['customer' => 1, 'title' => 'Showroom metallic lobby', 'service_type' => 'metallic', 'status' => 'in_progress', 'sq_ft' => 1800, 'quoted_amount' => 23400],
            ['customer' => 2, 'title' => 'Warehouse aisle high-build', 'service_type' => 'warehouse', 'status' => 'quoted', 'sq_ft' => 12000, 'quoted_amount' => 78000],
            ['customer' => 3, 'title' => 'Garage refresh polyaspartic', 'service_type' => 'topcoat', 'status' => 'completed', 'sq_ft' => 480, 'quoted_amount' => 4200, 'final_amount' => 4350],
            ['customer' => 4, 'title' => 'Gym floor solid color system', 'service_type' => 'commercial', 'status' => 'invoiced', 'sq_ft' => 3200, 'quoted_amount' => 27200, 'final_amount' => 26800],
        ];

        $projectModels = [];
        foreach ($projects as $i => $p) {
            $customer = $customers[$p['customer']];
            $projectModels[] = Project::query()->updateOrCreate(
                ['job_number' => 'JOB-26'.str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $customer->id,
                    'title' => $p['title'],
                    'service_type' => $p['service_type'],
                    'status' => $p['status'],
                    'sq_ft' => $p['sq_ft'],
                    'quoted_amount' => $p['quoted_amount'],
                    'final_amount' => $p['final_amount'] ?? null,
                    'start_date' => now()->subDays(10 - $i)->toDateString(),
                    'site_address' => trim(($customer->address ?? '').', '.$customer->city.', '.$customer->state),
                    'notes' => 'Seeded demo job for IronVault ERP.',
                ]
            );
        }

        foreach ([0, 1, 3, 4] as $idx) {
            $project = $projectModels[$idx];
            $invoice = Invoice::query()->updateOrCreate(
                ['invoice_number' => 'INV-26'.str_pad((string) ($idx + 1), 3, '0', STR_PAD_LEFT)],
                [
                    'customer_id' => $project->customer_id,
                    'project_id' => $project->id,
                    'issue_date' => now()->subDays(8 - $idx)->toDateString(),
                    'due_date' => now()->addDays(14)->toDateString(),
                    'subtotal' => $project->final_amount ?? $project->quoted_amount,
                    'tax' => round(($project->final_amount ?? $project->quoted_amount) * 0.0825, 2),
                    'total' => round(($project->final_amount ?? $project->quoted_amount) * 1.0825, 2),
                    'amount_paid' => in_array($project->status, ['completed', 'invoiced'], true) ? round(($project->final_amount ?? $project->quoted_amount) * 1.0825, 2) : 0,
                    'status' => in_array($project->status, ['completed', 'invoiced'], true) ? 'paid' : 'sent',
                ]
            );

            if ($invoice->status === 'paid') {
                Payment::query()->updateOrCreate(
                    ['reference' => 'PMT-'.$invoice->invoice_number],
                    [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->total,
                        'paid_at' => now()->subDays(3)->toDateString(),
                        'method' => 'card',
                        'notes' => 'Demo payment',
                    ]
                );
            }
        }

        Appointment::query()->updateOrCreate(
            ['title' => 'Garage measure — Blake'],
            [
                'customer_id' => $customers[0]->id,
                'project_id' => $projectModels[0]->id,
                'type' => 'measure',
                'starts_at' => now()->addDays(2)->setTime(9, 0),
                'ends_at' => now()->addDays(2)->setTime(10, 0),
                'status' => 'scheduled',
                'location' => $customers[0]->address,
            ]
        );
        Appointment::query()->updateOrCreate(
            ['title' => 'Warehouse install day 1'],
            [
                'customer_id' => $customers[2]->id,
                'project_id' => $projectModels[2]->id,
                'type' => 'install',
                'starts_at' => now()->addDays(9)->setTime(7, 0),
                'ends_at' => now()->addDays(9)->setTime(17, 0),
                'status' => 'confirmed',
                'location' => $customers[2]->address,
            ]
        );

        $posts = [
            [
                'title' => 'Why Hot-Tire Pickup Happens on Cheap Garage Coatings',
                'excerpt' => 'Soft films and skipped moisture tests are the usual suspects — here is how IronVault prevents them.',
                'cover' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1400&q=80',
                'body' => "Hot-tire pickup looks dramatic: a tire print lifts a soft coating on a summer afternoon. In DFW garages it almost always traces back to poor surface profile, trapped moisture, or a topcoat that never reached hardness.\n\nIronVault diamond-grinds every slab, measures vapor transmission, and pairs epoxy base coats with UV-stable polyaspartic topcoats when vehicle traffic is expected within 72 hours. If your floor prints tires, stop driving on it and call for an assessment before the failure spreads.",
            ],
            [
                'title' => 'Flake vs Metallic: Choosing a System for Your Space',
                'excerpt' => 'Garages love flake. Lobbies love metallic. Warehouses want abrasion more than sparkle.',
                'cover' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1400&q=80',
                'body' => "Full-flake systems hide slab imperfections and add slip texture — perfect for residential garages. Metallic systems create depth under showroom lighting but need a cleaner canvas and more controlled pour conditions.\n\nFor warehouses we usually drop decorative flake altogether and specify high-build epoxy with a tough topcoat and optional line striping. Match the chemistry to the traffic, not the Instagram feed.",
            ],
            [
                'title' => 'Moisture Testing Before Any Resin Hits the Slab',
                'excerpt' => 'A five-minute moisture check can save a five-figure redo.',
                'cover' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1400&q=80',
                'body' => "Texas slabs can hold surprising vapor drive after rains or in older warehouses. IronVault tests before priming. When readings are high we install a moisture vapor barrier primer before the decorative system.\n\nSkipping this step is the most expensive shortcut in epoxy flooring. Ask any contractor for their moisture protocol before you sign.",
            ],
        ];
        foreach ($posts as $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                [
                    'title' => $post['title'],
                    'excerpt' => $post['excerpt'],
                    'body' => $post['body'],
                    'cover_image' => $post['cover'],
                    'is_published' => true,
                    'published_at' => now()->subDays(random_int(2, 20)),
                ]
            );
        }

        $articles = [
            ['category' => 'issues', 'title' => 'Peeling near expansion joints', 'body' => "1. Confirm the joint was honored (not bridged with rigid film).\n2. Check for moisture staining on the underside of lifted film.\n3. Cut back to sound coating, re-prep, and use joint-friendly detailing.\n4. Re-coat with the original system chemistry."],
            ['category' => 'issues', 'title' => 'Cloudy or ambered topcoat outdoors', 'body' => "UV-unstable epoxies amber in sunlight. For open bays or doors that stay up, IronVault specifies polyaspartic or aliphatic urethane topcoats. Recoat after mechanical abrading if ambering has already started."],
            ['category' => 'guides', 'title' => 'Garage install day timeline', 'body' => "Day 0: Empty garage, remove baseboards if needed.\nMorning: Grind, vacuum, crack repair, moisture check.\nMidday: Primer / base coat.\nAfternoon: Flake broadcast to rejection.\nNext morning: Scrape, vacuum, polyaspartic topcoat.\n+24h: Foot traffic. +72h: Vehicles."],
            ['category' => 'guides', 'title' => 'How to clean a new epoxy floor', 'body' => "Use a neutral pH cleaner and a soft mop. Avoid harsh solvents and steam for the first week. Place drip pans under classic cars that weep fluids. Sweep grit — grit is sandpaper for topcoats."],
            ['category' => 'admin', 'title' => 'Admin ERP quick start', 'body' => "Login at /admin with admin@example.com / password.\n1. Add customers in CRM.\n2. Create a Job/Project with sq ft and quote.\n3. Schedule appointments for measure/install.\n4. Convert completed jobs to invoices and record payments.\n5. Use AI Studio for blog drafts and troubleshooting suggestions.\n6. Update company Settings for phone, WhatsApp, and tax rate."],
            ['category' => 'admin', 'title' => 'Roles: Admin, Manager, Staff', 'body' => "Admin: full ERP + settings + users.\nManager: jobs, inventory, invoices, scheduling.\nStaff: field-facing records and appointment updates.\nAssign roles on the Users resource."],
            ['category' => 'troubleshoot', 'title' => 'Job running over material estimate', 'body' => "Check actual sq ft vs quote. Confirm extra coats due to porous slab. Log additional kits on the job notes, create a change-order invoice line, and update inventory stock quantities."],
            ['category' => 'troubleshoot', 'title' => 'Chatbot giving demo answers only', 'body' => "Demo mode is expected without API keys. Add OPENAI_API_KEY or GEMINI_API_KEY to .env, then clear config cache. The public chatbot and AI Studio will prefer live models when keys are present."],
        ];
        foreach ($articles as $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'category' => $article['category'],
                    'body' => $article['body'],
                    'is_published' => true,
                ]
            );
        }
    }
}
