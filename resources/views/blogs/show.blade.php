@extends('layouts.app')

@section('title', $post->title . ' | PackCraft Blog')
@section('meta_description', $post->excerpt)

@section('content')

<section style="padding: 3rem 0;">
    <div class="container">
        
        <!-- Breadcrumbs -->
        <nav style="font-size: 0.85rem; opacity: 0.6; margin-bottom: 2rem;">
            <a href="{{ route('home') }}">Home</a> &gt; 
            <a href="{{ route('blogs.index') }}">Blog</a> &gt; 
            <span>{{ $post->title }}</span>
        </nav>

        <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 4rem; align-items: start;">
            
            <!-- Main Article Content -->
            <article class="card" style="padding: 3rem;">
                <header style="margin-bottom: 2rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 1.5rem;">
                    <span style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: var(--color-accent); letter-spacing: 1px; display: inline-block; margin-bottom: 0.5rem;">
                        {{ $post->category }}
                    </span>
                    <h1 style="font-family: var(--font-serif); font-size: 2.5rem; line-height: 1.2; margin-bottom: 1rem; color: var(--color-primary);">
                        {{ $post->title }}
                    </h1>
                    <div style="font-size: 0.9rem; opacity: 0.6; display: flex; gap: 1.5rem;">
                        <span><i class="fa-regular fa-calendar-days" style="margin-right: 0.25rem;"></i> {{ $post->published_at->format('F d, Y') }}</span>
                        <span><i class="fa-regular fa-clock" style="margin-right: 0.25rem;"></i> 4 min read</span>
                    </div>
                </header>

                <!-- Featured Image placeholder -->
                <div style="height: 350px; background-size: cover; background-position: center; background-image: url('https://picsum.photos/seed/{{ $post->id }}/800/450'); border-radius: var(--border-radius); margin-bottom: 2.5rem;"></div>

                <!-- Rich Text content -->
                <div class="blog-body-text" style="font-size: 1.1rem; line-height: 1.8; opacity: 0.9;">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </article>

            <!-- Sidebar (Recent Posts & CTAs) -->
            <aside style="display: flex; flex-direction: column; gap: 2.5rem;">
                <!-- Call to Action Card -->
                <div class="card" style="background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%); color: white;">
                    <h3 style="color: white; font-family: var(--font-serif); margin-bottom: 0.75rem;">Need Samples?</h3>
                    <p style="font-size: 0.9rem; opacity: 0.85; margin-bottom: 1.5rem;">Configure custom mailers or shipping crates and receive a sample pack containing material types (Kraft, board layers).</p>
                    <a href="{{ route('quote.form') }}" class="btn btn-gold" style="width: 100%; text-align: center;">Request Estimate</a>
                </div>

                <!-- Recent Posts list -->
                <div class="card">
                    <h3 style="font-size: 1.1rem; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.5rem; color: var(--color-primary);">Recent Articles</h3>
                    
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 1.25rem;">
                        @foreach($recentPosts as $recent)
                            <li style="display: flex; gap: 1rem; align-items: start;">
                                <div style="width: 60px; height: 60px; background-size: cover; background-position: center; background-image: url('https://picsum.photos/seed/{{ $recent->id }}/100/100'); border-radius: 6px; flex-shrink: 0;"></div>
                                <div>
                                    <h4 style="font-size: 0.9rem; font-weight: 600; line-height: 1.3; margin-bottom: 0.25rem;">
                                        <a href="{{ route('blogs.show', $recent->slug) }}" style="color: var(--color-primary);">{{ $recent->title }}</a>
                                    </h4>
                                    <span style="font-size: 0.75rem; opacity: 0.5;">{{ $recent->published_at->format('M d, Y') }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

        </div>

    </div>
</section>

@endsection
