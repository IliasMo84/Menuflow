@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2">Mon Restaurant</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('restaurant.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nom du restaurant -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nom du restaurant <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $restaurant->name ?? '') }}" placeholder="ex: Le Petit Bistro" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Présentez votre établissement en quelques mots...">{{ old('description', $restaurant->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Adresse -->
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label fw-semibold">Adresse</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $restaurant->address ?? '') }}" placeholder="123 Rue de la Gastronomie">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label fw-semibold">Téléphone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $restaurant->phone ?? '') }}" placeholder="01 23 45 67 89">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Logo -->
                    <div class="mb-4">
                        <label for="logo" class="form-label fw-semibold">Logo de l'établissement</label>
                        @if(isset($restaurant) && $restaurant->logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                        @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Enregistrer les modifications
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection