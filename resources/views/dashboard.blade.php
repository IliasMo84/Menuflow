@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">Tableau de bord</h1>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                        <i class="fa-solid fa-receipt fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted fw-normal mb-1">Commandes du jour</h6>
                        <h4 class="card-title mb-0 fw-bold">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                        <i class="fa-solid fa-euro-sign fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted fw-normal mb-1">Chiffre d'affaires</h6>
                        <h4 class="card-title mb-0 fw-bold">0.00 €</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3">
                        <i class="fa-solid fa-burger fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted fw-normal mb-1">Produits actifs</h6>
                        <h4 class="card-title mb-0 fw-bold">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-3 me-3">
                        <i class="fa-solid fa-chair fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle text-muted fw-normal mb-1">Tables configurées</h6>
                        <h4 class="card-title mb-0 fw-bold">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4 text-center">
            <h5 class="card-title fw-bold">Bienvenue sur MenuFlow !</h5>
            <p class="card-text text-muted">Votre espace de gestion est prêt. Vous allez bientôt pouvoir configurer votre restaurant, vos catégories et votre carte numérique.</p>
        </div>
    </div>
@endsection