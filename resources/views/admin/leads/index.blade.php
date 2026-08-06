
@extends('layouts.app')

@section('title', 'Leads Management | PackCraft Admin')

@section('content')

<div class="admin-layout container" style="margin-top: 2rem; gap: 2rem;">
    
    <!-- Admin Sidebar -->
    <aside style="background-color: var(--color-primary); color: white; border-radius: var(--border-radius); padding: 2rem 1.5rem; height: fit-content;">
        <h3 style="color: var(--color-accent); font-size: 1.15rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; font-family: var(--font-serif); font-style: italic;">
            <i class="fa-solid fa-gauge-high"></i> Control Panel
        </h3>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.95rem;">
            <li><a href="{{ route('admin.dashboard') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-chart-line" style="width: 20px;"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.leads') }}" class="active" style="color: var(--color-accent); font-weight: 700; display: block; padding: 0.5rem 0.75rem; border-radius: 6px; background-color: rgba(255,255,255,0.05);"><i class="fa-solid fa-envelopes-bulk" style="width: 20px;"></i> Leads Pipeline</a></li>
            <li><a href="{{ route('admin.orders') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-pallet" style="width: 20px;"></i> Orders Stages</a></li>
            <li><a href="{{ route('admin.products') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-box-open" style="width: 20px;"></i> Product Catalog</a></li>
            <li><a href="{{ route('admin.categories') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-tags" style="width: 20px;"></i> Categories</a></li>
            <li><a href="{{ route('admin.blogs') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-regular fa-newspaper" style="width: 20px;"></i> Blog Publisher</a></li>
            <li><a href="{{ route('admin.users') }}" style="display: block; padding: 0.5rem 0.75rem; border-radius: 6px;"><i class="fa-solid fa-users-gear" style="width: 20px;"></i> RBAC Simulator</a></li>
        </ul>
    </aside>

    <!-- Admin Leads Content -->
    <section style="flex: 1;">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-family: var(--font-serif); font-size: 2.25rem; color: var(--color-primary);">Customer Leads Pipeline</h1>
                <p style="opacity: 0.7; margin-bottom:0;">Filter, edit statuses, add follow-up notes, and export leads list to CSV.</p>
            </div>
            
            <a href="{{ route('admin.leads.export') }}" class="btn btn-gold"><i class="fa-solid fa-file-csv" style="margin-right: 0.5rem;"></i> Export to Excel/CSV</a>
        </div>

        <!-- Filter Form -->
        <form action="{{ route('admin.leads') }}" method="GET" style="background-color: var(--color-bg-white); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.25rem; margin-bottom: 2rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, company, style..." class="form-control">
            </div>
            
            <div style="width: 160px;">
                <select name="status" onchange="this.form.submit()" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="New" {{ request('status') === 'New' ? 'selected' : '' }}>New</option>
                    <option value="Contacted" {{ request('status') === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="Follow-Up" {{ request('status') === 'Follow-Up' ? 'selected' : '' }}>Follow-Up</option>
                    <option value="Converted" {{ request('status') === 'Converted' ? 'selected' : '' }}>Converted</option>
                    <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div style="width: 140px;">
                <select name="type" onchange="this.form.submit()" class="form-control">
                    <option value="">All Types</option>
                    <option value="quote" {{ request('type') === 'quote' ? 'selected' : '' }}>Quotes Only</option>
                    <option value="contact" {{ request('type') === 'contact' ? 'selected' : '' }}>Contact Form</option>
                </select>
            </div>

            @if(request()->anyFilled(['search', 'status', 'type']))
                <a href="{{ route('admin.leads') }}" class="btn btn-outline" style="padding: 0.55rem 1rem; border-radius: var(--border-radius); border-width:1px;">Clear</a>
            @endif
        </form>

        <!-- Leads Table -->
        @if($leads->isEmpty())
            <div class="card" style="text-align: center; padding: 4rem;">
                <i class="fa-solid fa-folder-open" style="font-size: 3rem; opacity: 0.15; margin-bottom: 1rem;"></i>
                <h4>No leads found matching criteria.</h4>
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                @foreach($leads as $lead)
                    <div class="card" style="padding: 1.75rem; border-left: 5px solid {{ $lead->type === 'quote' ? 'var(--color-accent)' : 'var(--color-primary)' }};">
                        
                        <div class="flex flex-between" style="border-bottom: 1px solid var(--color-border-light); padding-bottom: 0.75rem; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                            <div>
                                <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: {{ $lead->type === 'quote' ? 'var(--color-accent)' : 'var(--color-primary)' }};">
                                    {{ $lead->type === 'quote' ? 'Custom Quote Request' : 'Contact Us message' }}
                                </span>
                                <h3 style="font-size: 1.15rem; color: var(--color-primary); margin-top: 0.1rem;">{{ $lead->name }}</h3>
                            </div>
                            
                            <span class="badge badge-{{ strtolower($lead->status) }}">{{ $lead->status }}</span>
                        </div>

                        <!-- Details Grid -->
                        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; flex-wrap: wrap;">
                            <!-- Info content -->
                            <div style="font-size: 0.9rem;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                    <div>
                                        <span style="opacity: 0.6; display: block; font-size: 0.75rem; text-transform: uppercase;">Email / Phone</span>
                                        <strong>{{ $lead->email }}</strong>
                                        <span style="display: block; opacity: 0.8;">{{ $lead->phone ?? 'No Phone' }}</span>
                                    </div>
                                    <div>
                                        <span style="opacity: 0.6; display: block; font-size: 0.75rem; text-transform: uppercase;">Company Name</span>
                                        <strong>{{ $lead->company_name ?? 'Individual Client' }}</strong>
                                    </div>
                                </div>

                                @if($lead->type === 'quote')
                                    <div style="background-color: var(--color-bg-light); border-radius: var(--border-radius); padding: 1rem; border: 1px solid var(--color-border-light); margin-bottom: 1rem;">
                                        <strong style="color: var(--color-primary); font-size: 0.85rem; display: block; margin-bottom: 0.5rem; text-transform: uppercase;">Configured Specifications:</strong>
                                        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 1rem;">
                                            <div>
                                                <p style="margin: 0;"><strong>Box Style:</strong> {{ $lead->product_type }}</p>
                                                <p style="margin: 0;"><strong>Material:</strong> {{ $lead->material }}</p>
                                                <p style="margin: 0;"><strong>Dimensions:</strong> {{ $lead->length }}x{{ $lead->width }}x{{ $lead->height }} cm</p>
                                            </div>
                                            <div>
                                                <p style="margin: 0;"><strong>Quantity:</strong> {{ $lead->quantity }} pcs</p>
                                                <p style="margin: 0;">
                                                    <strong>Finishes:</strong> 
                                                    @if($lead->printing_required) Print, @endif
                                                    @if($lead->lamination) Matte, @endif
                                                    @if($lead->embossing) Embossed, @endif
                                                    @if($lead->foil_stamping) Foil, @endif
                                                    @if($lead->window_cutout) Window @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div style="margin-bottom: 1rem;">
                                        <span style="opacity: 0.6; display: block; font-size: 0.75rem; text-transform: uppercase;">Subject</span>
                                        <strong>{{ $lead->product_type }}</strong>
                                    </div>
                                @endif

                                @if($lead->message)
                                    <div>
                                        <span style="opacity: 0.6; display: block; font-size: 0.75rem; text-transform: uppercase;">Message / Details</span>
                                        <p style="margin: 0.25rem 0 0; font-style: italic; opacity: 0.95;">"{{ $lead->message }}"</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Admin inline editor -->
                            <div style="background-color: var(--color-bg-light); border: 1px solid var(--color-border-light); border-radius: var(--border-radius); padding: 1.25rem;">
                                <h4 style="font-size: 0.9rem; margin-bottom: 1rem; color: var(--color-primary); text-transform: uppercase; letter-spacing: 0.5px;"><i class="fa-solid fa-user-pen"></i> Update Lead</h4>
                                
                                <form action="{{ route('admin.leads.update', $lead->id) }}" method="POST">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="status_{{ $lead->id }}">Pipeline Status</label>
                                        <select id="status_{{ $lead->id }}" name="status" class="form-control" style="padding: 0.4rem; font-size: 0.85rem;">
                                            <option value="New" {{ $lead->status === 'New' ? 'selected' : '' }}>New</option>
                                            <option value="Contacted" {{ $lead->status === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                                            <option value="Follow-Up" {{ $lead->status === 'Follow-Up' ? 'selected' : '' }}>Follow-Up</option>
                                            <option value="Converted" {{ $lead->status === 'Converted' ? 'selected' : '' }}>Converted</option>
                                            <option value="Closed" {{ $lead->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 1rem;">
                                        <label for="notes_{{ $lead->id }}">Follow-up Notes</label>
                                        <textarea id="notes_{{ $lead->id }}" name="notes" rows="2" class="form-control" style="font-size: 0.85rem;" placeholder="Sent quote, awaiting artwork files...">{{ $lead->notes }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-secondary" style="width: 100%; padding: 0.45rem; font-size: 0.8rem; border-radius: 6px;">Save Changes</button>
                                </form>
                            </div>
                        </div>

                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="flex flex-center" style="margin-top: 1.5rem;">
                    {{ $leads->links() }}
                </div>
            </div>
        @endif

    </section>

</div>

@endsection
