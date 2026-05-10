@php use Carbon\Carbon; @endphp

@extends('includes.layout')

@section('title')
    Partie du {{ Carbon::createFromFormat('Y-m-d', $game->game_date)->format('d/m/Y') }}
@endsection

@section('content')

@endsection
