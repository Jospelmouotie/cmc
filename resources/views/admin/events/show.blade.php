@extends('layouts.admin')

@section('title', 'Agenda Dr ' . $medecin->name . ' ' . $medecin->prenom . ' - CMCU')

@section('content')
<div id="app">
    <div class="wrapper">
        @include('partials.side_bar')
        
        <div class="container-fluid">
            @include('partials.header')
            
            <div class="row">
                <div class="col-12">
                    <!--  -->
                    
                    <!-- Events Calendar Component for specific medecin -->
                    <events-calendar 
                        :medecin-id="{{ $medecinId }}"
                        medecin-name="{{ $medecin->name }} {{ $medecin->prenom }}"
                        :editable="{{ auth()->user()->can('update', App\Models\Event::class) ? 'true' : 'false' }}"
                        view-mode="calendar"
                        :can-create="{{ json_encode(auth()->user()->can('create', App\Models\Event::class)) }}"
                        :can-update="{{ json_encode(auth()->user()->can('update', App\Models\Event::class)) }}"
                        :can-delete="{{ json_encode(auth()->user()->can('delete', App\Models\Event::class)) }}"
                        :user-role="{{ json_encode(auth()->user()->role_id) }}"
                    ></events-calendar>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

