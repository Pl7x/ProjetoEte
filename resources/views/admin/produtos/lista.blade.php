@extends('layouts.admin')
@section('title', ' - Produtos ')
@section('conteudo')

    {{-- Título e linha horizontal --}}
    <h2 class="mt-3">Produtos</h2>
    <hr>

    {{-- Layout completo da tabela --}}
    <div class="container-fluid px-0">

        {{-- Cabeçalho com botão Novo --}}
        <div class="d-flex justify-content-between align-items-center my-5"> {{-- Aumentei para my-5 --}}
            <h4 class="mb-0 text-secondary">Gerenciar Lista</h4>
            <a href="{{ route('produtos.create') }}" class="btn btn-primary btn-lg shadow-sm"> {{-- Botão maior com sombra --}}
                <i class="fas fa-plus me-2"></i> Novo Produto
            </a>
        </div>

        {{-- Mensagens de Sucesso --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Cartão da Tabela --}}
        <div class="card mb-5 shadow border-0"> {{-- Sombra mais forte (shadow) e margem inferior maior --}}
            <div class="card-header bg-white py-4"> {{-- Cabeçalho mais alto --}}
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-list me-2"></i> Lista Completa de Itens
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light border-bottom">
                            <tr>
                                {{-- Aumentei o padding vertical para py-4 em todos os cabeçalhos --}}
                                <th scope="col" class="ps-4 py-4 text-secondary text-uppercase small fw-bold">Imagem</th>
                                <th scope="col" class="py-4 text-secondary text-uppercase small fw-bold">Nome</th>
                                <th scope="col" class="py-4 text-secondary text-uppercase small fw-bold">Categoria</th>
                                <th scope="col" class="py-4 text-secondary text-uppercase small fw-bold">Preço</th>
                                <th scope="col" class="py-4 text-secondary text-uppercase small fw-bold text-center">Estoque</th>
                                <th scope="col" class="py-4 text-secondary text-uppercase small fw-bold" style="min-width: 200px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produtos as $produto)
                            <tr>
                                {{-- Imagem: Aumentei para 64px e o padding da célula para py-4 --}}
                                <td class="ps-4 py-4">
                                    <div class="rounded border d-flex align-items-center justify-content-center bg-white p-1 shadow-sm" style="width: 64px; height: 64px; overflow:hidden;">
                                        @if($produto->image_path)
                                            @if(Str::startsWith($produto->image_path, 'http'))
                                                <img src="{{ $produto->image_path }}" alt="{{ $produto->name }}" class="w-100 h-100 object-fit-cover rounded">
                                            @else
                                                <img src="{{ asset('storage/' . $produto->image_path) }}" alt="{{ $produto->name }}" class="w-100 h-100 object-fit-cover rounded">
                                            @endif
                                        @else
                                            <span class="text-muted small"><i class="fas fa-image fa-2x"></i></span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Nome: Aumentei o padding para py-4 e o tamanho da fonte --}}
                                <td class="py-4">
                                    <span class="fw-bold text-dark fs-6">{{ $produto->name }}</span>
                                </td>

                                {{-- Categoria: Aumentei o padding para py-4 --}}
                                <td class="py-4">
                                    @if($produto->category)
                                        <span class="badge bg-primary bg-opacity-10 text-primary fw-normal px-3 py-2 rounded-pill">
                                            {{ $produto->category->name }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary fw-normal px-3 py-2 rounded-pill">Sem Categoria</span>
                                    @endif
                                </td>

                                {{-- Preço: Aumentei o padding para py-4 e o tamanho da fonte --}}
                                <td class="py-4">
                                    <span class="fw-bold text-success fs-6">
                                        R$ {{ number_format($produto->price, 2, ',', '.') }}
                                    </span>
                                </td>

                                {{-- Estoque: Aumentei o padding para py-4 --}}
                                <td class="py-4 text-center">
                                    @if($produto->stock_quantity <= 0)
                                        <span class="badge bg-danger bg-opacity-10 text-danger fw-normal px-3 py-2 rounded-pill">Esgotado</span>
                                    @elseif($produto->stock_quantity <= 10)
                                        <span class="badge bg-warning bg-opacity-10 text-warning fw-bold px-3 py-2 rounded-pill">{{ $produto->stock_quantity }} unid. (Baixo)</span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success fw-normal px-3 py-2 rounded-pill">{{ $produto->stock_quantity }} unidades</span>
                                    @endif
                                </td>

                                {{-- Ações: Aumentei o padding para py-4 e o espaçamento entre botões para gap-3 --}}
                                <td class="py-4">
                                    <div class="d-flex gap-3">
                                        <a href="#" class="btn btn-outline-primary px-3 hover-shadow">
                                            <i class="fas fa-edit me-2"></i> Editar
                                        </a>
                                        <form action="#" method="POST" class="d-inline" onsubmit="return confirm('ATENÇÃO:\n\nTem certeza que deseja EXCLUIR este produto permanentemente?\n\nEsta ação não pode ser desfeita.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger px-3 hover-shadow">
                                                <i class="fas fa-trash-alt me-2"></i> Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="my-5">
                                        <i class="fas fa-box-open fa-4x mb-4 text-secondary opacity-25"></i>
                                        <h4 class="fw-bold text-secondary">Nenhum produto encontrado</h4>
                                        <p class="text-muted mb-4">Sua lista de produtos está vazia no momento.</p>
                                        <a href="{{ route('produtos.create') }}" class="btn btn-primary px-4 py-2">
                                            <i class="fas fa-plus me-2"></i> Cadastrar o primeiro produto
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Paginação --}}
            @if($produtos->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end py-4">
                {{ $produtos->links() }}
            </div>
            @endif
        </div>
    </div>

    {{-- Estilo extra para o efeito de hover nos botões --}}
    <style>
        .hover-shadow:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-1px);
            transition: all 0.2s;
        }
    </style>
@endsection