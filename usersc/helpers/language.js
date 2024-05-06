/**
 * Digunakan untuk translate bahasa pada javascript
 * Cara penggunaan:
 * Panggil function 
 * getTranslation('branchCode', ['en'])
 * translation diisikan pada bagian resources
 * 
 * TODO
 * - memanggil default bahasa dari table ggsxxsh (belum berhasil)
 * - melengkapi translation
 */

/**
 * configuration
 * tambahkan pada bagian resources, order by huruf awal
 */
i18next.init({
    lng: 'en',  // Bahasa default
    resources: {
        en: {
            translation: {
                address: "Address",
                branchCode: "Branch Code",
                branchName: "Branch Name",
                businessEntityCode: "Business Entity Code",
                businessEntityName: "Business Entity Name",
                buy: "Buy",
                category: "Category",
                cityName: "City",
                code: "Code",
                companyCode: "Company Code",
                companyName: "Company Name",
                conversion: "Conversion",
                default: "Default",
                dueDate: "Due Date",
                inventory: "Inventory",
                latitude: "Latitude",
                longitude: "Longitude",
                maps: "Maps",
                name: "Name",
                notes: "Notes",
                provinceName: "Province",
                sell: "Sell",
                state: "State",
                symbol: "Symbol",
                type: "Type",
                
            }
        },
        id: {
            translation: {
                address: "Alamat",
                branchCode: "Kode Cabang",
                branchName: "Nama Cabang",
                businessEntityCode: "Kode Badan Usaha",
                businessEntityKode: "Nama Badan Usaha",
                buy: "Beli",
                category: "Kategori",
                cityName: "Kota",
                code: "Kode",
                companyCode: "Kode Perusahaan",
                companyName: "Nama Perusahaan",
                conversion: "Konversi",
                default: "Bawaan",
                dueDate: "Jatun Tempo",
                inventory: "Persediaan",
                latitude: "Garis Lintang",
                longitude: "Garis Bujur",
                maps: "Peta",
                name: "Nama",
                notes: "Keterangan",
                provinceName: "Provinsi",
                sell: "Jual",
                state: "Status",
                symbol: "Simbol",
                type: "Tipe",
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
