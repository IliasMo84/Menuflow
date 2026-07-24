@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestion des Tables & QR Codes</h1>
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createTableModal">
        <i class="fa-solid fa-plus me-2"></i>Nouvelle Table
    </button>
</div>

<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
    @forelse($tables as $table)
        @php
            // Récupération sécurisée du slug avec valeur de secours (fallback)
            $restaurantSlug = $restaurant->slug ?? \Illuminate\Support\Str::slug($restaurant->name ?? 'mon-restaurant');

            // Construction de l'URL sécurisée sans risque de paramètre manquant
            $menuUrl = route('public.menu', [
                'slug' => $restaurantSlug ?: 'menu',
                'table' => $table->code
            ]);
        @endphp

        <div class="col">
            <div class="card h-100 border-0 shadow-sm rounded-3 text-center p-3">
                <div class="card-body d-flex flex-column align-items-center">

                    <h5 class="fw-bold mb-1">{{ $table->number }}</h5>

                    @if($table->capacity)
                        <span class="badge bg-light text-dark border mb-3">
                            <i class="fa-solid fa-users me-1"></i>
                            {{ $table->capacity }} places
                        </span>
                    @endif

                    <!-- Génération dynamique du QR Code SVG -->
                    <div class="p-2 bg-white border rounded mb-3">
                        {!! QrCode::size(140)->generate($menuUrl) !!}
                    </div>

                    <div class="mt-auto w-100 d-flex justify-content-between align-items-center">

                        <!-- Ouvrir / Tester le menu -->
                        <a href="{{ $menuUrl }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="Tester le lien du menu">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>

                        <form action="{{ route('tables.destroy', $table) }}" method="POST" onsubmit="return confirm('Supprimer cette table ?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @empty

        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3 text-center py-5">
                <div class="card-body">
                    <i class="fa-solid fa-qrcode fa-3x text-muted mb-3"></i>

                    <p class="text-muted mb-0">
                        Aucune table créée pour le moment. Cliquez sur "Nouvelle Table" pour générer vos premiers QR Codes !
                    </p>
                </div>
            </div>
        </div>

    @endforelse
</div>

<!-- Modal Créer une table -->
<div class="modal fade" id="createTableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('tables.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nouvelle Table</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="number" class="form-label fw-semibold">
                            Nom / Numéro de la table <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="number"
                            name="number"
                            placeholder="ex: Table 1, Terrasse 4..."
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label fw-semibold">
                            Capacité (personnes)
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="capacity"
                            name="capacity"
                            placeholder="ex: 4"
                            min="1">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-warning">
                        Générer la table & QR Code
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection