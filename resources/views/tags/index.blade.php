@extends('layouts.app')

@section('title', 'Etiketler - Eğitim Paneli')
@section('page-title', 'Etiketler')

@section('page-actions')
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tagModal" onclick="openTagModal()">
    <i class="bi bi-plus-lg"></i>
    Yeni Etiket
</button>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Etiket Adı</th>
                        <th>Açıklama</th>
                        <th>Kullanım</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody id="tagsTable">
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

<!-- Tag Modal -->
<div class="modal fade" id="tagModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Yeni Etiket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="tagForm">
                <div class="modal-body">
                    <input type="hidden" id="tagId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Etiket Adı *</label>
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
    loadTags();
    
    $('#tagForm').on('submit', function(e) {
        e.preventDefault();
        saveTag();
    });
});

async function loadTags() {
    try {
        const response = await $.get(`${API_BASE}/tags`);
        displayTags(response.data);
    } catch (error) {
        console.error('Etiketler yüklenemedi:', error);
        showAlert('Etiketler yüklenirken hata oluştu', 'danger');
    }
}

function displayTags(tags) {
    if (tags.length === 0) {
        $('#tagsTable').html('<tr><td colspan="4" class="text-center text-muted p-4">Etiket bulunamadı</td></tr>');
        return;
    }

    let html = '';
    tags.forEach(tag => {
        html += `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tag me-2 text-success fs-5"></i>
                        <span class="badge bg-secondary">${tag.name}</span>
                    </div>
                </td>
                <td>${tag.description || '<span class="text-muted">-</span>'}</td>
                <td><span class="badge bg-info">${tag.educations_count || 0} eğitimde</span></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="editTag(${tag.id})" title="Düzenle">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteTag(${tag.id})" title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    $('#tagsTable').html(html);
}

function openTagModal(id = null) {
    $('#tagForm')[0].reset();
    $('#tagId').val('');
    
    if (id) {
        $('#modalTitle').text('Etiketi Düzenle');
        $('#submitText').text('Güncelle');
        loadTagData(id);
    } else {
        $('#modalTitle').text('Yeni Etiket');
        $('#submitText').text('Kaydet');
    }
}

async function loadTagData(id) {
    try {
        const tag = await $.get(`${API_BASE}/tags/${id}`);
        $('#tagId').val(tag.id);
        $('#name').val(tag.name);
        $('#description').val(tag.description);
    } catch (error) {
        console.error('Etiket bilgileri yüklenemedi:', error);
        showAlert('Etiket bilgileri yüklenirken hata oluştu', 'danger');
    }
}

async function saveTag() {
    const id = $('#tagId').val();
    const data = {
        name: $('#name').val(),
        description: $('#description').val()
    };

    try {
        if (id) {
            await $.ajax({
                url: `${API_BASE}/tags/${id}`,
                method: 'PUT',
                data: JSON.stringify(data)
            });
            showAlert('Etiket başarıyla güncellendi', 'success');
        } else {
            await $.ajax({
                url: `${API_BASE}/tags`,
                method: 'POST',
                data: JSON.stringify(data)
            });
            showAlert('Etiket başarıyla oluşturuldu', 'success');
        }
        
        $('#tagModal').modal('hide');
        loadTags();
    } catch (error) {
        console.error('Etiket kaydedilemedi:', error);
        showAlert('Etiket kaydedilirken hata oluştu', 'danger');
    }
}

function editTag(id) {
    openTagModal(id);
    $('#tagModal').modal('show');
}

async function deleteTag(id) {
    if (!confirm('Bu etiketi silmek istediğinizden emin misiniz?')) {
        return;
    }

    try {
        await $.ajax({
            url: `${API_BASE}/tags/${id}`,
            method: 'DELETE'
        });
        showAlert('Etiket başarıyla silindi', 'success');
        loadTags();
    } catch (error) {
        console.error('Etiket silinemedi:', error);
        showAlert('Etiket silinirken hata oluştu', 'danger');
    }
}
</script>
@endsection 