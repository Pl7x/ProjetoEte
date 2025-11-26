@extends('layouts.app')
@section('title', ' - Home')
@section('conteudo')

 {{-- Hero Section (Banner Principal) --}}
    <section class="position-relative overflow-hidden text-center bg-dark text-white">
        <div class="d-flex align-items-center justify-content-center"
             style="min-height: 500px; background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center;">
            <div class="col-md-8 p-lg-5 mx-auto my-5">
                <h1 class="display-3 fw-bold mb-3">POTENCIALIZE SEU TREINO</h1>
                <p class="lead fw-normal mb-4">A suplementação de elite que você precisa para alcançar resultados reais. Whey, Creatina e muito mais com o melhor preço.</p>
                <div class="d-flex gap-3 justify-content-center lead fw-normal">
                    <a class="btn btn-outline-light btn-lg px-4" href="{{ route ('catalogo') }}">
                        Ver Catálogo
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Diferenciais --}}
    <section class="bg-warning py-4 text-dark shadow-sm">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <i class="bi bi-truck fs-2 me-3"></i>
                    <div class="text-start">
                        <h6 class="fw-bold mb-0">Frete Grátis</h6>
                        <small>Para compras acima de R$ 199</small>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <i class="bi bi-shield-check fs-2 me-3"></i>
                    <div class="text-start">
                        <h6 class="fw-bold mb-0">Compra Segura</h6>
                        <small>Seus dados protegidos 100%</small>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center">
                    <i class="bi bi-credit-card-2-front fs-2 me-3"></i>
                    <div class="text-start">
                        <h6 class="fw-bold mb-0">Até 10x Sem Juros</h6>
                        <small>No cartão de crédito</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Seção de Produtos --}}
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h2 class="fw-bold text-dark"><i class="bi bi-fire text-warning"></i> Destaques da Semana</h2>
            <a href="#" class="text-decoration-none text-dark fw-bold">Ver todos <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

            {{-- Produto 1 --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                    <div class="position-relative bg-light rounded-top p-4 text-center" style="height: 250px;">
                        <span class="position-absolute top-0 start-0 badge bg-danger m-3">-15%</span>
                        {{-- Placeholder para imagem do produto --}}
                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                            <i class="bi bi-bucket fs-1"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-1">Proteínas</small>
                        <h5 class="card-title fw-bold">Whey Protein Isolate</h5>
                        <div class="mb-2">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                            <small class="text-muted ms-1">(128)</small>
                        </div>
                        <div class="mt-auto">
                            <small class="text-decoration-line-through text-muted">R$ 189,90</small>
                            <h4 class="fw-bold text-dark">R$ 159,90</h4>
                            <button class="btn btn-dark w-100 mt-2 fw-bold">Adicionar <i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produto 2 --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="position-relative bg-light rounded-top p-4 text-center" style="height: 250px;">
                        <span class="position-absolute top-0 start-0 badge bg-success m-3">Novo</span>
                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                            <i class="bi bi-box2-heart fs-1"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-1">Aminoácidos</small>
                        <h5 class="card-title fw-bold">Creatina Pura 300g</h5>
                        <div class="mb-2">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <small class="text-muted ms-1">(450)</small>
                        </div>
                        <div class="mt-auto">
                            <h4 class="fw-bold text-dark">R$ 99,90</h4>
                            <button class="btn btn-dark w-100 mt-2 fw-bold">Adicionar <i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Produto 3 --}}
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="position-relative bg-light rounded-top p-4 text-center" style="height: 250px;">
                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                            <i class="bi bi-lightning-charge fs-1"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-1">Pré-Treino</small>
                        <h5 class="card-title fw-bold">Pre-Workout Energy</h5>
                        <div class="mb-2">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star text-secondary"></i>
                            <small class="text-muted ms-1">(85)</small>
                        </div>
                        <div class="mt-auto">
                            <h4 class="fw-bold text-dark">R$ 129,90</h4>
                            <button class="btn btn-dark w-100 mt-2 fw-bold">Adicionar <i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

             {{-- Produto 4 --}}
             <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="position-relative bg-light rounded-top p-4 text-center" style="height: 250px;">
                        <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-3">Promo</span>
                        <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                            <i class="bi bi-capsule fs-1"></i>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <small class="text-muted mb-1">Saúde</small>
                        <h5 class="card-title fw-bold">Multivitamínico AZ</h5>
                        <div class="mb-2">
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-fill text-warning"></i>
                            <i class="bi bi-star-half text-warning"></i>
                            <small class="text-muted ms-1">(62)</small>
                        </div>
                        <div class="mt-auto">
                            <small class="text-decoration-line-through text-muted">R$ 69,90</small>
                            <h4 class="fw-bold text-dark">R$ 49,90</h4>
                            <button class="btn btn-dark w-100 mt-2 fw-bold">Adicionar <i class="bi bi-cart-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    {{-- CSS Específico para esta página --}}
    @push('styles')
    <style>
        .hover-shadow {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
    </style>
    @endpush

@endsection
