@extends('layouts.app')

@section('title', 'Packaging Blog & Insights | PackCraft')
@section('meta_description', 'Read tips on sustainable box design, how-to tutorials for sizing custom packages, and packaging industry news.')

@section('content')

<section style="padding: 3rem 0;">
    <div class="container">
        
        <div style="text-align: center; max-width: 600px; margin: 0 auto 4rem;">
            <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 0.75rem;">Packaging Tips & Industry Insights</h1>
            <p style="opacity: 0.7;">Learn how to design cost-effective mailers, choose materials, and build a premium unboxing experience for your retail brand.</p>
        </div>

        @if($posts->isEmpty())
            <div style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 4rem; text-align: center;">
                <i class="fa-solid fa-newspaper" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1.5rem;"></i>
                <h3>No articles published yet.</h3>
                <p style="opacity: 0.7;">Check back soon for packaging design guidelines!</p>
            </div>
        @else
            <div class="grid grid-3" style="gap: 2rem; margin-bottom: 3rem;">
                @foreach($posts as $post)
                    <article class="card" style="padding: 0; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <!-- Placeholder image using seed for variety -->
                            <div style="height: 180px; background-size: cover; background-position: center; background-image: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.3)), url('https://picsum.photos/seed/{{ $post->id }}/500/350'); position: relative;">
                                <span style="position: absolute; bottom: 12px; left: 12px; font-size: 0.75rem; font-weight: 600; background: var(--color-accent); color: #1a1d1b; padding: 0.2rem 0.6rem; border-radius: 4px;">
                                    {{ $post->category }}
                                </span>
                            </div>
                            
                            <div style="padding: 1.5rem;">
                                <span style="font-size: 0.8rem; opacity: 0.6; display: block; margin-bottom: 0.5rem;">
                                    <i class="fa-regular fa-calendar-days" style="margin-right: 0.25rem;"></i> 
                                    {{ $post->published_at->format('M d, Y') }}
                                </span>
                                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; line-height: 1.3;">
                                    <a href="{{ route('blogs.show', $post->slug) }}" style="color: var(--color-primary);">{{ $post->title }}</a>
                                </h3>
                                <p style="font-size: 0.9rem; opacity: 0.7; margin-bottom: 0;">{{ $post->excerpt }}</p>
                            </div>
                        </div>
                        
                        <div style="padding: 1.5rem; border-top: 1px solid var(--color-border-light);">
                            <a href="{{ route('blogs.show', $post->slug) }}" class="btn btn-outline" style="width: 100%; text-align: center; padding: 0.45rem; font-size: 0.85rem; border-radius: 6px;">
                                Read Article
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="flex flex-center">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
