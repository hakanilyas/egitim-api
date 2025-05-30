@extends('layouts.app')

@section('title', 'Eğitimler - Eğitim Paneli')
@section('page-title', 'Eğitimler')

@section('page-actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#educationModal" onclick="openEducationModal()">
    <i class="bi bi-plus-lg"></i>
    Yeni Eğitim
</button>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="m-0 font-weight-bold text-primary">Eğitim Listesi</h6>
            </div>
            <div class="col-auto">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Eğitim ara...">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Kategori</th>
                        <th>İçerik Türü</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Etiketler</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="educationsTable">
                    <tr>
                        <td colspan="6" class="text-center p-4">
                            <div class="spinner-border" role="status"></div>
                            <p class="mt-2">Yükleniyor...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" id="pagination">
            </ul>
        </nav>
    </div>
</div>

<!-- Education Modal -->
<div class="modal fade" id="educationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Yeni Eğitim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="educationForm">
                <div class="modal-body">
                    <input type="hidden" id="educationId">
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Başlık *</label>
                                <input type="text" class="form-control" id="title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="contentType" class="form-label">İçerik Türü *</label>
                                <select class="form-select" id="contentType" required>
                                    <option value="">Seçiniz</option>
                                    <option value="video">Video</option>
                                    <option value="document">Döküman</option>
                                    <option value="image">Resim</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="categoryId" class="form-label">Kategori *</label>
                                <select class="form-select" id="categoryId" required>
                                    <option value="">Yükleniyor...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Başlangıç Tarihi *</label>
                                <input type="date" class="form-control" id="startDate" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tagIds" class="form-label">Etiketler</label>
                        <select class="form-select" id="tagIds" multiple>
                            <option value="">Yükleniyor...</option>
                        </select>
                        <div class="form-text">Birden fazla etiket seçebilirsiniz (Ctrl+Click)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <span id="submitText">Kaydet</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/educations.js') }}"></script>
@endsection 