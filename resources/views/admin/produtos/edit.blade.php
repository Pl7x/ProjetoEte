@extends('layouts.admin')

@section('title', '- Editar Produto')

@section('conteudo')

<div class="container-fluid px-4 py-5">

    {{-- Cabeçalho e Botão de Voltar --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800 fw-bold">
            <i class="bi bi-pencil-square me-2 text-primary"></i>Editar Produto
        </h2>
        <a href="{{ route('produtos') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
    </div>

   

    {{-- O componente Livewire agora gerencia todo o layout interno --}}
    @livewire('edit', ['product' => $product])

</div>
@endsection