@extends('layouts.admin')
@section('title', ' - Relatórios ')
@section('conteudo')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 fw-bold">Relatórios</h2>
        <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
            <i class="bi bi-printer me-1"></i> Imprimir
        </button>
    </div>
    
    <hr class="mb-4">

    {{-- Chama o componente Livewire que criamos --}}
    @livewire('relatorios')

@endsection