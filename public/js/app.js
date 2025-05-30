/**
 * ========================================
 * Eğitim API - Common JavaScript Functions
 * ========================================
 * 
 * Bu dosya tüm sayfalarda kullanılan ortak fonksiyonları içerir.
 * AJAX setup, error handling, alert fonksiyonları ve date formatters.
 * 
 * @author Hakan İlyas
 * @version 1.0
 * @since 2024-01-15
 */

// ====================================
// GLOBAL CONFIGURATIONS
// ====================================

// API Base URL - Tüm AJAX istekleri için temel URL
const API_BASE = '/api';

// ====================================
// ALERT SYSTEM
// ====================================

/**
 * Bootstrap alert gösterme fonksiyonu
 * Sağ üst köşede otomatik kapanan alert gösterir
 * 
 * @param {string} message - Gösterilecek mesaj
 * @param {string} type - Alert tipi (success, danger, warning, info)
 */
function showAlert(message, type = 'info') {
    // Bootstrap alert HTML'i oluştur
    const alertDiv = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Alert'i sayfaya ekle
    $('body').append(alertDiv);
    
    // 5 saniye sonra otomatik kapat
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
}

// ====================================
// ERROR HANDLING
// ====================================

/**
 * AJAX istekleri için merkezi hata yönetimi
 * Laravel validation hatalarını ve genel hataları işler
 * 
 * @param {object} error - jQuery AJAX error objesi
 * @param {string} defaultMessage - Varsayılan hata mesajı
 */
function handleAjaxError(error, defaultMessage = 'Bir hata oluştu') {
    console.error('AJAX Error:', error);
    
    // Laravel API'den gelen hata mesajı varsa
    if (error.responseJSON && error.responseJSON.message) {
        showAlert(error.responseJSON.message, 'danger');
    } 
    // Validation hataları varsa (422 status)
    else if (error.responseJSON && error.responseJSON.errors) {
        const errors = Object.values(error.responseJSON.errors).flat();
        showAlert(errors.join('<br>'), 'danger');
    } 
    // Genel hata
    else {
        showAlert(defaultMessage, 'danger');
    }
}

// ====================================
// DATE UTILITIES
// ====================================

/**
 * Tarih'i Türkçe locale'e göre formatlar
 * Tablo görünümlerinde kullanılır
 * 
 * @param {string} dateString - ISO tarih string'i
 * @returns {string} - Formatlanmış tarih (DD.MM.YYYY)
 */
function formatDate(dateString) {
    if (!dateString) return '-';
    return new Date(dateString).toLocaleDateString('tr-TR');
}

/**
 * Tarih'i HTML input field formatına çevirir
 * Form input'larında kullanılır
 * 
 * @param {string} dateString - ISO tarih string'i  
 * @returns {string} - YYYY-MM-DD formatında tarih
 */
function formatDateForInput(dateString) {
    if (!dateString) return '';
    return new Date(dateString).toISOString().split('T')[0];
}

// ====================================
// AJAX GLOBAL SETUP
// ====================================

/**
 * Tüm AJAX istekleri için global ayarlar
 * CSRF token, content type ve error handling
 */
$.ajaxSetup({
    headers: {
        'X-Requested-With': 'XMLHttpRequest',           // Laravel için AJAX tanımlaması
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // CSRF koruması
        'Accept': 'application/json'                     // JSON response beklediğimizi belirt
    },
    error: function(xhr, status, error) {
        // 422 (Validation Error) durumunda özel handling yapılacak
        if (xhr.status === 422) {
            return; // Validation hatalarını controller'lar handle eder
        }
        // Diğer hataları merkezi olarak handle et
        handleAjaxError(xhr, 'İstek sırasında bir hata oluştu');
    }
});

// ====================================
// DOCUMENT READY INITIALIZATION
// ====================================

/**
 * Sayfa yüklendiğinde çalışacak ortak kodlar
 * Bootstrap tooltip'leri ve alert event'leri başlat
 */
$(document).ready(function() {
    
    // Alert kapatma event'i - dinamik olarak eklenen alert'ler için
    $(document).on('click', '.alert .btn-close', function() {
        $(this).closest('.alert').fadeOut();
    });
    
    // Bootstrap tooltip'lerini başlat
    // Tüm [data-bs-toggle="tooltip"] elementleri için
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}); 