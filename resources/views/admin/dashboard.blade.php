@extends('layouts.admin') @section('title', 'Accueil | admin') @section('content')
<body>
<div class="se-pre-con"></div>
<div class="wrapper">
@include('partials.side_bar')
<!-- Page Content Holder -->
@include('partials.header')
<!--// top-bar -->
    <div class="row">
        <!-- Stats -->
        <div class="outer-w3-agile col-xl">
            @can('update', \App\Models\User::class)
                <div class="stat-grid p-3 d-flex align-items-center justify-content-between bg-primary">
                    <div class="s-l">
                        <h5>UTILISATEURS</h5>
                    </div>
                    <div class="s-r">
                        <h6>{{ $users }}
                            <i class="far fa-user"></i>
                        </h6>
                    </div>
                </div>
            @endcan
            
            @can('create', \App\Models\Patient::class)
                <div class="stat-grid p-3 mt-3 d-flex align-items-center justify-content-between bg-success">
                    <div class="s-l">
                        <h5>PATIENTS</h5>
                    </div>
                    <div class="s-r">
                        <h6>{{ $patients }}
                            <i class="fas fa-users"></i>
                        </h6>
                    </div>
                </div>
            @endcan
            
            @can('create', \App\Models\chambre::class)
                <div class="stat-grid p-3 mt-3 d-flex align-items-center justify-content-between bg-danger">
                    <div class="s-l">
                        <h5>CHAMBRES</h5>
                    </div>
                    <div class="s-r">
                        <h6>{{ $chambres }}
                            <i class="fa-solid fa-bed"></i>
                        </h6>
                    </div>
                </div>
            @endcan
            
            @can('update', \App\Models\Produit::class)
            <div class="stat-grid p-3 mt-3 d-flex align-items-center justify-content-between bg-success">
                <div class="s-l">
                    <h5>FICHES DE SATISFACTIONS</h5>
                    <p class="paragraph-agileits-w3layouts"></p>
                </div>
                <div class="s-r">
                    <h6>
                        {{ $fiches }}
                        <i class="fas fa-tasks"></i>
                    </h6>
                </div>
            </div>
            @endcan

            @can('create', \App\Models\Produit::class)
                <div class="stat-grid p-3 mt-3 d-flex align-items-center justify-content-between bg-success">
                    <div class="s-l">
                        <h5>PRODUITS EN STOCK</h5>
                        <p class="paragraph-agileits-w3layouts"></p>
                    </div>
                    <div class="s-r">
                        <h6>
                            {{ count(\App\Models\Produit::all()) }}
                            <i class="fas fa-tasks"></i>
                        </h6>
                    </div>
                </div>
                @endcan
            
            {{--------------------------------MARGE IC-------------------------------------}}
            @can('create', \App\Models\Patient::class)
                @can('show', \App\Models\User::class)
                    <div class="row mt-2">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-start border-primary border-4 shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row g-0 align-items-center">
                                        <div class="col me-2">
                                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">Rendez-vous</div>
                                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $events }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Patients Suivis Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-start border-success border-4 shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row g-0 align-items-center">
                                        <div class="col me-2">
                                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                                    Patients suivis
                                            </div>
                                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $patients_suivis }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Recent Consultations Card -->
                        <!-- <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-start border-warning border-4 shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row g-0 align-items-center">
                                        <div class="col me-2">
                                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">Consultations récentes</div>
                                            <div class="h5 mb-0 fw-bold text-gray-800">{{ count($consultation) }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                @endcan
            @endcan
            {{--------------------------------MARGE IC-------------------------------------}}
        </div>
    </div>
    
    
</div>
<script src="{{ asset('admin/js/main.js') }}"></script>
</body>
@stop