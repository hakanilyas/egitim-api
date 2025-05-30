/**
 * Eğitim API - Categories JavaScript
 * Author: Hakan İlyas
 */

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
        const response = await $.get(`${API_BASE}/categories/${id}`);
        const category = response.data || response;
        
        $('#categoryId').val(category.id);
        $('#name').val(category.name || '');
        $('#description').val(category.description || '');
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
                contentType: 'application/json',
                data: JSON.stringify(data)
            });
            showAlert('Kategori başarıyla güncellendi', 'success');
        } else {
            await $.ajax({
                url: `${API_BASE}/categories`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data)
            });
            showAlert('Kategori başarıyla oluşturuldu', 'success');
        }
        
        $('#categoryModal').modal('hide');
        loadCategories();
    } catch (error) {
        if (error.status === 422) {
            handleAjaxError(error, 'Lütfen form alanlarını kontrol edin');
        } else {
            console.error('Kategori kaydedilemedi:', error);
            showAlert('Kategori kaydedilirken hata oluştu', 'danger');
        }
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