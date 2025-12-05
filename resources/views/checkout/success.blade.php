@extends('layouts.app') {{-- Ajuste para o nome do seu layout principal --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            
            {{-- Ícone Animado ou Estático --}}
            <div class="mb-4">
                <i class="bi bi-check-circle-fill text-success display-1"></i>
            </div>

            <h1 class="fw-bold text-success mb-3">Pagamento Confirmado!</h1>
            <p class="lead text-muted mb-5">
                Obrigado por sua compra. Seu pedido foi processado com sucesso e já estamos preparando o envio.
            </p>

            {{-- Detalhes do Pedido (Só mostra se a variável $order existir) --}}
            @if(isset($order))
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold">Detalhes do Pedido #{{ $order->id }}</h5>
                    </div>
                    <div class="card-body text-start p-4">
                        <div class="row mb-3">
                            <div class="col-6 text-muted">Status:</div>
                            <div class="col-6 fw-bold text-success text-uppercase">
                                {{ $order->status }}
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6 text-muted">Data:</div>
                            <div class="col-6 fw-bold">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6 text-muted">Cliente:</div>
                            <div class="col-6 fw-bold">
                                {{ $order->customer_name }}
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">Total Pago:</span>
                            <span class="h4 fw-bold text-dark mb-0">
                                R$ {{ number_format($order->total_price, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Botões de Ação --}}
            <div class="d-grid gap-2 d-sm-flex justify-content-center">
                <a href="{{ route('catalogo') }}" class="btn btn-primary btn-lg px-5 rounded-pill fw-bold">
                    <i class="bi bi-bag-fill me-2"></i> Continuar Comprando
                </a>
                
                {{-- Se tiver rota de 'meus pedidos', coloque aqui --}}
                
            </div>

        </div>
    </div>
</div>
@endsection