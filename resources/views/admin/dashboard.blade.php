@extends('layouts.admin')
@section('title', ' - Dashboard ')
@section('conteudo')
    <h2>Bem-vindo, {{ Auth::user()->name }}</h2>
    <p>Hoje são {{ date('d/m/y') }}</p>
    <hr>

@livewire('dashboard')
@endsection
