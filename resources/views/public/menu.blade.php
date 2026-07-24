<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} - Menu Numérique</title>

    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            padding-bottom: 80px;
        }
        .header-banner {
            height: 180px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .header-overlay {
            background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.8));
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
        }
        .product-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .sticky-categories {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: #fff;
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

    <!-- Bannière d'en-tête -->
    <div class="header-banner" style="background-image: url('{{ $restaurant->logo ? asset('storage/' . $restaurant->logo) : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800' }}');">
        <div class="header-overlay d-flex align-items-end p-3">
            <div class="text-white">
                <h2 class="fw-bold mb-0">{{ $restaurant->name }}</h2>
                @if($table)
                    <span class="badge bg-warning text-dark mt-1">
                        <i class="fa-solid fa-chair me-1"></i> Table {{ $table->number }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Informations Restaurant -->
    <div class="container my-3">
        @if($restaurant->address || $restaurant->phone)
            <div class="d-flex flex-wrap gap-3 text-muted small">
                @if($restaurant->address)
                    <div><i class="fa-solid fa-location-dot me-1 text-warning"></i> {{ $restaurant->address }}</div>
                @endif
                @if($restaurant->phone)
                    <div><i class="fa-solid fa-phone me-1 text-warning"></i> {{ $restaurant->phone }}</div>
                @endif
            </div>
        @endif
    </div>

    <!-- Navigation Filtres Catégories -->
    @if($restaurant->categories->count() > 0)
    <div class="sticky-categories">
        <div class="container">
            <div class="d-flex overflow-auto pb-1" style="scrollbar-width: none;">
                @foreach($restaurant->categories as $index => $category)
                    <a href="#cat-{{ $category->id }}" class="nav-link badge rounded-pill px-3 py-2 text-decoration-none me-2 {{ $index === 0 ? 'bg-warning text-dark' : 'bg-light text-dark border' }}">
                        {{ $category->name }} ({{ $category->products->count() }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Liste des Produits par Catégorie -->
    <div class="container my-4">
        @forelse($restaurant->categories as $category)
            <div id="cat-{{ $category->id }}" class="mb-5 pt-3">
                <h4 class="fw-bold mb-3 border-bottom pb-2 text-dark">{{ $category->name }}</h4>

                <div class="row g-3">
                    @forelse($category->products as $product)
                        <div class="col-12 col-md-6">
                            <div class="card product-card shadow-sm h-100">
                                <div class="row g-0 align-items-center">
                                    <div class="col-8 p-3">
                                        <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                        <p class="text-muted small mb-2 text-truncate" style="font-size: 0.85rem;">
                                            {{ $product->description }}
                                        </p>
                                        <span class="fw-bold text-dark fs-6">{{ number_format($product->price, 2) }} €</span>
                                    </div>
                                    <div class="col-4 p-2 text-center">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="height: 90px; width: 100%; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="height: 90px;">
                                                <i class="fa-solid fa-utensils fa-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small italic">Aucun article dans cette catégorie.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fa-solid fa-book-open fa-3x text-muted mb-3"></i>
                <h5>Le menu est en cours de préparation</h5>
                <p class="text-muted">Revenez un peu plus tard !</p>
            </div>
        @endforelse
    </div>

    <!-- Pied de page -->
    <footer class="text-center text-muted py-4 small">
        Proposé par <strong class="text-dark">MenuQR</strong>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>