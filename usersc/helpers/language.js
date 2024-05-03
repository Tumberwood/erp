/**
 * Digunakan untuk translate bahasa pada javascript
 * Cara penggunaan:
 * Panggil function 
 * getTranslation('branchCode', ['en'])
 * translation diisikan pada bagian resources
 * 
 * TODO
 * - memanggil default bahasa dari table ggsxxsh (belum berhasil)
 * - melengkapi tranlation
 */

/**
 * configuration
 * tambahkan pada bagian resources
 */
i18next.init({
    lng: 'en',  // Bahasa default
    resources: {
        en: {
            translation: {
                branchCode: "Branch Code",
                branchName: "Branch Name",
                
            }
        },
        id: {
            translation: {
                branchCode: "Kode Cabang",
                branchName: "Nama Cabang",

            }
        }
    }
});

/**
 * 
 * @param {String} key  : term yang akan di translate
 * @param {String} lang : bahasa yang digunakan
 * @returns 
 */
function getTranslation(key, lang) {
    return i18next.t(key, { lng: lang });
}

// Ambil semua elemen dengan atribut data-i18n
const elements = document.querySelectorAll('[data-i18n]');

// Iterasi melalui setiap elemen dan terjemahkan teksnya
elements.forEach(element => {
    const key = element.dataset.i18n;
    const translation = getTranslation(key);
    element.textContent = translation;
});
