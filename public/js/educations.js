/**
 * Eğitim API - Educations JavaScript
 * Author: Hakan İlyas
 */

let currentPage = 1;
let totalPages = 1;
let allEducations = [];

$(document).ready(function() {
    loadEducations();
    loadCategories();
    loadTags();
    
    // Search functionality
    $('#searchInput').on('input', function() {
        filterEducations($(this).val());
    });

    // Form submission
    $('#educationForm').on('submit', function(e) {
        e.preventDefault();
        saveEducation();
    });
});

async function loadEducations(page = 1) {
    try {
        const response = await $.get(`${API_BASE}/educations?page=${page}`);
        allEducations = response.data;
        totalPages = response.meta.last_page;
        currentPage = response.meta.current_page;
        
        displayEducations(allEducations);
        updatePagination(response.meta);
    } catch (error) {
        console.error('Eğitimler yüklenemedi:', error);
        showAlert('Eğitimler yüklenirken hata oluştu', 'danger');
    }
}

function displayEducations(educations) {
    if (educations.length === 0) {
        $('#educationsTable').html('<tr><td colspan="6" class="text-center text-muted p-4">Eğitim bulunamadı</td></tr>');
        return;
    }

    let html = '';
    educations.forEach(education => {
        const contentTypeIcons = {
            'video': 'bi-play-circle text-primary',
            'document': 'bi-file-text text-success',
            'image': 'bi-image text-warning'
        };

        const tagsHtml = education.tags && education.tags.length > 0 
            ? education.tags.map(tag => `<span class="badge bg-secondary me-1">${tag.name}</span>`).join('')
            : '';

        html += `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <i class="bi ${contentTypeIcons[education.content_type] || 'bi-file'} me-2 fs-5"></i>
                        <div>
                            <h6 class="mb-0">${education.title || 'Başlık yok'}</h6>
                            <small class="text-muted">${education.description ? education.description.substring(0, 50) + '...' : 'Açıklama yok'}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-primary">${education.category?.name || 'Kategori yok'}</span>
                </td>
                <td>
                    <span class="badge bg-light text-dark">
                        ${education.content_type === 'video' ? 'Video' : education.content_type === 'document' ? 'Döküman' : 'Resim'}
                    </span>
                </td>
                <td>${formatDate(education.start_date)}</td>
                <td>${tagsHtml || '<span class="text-muted">-</span>'}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="editEducation(${education.id})" title="Düzenle">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteEducation(${education.id})" title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });
    
    $('#educationsTable').html(html);
}

function updatePagination(meta) {
    let html = '';
    
    // Previous button
    if (meta.current_page > 1) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadEducations(${meta.current_page - 1})">Önceki</a></li>`;
    }
    
    // Page numbers
    for (let i = 1; i <= meta.last_page; i++) {
        const active = i === meta.current_page ? 'active' : '';
        html += `<li class="page-item ${active}"><a class="page-link" href="#" onclick="loadEducations(${i})">${i}</a></li>`;
    }
    
    // Next button
    if (meta.current_page < meta.last_page) {
        html += `<li class="page-item"><a class="page-link" href="#" onclick="loadEducations(${meta.current_page + 1})">Sonraki</a></li>`;
    }
    
    $('#pagination').html(html);
}

async function loadCategories() {
    try {
        const response = await $.get(`${API_BASE}/categories`);
        let html = '<option value="">Kategori seçiniz</option>';
        response.data.forEach(category => {
            html += `<option value="${category.id}">${category.name}</option>`;
        });
        $('#categoryId').html(html);
    } catch (error) {
        console.error('Kategoriler yüklenemedi:', error);
    }
}

async function loadTags() {
    try {
        const response = await $.get(`${API_BASE}/tags`);
        let html = '';
        response.data.forEach(tag => {
            html += `<option value="${tag.id}">${tag.name}</option>`;
        });
        $('#tagIds').html(html);
    } catch (error) {
        console.error('Etiketler yüklenemedi:', error);
    }
}

function filterEducations(searchTerm) {
    const filtered = allEducations.filter(education => 
        (education.title || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (education.description || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (education.category?.name || '').toLowerCase().includes(searchTerm.toLowerCase())
    );
    displayEducations(filtered);
}

function openEducationModal(id = null) {
    $('#educationForm')[0].reset();
    $('#educationId').val('');
    
    if (id) {
        $('#modalTitle').text('Eğitimi Düzenle');
        $('#submitText').text('Güncelle');
        loadEducationData(id);
    } else {
        $('#modalTitle').text('Yeni Eğitim');
        $('#submitText').text('Kaydet');
    }
}

async function loadEducationData(id) {
    try {
        const response = await $.get(`${API_BASE}/educations/${id}`);
        const education = response.data || response;
        
        $('#educationId').val(education.id);
        $('#title').val(education.title || '');
        $('#description').val(education.description || '');
        $('#contentType').val(education.content_type || '');
        $('#categoryId').val(education.category?.id || '');
        $('#startDate').val(formatDateForInput(education.start_date));
        
        // Set selected tags
        const tagIds = education.tags ? education.tags.map(tag => tag.id) : [];
        $('#tagIds').val(tagIds);
    } catch (error) {
        console.error('Eğitim bilgileri yüklenemedi:', error);
        showAlert('Eğitim bilgileri yüklenirken hata oluştu', 'danger');
    }
}

async function saveEducation() {
    const id = $('#educationId').val();
    const data = {
        title: $('#title').val(),
        description: $('#description').val(),
        content_type: $('#contentType').val(),
        start_date: $('#startDate').val(),
        category_id: parseInt($('#categoryId').val()),
        tag_ids: $('#tagIds').val().map(id => parseInt(id))
    };

    try {
        if (id) {
            await $.ajax({
                url: `${API_BASE}/educations/${id}`,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data)
            });
            showAlert('Eğitim başarıyla güncellendi', 'success');
        } else {
            await $.ajax({
                url: `${API_BASE}/educations`,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data)
            });
            showAlert('Eğitim başarıyla oluşturuldu', 'success');
        }
        
        $('#educationModal').modal('hide');
        loadEducations(currentPage);
    } catch (error) {
        if (error.status === 422) {
            handleAjaxError(error, 'Lütfen form alanlarını kontrol edin');
        } else {
            console.error('Eğitim kaydedilemedi:', error);
            showAlert('Eğitim kaydedilirken hata oluştu', 'danger');
        }
    }
}

function editEducation(id) {
    openEducationModal(id);
    $('#educationModal').modal('show');
}

async function deleteEducation(id) {
    if (!confirm('Bu eğitimi silmek istediğinizden emin misiniz?')) {
        return;
    }

    try {
        await $.ajax({
            url: `${API_BASE}/educations/${id}`,
            method: 'DELETE'
        });
        showAlert('Eğitim başarıyla silindi', 'success');
        loadEducations(currentPage);
    } catch (error) {
        console.error('Eğitim silinemedi:', error);
        showAlert('Eğitim silinirken hata oluştu', 'danger');
    }
} 