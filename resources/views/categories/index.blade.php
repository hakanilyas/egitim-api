@extends('layouts.app')

@section('title', 'Kategoriler - Eğitim Paneli')
@section('page-title', 'Kategoriler')

@section('page-actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openCategoryModal()">
    <i class="bi bi-plus-lg"></i>
    Yeni Kategori
</button>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kategori Adı</th>
                        <th>Açıklama</th>
                        <th>Eğitim Sayısı</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="categoriesTable">
                    <tr>
                        <td colspan="4" class="text-center p-4">
                            <div class="spinner-border" role="status"></div>
                            <p class="mt-2">Yükleniyor...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Yeni Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <input type="hidden" id="categoryId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Kategori Adı *</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Açıklama</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
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
<script>
$(document).ready(function() {
    loadCategories();
    
    $('#categoryForm').on('submit', function(e) {
        e.preventDefault();
        saveCategory();
    });
});

async function loadCategories() {
    try {
        const response = await $.get(`${API_BASE}/categories`);
        displayCategories(response.data);
    } catch (error) {
        console.error('Kategoriler yüklenemedi:', error);
        showAlert('Kategoriler yüklenirken hata oluştu', 'danger');
    }
}

function displayCategories(categories) {
    if (categories.length === 0) {
        $('#categoriesTable').html('<tr><td colspan="4" class="text-center text-muted p-4">Kategori bulunamadı</td></tr>');
        return;
    }

    let html = '';
    categories.forEach(category => {
        html += `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-folder me-2 text-primary fs-5"></i>
                        <strong>${category.name}</strong>
                    </div>
                </td>
                <td>${category.description || '<span class="text-muted">-</span>'}</td>
                <td><span class="badge bg-info">${category.educations_count || 0} eğitim</span></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="editCategory(${category.id})" title="Düzenle">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(${category.id})" title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    $('#categoriesTable').html(html);
}

function openCategoryModal(id = null) {
    $('#categoryForm')[0].reset();
    $('#categoryId').val('');
    
    if (id) {
        $('#modalTitle').text('Kategoriyi Düzenle');
        $('#submitText').text('Güncelle');
        loadCategoryData(id);
    } else {
        $('#modalTitle').text('Yeni Kategori');
        $('#submitText').text('Kaydet');
    }
}

async function loadCategoryData(id) {
    try {
        const category = await $.get(`${API_BASE}/categories/${id}`);
        $('#categoryId').val(category.id);
        $('#name').val(category.name);
        $('#description').val(category.description);
    } catch (error) {
        console.error('Kategori bilgileri yüklenemedi:', error);
        showAlert('Kategori bilgileri yüklenirken hata oluştu', 'danger');
    }
}

async function saveCategory() {
    const id = $('#categoryId').val();
    const data = {
        name: $('#name').val(),
        description: $('#description').val()
    };

    try {
        if (id) {
            await $.ajax({
                url: `${API_BASE}/categories/${id}`,
                method: 'PUT',
                data: JSON.stringify(data)
            });
            showAlert('Kategori başarıyla güncellendi', 'success');
        } else {
            await $.ajax({
                url: `${API_BASE}/categories`,
                method: 'POST',
                data: JSON.stringify(data)
            });
            showAlert('Kategori başarıyla oluşturuldu', 'success');
        }
        
        $('#categoryModal').modal('hide');
        loadCategories();
    } catch (error) {
        console.error('Kategori kaydedilemedi:', error);
        showAlert('Kategori kaydedilirken hata oluştu', 'danger');
    }
}

function editCategory(id) {
    openCategoryModal(id);
    $('#categoryModal').modal('show');
}

async function deleteCategory(id) {
    if (!confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')) {
        return;
    }

    try {
        await $.ajax({
            url: `${API_BASE}/categories/${id}`,
            method: 'DELETE'
        });
        showAlert('Kategori başarıyla silindi', 'success');
        loadCategories();
    } catch (error) {
        console.error('Kategori silinemedi:', error);
        if (error.responseJSON && error.responseJSON.message) {
            showAlert(error.responseJSON.message, 'warning');
        } else {
            showAlert('Kategori silinirken hata oluştu', 'danger');
        }
    }
}
</script>
@endsection 