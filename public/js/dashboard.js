/**
 * ========================================
 * Eğitim API - Dashboard JavaScript
 * ========================================
 * 
 * Dashboard sayfasının JavaScript fonksiyonları.
 * İstatistik kartları, son eğitimler ve içerik türü grafiklerini yönetir.
 * 
 * @author Hakan İlyas
 * @version 1.0
 * @since 2024-01-15
 * @requires app.js (showAlert, formatDate fonksiyonları için)
 */

// ====================================
// DOCUMENT READY INITIALIZATION
// ====================================

/**
 * Sayfa yüklendiğinde dashboard verilerini başlat
 */
$(document).ready(function() {
    loadDashboardData();
});

// ====================================
// MAIN DASHBOARD FUNCTIONS
// ====================================

/**
 * Dashboard'daki tüm verileri paralel olarak yükler
 * İstatistik kartları, son eğitimler ve içerik türü dağılımını günceller
 * 
 * Promise.all kullanarak performans optimizasyonu yapılmıştır
 */
async function loadDashboardData() {
    try {
        // Paralel API istekleri - performans için
        const [educations, categories, tags] = await Promise.all([
            $.get(`${API_BASE}/educations`),    // Eğitimleri getir
            $.get(`${API_BASE}/categories`),    // Kategorileri getir  
            $.get(`${API_BASE}/tags`)           // Etiketleri getir
        ]);

        // İstatistik kartlarını güncelle
        updateStatisticCards(educations, categories, tags);
        
        // Bu ay eklenen eğitim sayısını hesapla
        updateThisMonthCount(educations);

        // Son 5 eğitimi göster
        loadLatestEducations(educations.data.slice(0, 5));
        
        // İçerik türü dağılım grafiğini oluştur
        loadContentTypes(educations.data);

    } catch (error) {
        console.error('Dashboard data yüklenirken hata:', error);
        showAlert('Dashboard verileri yüklenirken hata oluştu', 'danger');
    }
}

// ====================================
// STATISTIC CARDS
// ====================================

/**
 * İstatistik kartlarındaki sayıları günceller
 * Pagination meta bilgisi varsa onu, yoksa array length kullanır
 * 
 * @param {object} educations - Eğitimler API response'u
 * @param {object} categories - Kategoriler API response'u  
 * @param {object} tags - Etiketler API response'u
 */
function updateStatisticCards(educations, categories, tags) {
    // Eğitim sayısı (pagination meta varsa onu kullan)
    $('#total-educations').html(
        educations.meta ? educations.meta.total : educations.data.length
    );
    
    // Kategori sayısı (pagination yok, direkt array length)
    $('#total-categories').html(categories.data.length);
    
    // Etiket sayısı (pagination yok, direkt array length)
    $('#total-tags').html(tags.data.length);
}

/**
 * Bu ay eklenen eğitim sayısını hesaplar ve günceller
 * created_at alanına göre filtreleme yapar
 * 
 * @param {object} educations - Eğitimler API response'u
 */
function updateThisMonthCount(educations) {
    const thisMonth = new Date().getMonth() + 1;  // 0-based index, +1 ekle
    const thisYear = new Date().getFullYear();
    
    // Bu ay eklenen eğitimleri filtrele
    const thisMonthEducations = educations.data.filter(edu => {
        const eduDate = new Date(edu.created_at);
        return eduDate.getMonth() + 1 === thisMonth && 
               eduDate.getFullYear() === thisYear;
    }).length;
    
    $('#this-month').html(thisMonthEducations);
}

// ====================================
// LATEST EDUCATIONS SECTION
// ====================================

/**
 * Son eklenen eğitimleri liste halinde gösterir
 * Her eğitim için ikon, başlık, açıklama ve kategori bilgisi
 * 
 * @param {array} educations - Son 5 eğitimin array'i
 */
function loadLatestEducations(educations) {
    // Eğer hiç eğitim yoksa
    if (educations.length === 0) {
        $('#latest-educations').html(
            '<p class="text-muted text-center">Henüz eğitim bulunmuyor.</p>'
        );
        return;
    }

    let html = '<div class="list-group list-group-flush">';
    
    educations.forEach(edu => {
        // İçerik türüne göre ikon belirleme
        const contentTypeIcon = {
            'video': 'bi-play-circle',
            'document': 'bi-file-text', 
            'image': 'bi-image'
        }[edu.content_type] || 'bi-file';  // Fallback ikon

        html += `
            <div class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">
                        <i class="bi ${contentTypeIcon} me-2"></i>
                        ${edu.title}
                    </h6>
                    <small class="text-muted">${formatDate(edu.created_at)}</small>
                </div>
                <p class="mb-1 text-muted">
                    ${edu.description ? edu.description.substring(0, 80) + '...' : 'Açıklama yok'}
                </p>
                <small class="text-primary">${edu.category?.name || 'Kategori yok'}</small>
            </div>
        `;
    });
    
    html += '</div>';
    $('#latest-educations').html(html);
}

// ====================================
// CONTENT TYPES CHART
// ====================================

/**
 * İçerik türlerinin dağılımını progress bar olarak gösterir
 * Video, döküman ve resim türlerinin yüzdelik oranları
 * 
 * @param {array} educations - Tüm eğitimlerin array'i
 */
function loadContentTypes(educations) {
    // İçerik türü sayaçları ve görsel ayarları
    const types = {
        'video': { count: 0, icon: 'bi-play-circle', color: 'primary' },
        'document': { count: 0, icon: 'bi-file-text', color: 'success' },
        'image': { count: 0, icon: 'bi-image', color: 'warning' }
    };

    // Her eğitimin türünü say
    educations.forEach(edu => {
        if (types[edu.content_type]) {
            types[edu.content_type].count++;
        }
    });

    let html = '';
    
    // Her tür için progress bar oluştur
    Object.entries(types).forEach(([type, data]) => {
        // Yüzdelik oranı hesapla
        const percentage = educations.length > 0 
            ? (data.count / educations.length * 100).toFixed(1) 
            : 0;
            
        // Türkçe isim mapping
        const turkishName = {
            'video': 'Video',
            'document': 'Döküman', 
            'image': 'Resim'
        }[type];
        
        html += `
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-sm font-weight-bold">
                        <i class="bi ${data.icon} me-2"></i>
                        ${turkishName}
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