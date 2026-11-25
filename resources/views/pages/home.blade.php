@extends('layouts.app')

@section('title', 'IronVault Epoxy Systems')
@section('meta_description', 'Premium garage, commercial, and warehouse epoxy flooring installed across Fort Worth and DFW by IronVault Epoxy Systems.')

@section('content')
<section class="hero">
    <div class="wrap hero-inner">
        <h1>IronVault<br>Epoxy Systems</h1>
        <p>Diamond-prepped slabs. Full-flake garages. High-build commercial floors that take Texas heat, forklifts, and hot tires.</p>
        <div class="hero-ctas">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a site visit</a>
            <a class="btn btn-ghost" href="{{ route('services') }}">View flooring systems</a>
        </div>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <h2>Flooring systems</h2>
        <p class="lede">Purpose-built coatings for residential garages, retail showrooms, and light industrial bays — never a one-size resin pour.</p>
        <div class="grid-3">
            @foreach([
                ['garage-epoxy','Garage Epoxy','Full-flake systems for daily drivers and workshops.','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1200&q=80'],
                ['commercial-epoxy','Commercial Floors','Showroom-ready solid and metallic installs.','https://images.unsplash.com/photo-1504328345607-821a24d1f566?auto=format&fit=crop&w=1200&q=80'],
                ['warehouse-industrial','Warehouse Coatings','Abrasion-ready high-build epoxy for docks.','https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$blurb,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad">
                        <h3>{{ $title }}</h3>
                        <p>{{ $blurb }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Why IronVault</h2>
        <p class="lede">Fort Worth crews that treat moisture testing and profile as non-negotiable — because coatings fail from the slab up.</p>
        <div class="grid-3">
            <div class="panel">
                <h3>Moisture-first prep</h3>
                <p>Every slab is ground, repaired, and vapor-tested before resin. No shortcuts under the film.</p>
            </div>
            <div class="panel">
                <h3>Spec-matched systems</h3>
                <p>Flake for garages, metallic for lobbies, high-build + polyaspartic for warehouses and open bays.</p>
            </div>
            <div class="panel">
                <h3>ERP-run jobs</h3>
                <p>Quotes, installs, invoices, and follow-ups live in one operations stack — fewer dropped balls.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>Ops dashboard preview</h2>
        <p class="lede">A glimpse of the IronVault ERP used to schedule crews, track materials, and close invoices.</p>
        <div class="dash-preview">
            <div>
                <div class="grid-3" style="grid-template-columns:repeat(3,1fr)">
                    <div class="metric"><strong>24</strong> Active jobs</div>
                    <div class="metric"><strong>$186k</strong> Pipeline</div>
                    <div class="metric"><strong>18</strong> Site visits</div>
                </div>
                <div class="bars">
                    <span style="height:40%"></span><span style="height:65%"></span><span style="height:50%"></span>
                    <span style="height:80%"></span><span style="height:55%"></span><span style="height:90%"></span>
                    <span style="height:70%"></span>
                </div>
            </div>
            <div>
                <h3 style="font-family:var(--font-display);text-transform:uppercase;margin-top:0">Live modules</h3>
                <ul style="line-height:1.9;padding-left:1.1rem;color:rgba(255,255,255,.86)">
                    <li>Jobs & scheduling</li>
                    <li>Resin / flake inventory</li>
                    <li>Invoices & payments</li>
                    <li>AI content + troubleshooting</li>
                </ul>
                <a class="btn btn-primary" style="margin-top:1rem" href="/admin">Open admin ERP</a>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0">
    <div class="wrap">
        <h2>From the shop floor</h2>
        <p class="lede">Guides and field notes for homeowners and facility managers.</p>
        <div class="grid-3">
            @forelse($posts as $post)
                <a class="panel" href="{{ route('blog.show', $post->slug) }}">
                    <h3>{{ $post->title }}</h3>
                    <p>{{ $post->excerpt }}</p>
                </a>
            @empty
                <div class="panel"><p>Blog posts will appear after seeding.</p></div>
            @endforelse
        </div>
    </div>
</section>
@endsection
