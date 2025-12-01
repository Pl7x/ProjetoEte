@extends('layouts.admin')

@section('conteudo')


    <livewire:user-form :user="$user ?? null" />

@endsection
