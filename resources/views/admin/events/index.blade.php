{{-- indexEvent.blade.php --}}
@extends('layouts.admin')
@section('title', 'Gestion des Rendez-vous - CMCU')
@section('content')
<div id="app">
    <div class="wrapper">
        @include('partials.side_bar')
        <div class="container-fluid">
            @include('partials.header')
            <div class="row">
                <div class="col-12">
                    <!--  -->
                    <!-- Events Calendar Component - only pass essential props -->
                    <events-calendar
                        :editable="true"
                        view-mode="timeline"
                        :can-create="{{ json_encode(auth()->user()->can('create', App\Models\Event::class)) }}"
                        :can-update="{{ json_encode(auth()->user()->can('update', App\Models\Event::class)) }}"
                        :can-delete="{{ json_encode(auth()->user()->can('delete', App\Models\Event::class)) }}"
                        :user-role="{{ auth()->user()->role_id }}"
                        @if(auth()->user()->role_id === 2)
                            :medecin-id="{{ auth()->user()->id }}"
                            medecin-name="{{ auth()->user()->name . ' ' . auth()->user()->prenom }}"
                        @endif
                    ></events-calendar>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection