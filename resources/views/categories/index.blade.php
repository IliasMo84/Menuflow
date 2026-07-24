@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Gestion des Catégories</h1>
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        <i class="fa-solid fa-plus me-2"></i>Nouvelle Catégorie
    </button>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 80px;">Ordre</th>
                        <th>Nom de la catégorie</th>
                        <th>Statut</th>
                        <th class="text-end" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $category->sort_order }}</span>
                            </td>
                            <td class="fw-semibold">{{ $category->name }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Masquée</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <!-- Bouton Modifier (Modal) -->
                                <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                    <i class="fa-solid fa-pen"></i>
                                </button>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal de modification -->
                        <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('categories.update', $category) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Modifier la catégorie</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name{{ $category->id }}" class="form-label fw-semibold">Nom de la catégorie <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="sort_order{{ $category->id }}" class="form-label fw-semibold">Ordre d'affichage</label>
                                                <input type="number" class="form-control" id="sort_order{{ $category->id }}" name="sort_order" value="{{ $category->sort_order }}" min="0">
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active{{ $category->id }}" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active{{ $category->id }}">Catégorie active (visible sur le menu)</label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-warning">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Aucune catégorie créée pour le moment. Cliquez sur "Nouvelle Catégorie" pour démarrer !
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de création -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Nouvelle Catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="ex: Entrées, Desserts, Boissons..." required>
                    </div>
                    <div class="mb-3">
                        <label for="sort_order" class="form-label fw-semibold">Ordre d'affichage</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                        <small class="text-muted">Permet de classer l'ordre des catégories dans le menu.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Catégorie active (visible sur le menu)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Créer la catégorie</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection