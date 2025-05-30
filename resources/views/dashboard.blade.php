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
<script>
$(document).ready(function() {
    loadDashboardData();
});

async function loadDashboardData() {
    try {
        // Load stats
        const [educations, categories, tags] = await Promise.all([
            $.get(`${API_BASE}/educations`),
            $.get(`${API_BASE}/categories`),
            $.get(`${API_BASE}/tags`)
        ]);

        // Update counters
        $('#total-educations').html(educations.meta.total);
        $('#total-categories').html(categories.meta.total);
        $('#total-tags').html(tags.meta.total);

        // Count this month's educations
        const thisMonth = new Date().getMonth() + 1;
        const thisYear = new Date().getFullYear();
        const thisMonthEducations = educations.data.filter(edu => {
            const eduDate = new Date(edu.created_at);
            return eduDate.getMonth() + 1 === thisMonth && eduDate.getFullYear() === thisYear;
        }).length;
        $('#this-month').html(thisMonthEducations);

        // Load latest educations
        loadLatestEducations(educations.data.slice(0, 5));
        
        // Load content types breakdown
        loadContentTypes(educations.data);

    } catch (error) {
        console.error('Dashboard data yüklenirken hata:', error);
        showAlert('Dashboard verileri yüklenirken hata oluştu', 'danger');
    }
}

function loadLatestEducations(educations) {
    if (educations.length === 0) {
        $('#latest-educations').html('<p class="text-muted text-center">Henüz eğitim bulunmuyor.</p>');
        return;
    }

    let html = '<div class="list-group list-group-flush">';
    educations.forEach(edu => {
        const contentTypeIcon = {
            'video': 'bi-play-circle',
            'document': 'bi-file-text',
            'image': 'bi-image'
        }[edu.content_type] || 'bi-file';

        html += `
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        <i class="bi ${contentTypeIcon} me-2"></i>
                        ${edu.title}
                    </h6>
                    <small class="text-muted">${new Date(edu.created_at).toLocaleDateString('tr-TR')}</small>
                </div>
                <p class="mb-1 text-muted">${edu.description ? edu.description.substring(0, 80) + '...' : 'Açıklama yok'}</p>
                <small class="text-primary">${edu.category.name}</small>
            </div>
        `;
    });
    html += '</div>';
    
    $('#latest-educations').html(html);
}

function loadContentTypes(educations) {
    const types = {
        'video': { count: 0, icon: 'bi-play-circle', color: 'primary' },
        'document': { count: 0, icon: 'bi-file-text', color: 'success' },
        'image': { count: 0, icon: 'bi-image', color: 'warning' }
    };

    educations.forEach(edu => {
        if (types[edu.content_type]) {
            types[edu.content_type].count++;
        }
    });

    let html = '';
    Object.entries(types).forEach(([type, data]) => {
        const percentage = educations.length > 0 ? (data.count / educations.length * 100).toFixed(1) : 0;
        html += `
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-sm font-weight-bold">
                        <i class="bi ${data.icon} me-2"></i>
                        ${type === 'video' ? 'Video' : type === 'document' ? 'Döküman' : 'Resim'}
                    </span>
                    <span class="text-sm text-muted">${data.count}</span>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-${data.color}" role="progressbar" 
                         style="width: ${percentage}%" aria-valuenow="${percentage}" 
                         aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <small class="text-muted">${percentage}%</small>
            </div>
        `;
    });

    $('#content-types').html(html);
}
</script>
@endsection 