@extends('layouts.app')
@section('title', 'Epoxy Flooring Services')
@section('content')
<section class="section">
    <div class="wrap">
        <h2>Services</h2>
        <p class="lede">IronVault installs garage, commercial, warehouse, and specialty metallic systems with moisture-controlled prep.</p>
        <div class="grid-3">
            @foreach([
                ['garage-epoxy','Garage Epoxy Flooring','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1200&q=80'],
                ['commercial-epoxy','Commercial & Retail','https://images.unsplash.com/photo-1504328345607-821a24d1f566?auto=format&fit=crop&w=1200&q=80'],
                ['warehouse-industrial','Warehouse & Industrial','https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=1200&q=80'],
                ['metallic-systems','Metallic Systems','https://images.unsplash.com/photo-1615874959474-d609969a20ed?auto=format&fit=crop&w=1200&q=80'],
                ['concrete-prep','Concrete Prep & MVB','https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=1200&q=80'],
                ['polyaspartic-topcoat','Polyaspartic Topcoats','https://images.unsplash.com/photo-1621905252507-b35492a56f0b?auto=format&fit=crop&w=1200&q=80'],
            ] as [$slug,$title,$img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="pad"><h3>{{ $title }}</h3></div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
