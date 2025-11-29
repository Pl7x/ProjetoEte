@extends('layouts.admin')

@section('conteudo')
    {{-- Apenas chamamos o componente. O form real está dentro dele. --}}
    {{-- Atenção: O nome aqui deve bater com o nome do arquivo PHP/Classe --}}
    
    <livewire:user-form :user="$user ?? null" />

@endsection