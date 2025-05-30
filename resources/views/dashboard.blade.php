@extends('layouts.app')

@section('title', 'Dashboard - Eğitim Paneli')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Toplam Eğitimler
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-educations">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-book fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kategoriler
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-categories">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-folder fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Etiketler
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-tags">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-tags fs-2 text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Bu Ay Eklenen
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="this-month">0</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-plus fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Educations -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock-history"></i>
                    Son Eklenen Eğitimler
                </h6>
                <a href="{{ route('educations.index') }}" class="btn btn-sm btn-primary">Tümünü Gör</a>
            </div>
            <div class="card-body">
                <div id="latest-educations">
                    <div class="text-center p-4">
                        <div class="spinner-border" role="status"></div>
                        <p class="mt-2">Yükleniyor...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-pie-chart"></i>
                    İçerik Türleri
                </h6>
            </div>
            <div class="card-body">
                <div id="content-types">
                    <div class="text-center p-4">
                        <div class="spinner-border" role="status"></div>
                        <p class="mt-2">Yükleniyor...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection 