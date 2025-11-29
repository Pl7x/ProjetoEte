@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800 fw-bold">
            
        </h2>
        <a href="{{ route('usuarios') }}" class="btn btn-outline-secondary shadow-sm d-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Voltar
        </a>
    </div>

<livewire:user-form :user="$user ?? null" />

@endsection