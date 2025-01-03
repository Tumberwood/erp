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
                breakTime: "Break Time",
                businessEntityCode: "Business Entity Code",
                businessEntityName: "Business Entity Name",
                byEmployee: "By Employee",
                buy: "Buy",
                category: "Category",
                cityName: "City",
                code: "Code",
                companyCode: "Company Code",
                companyName: "Company Name",
                compensation: "Compensation",
                conversion: "Conversion",
                cycle: "Cycle",
                dateOfBirth: "Date of Birth",
                default: "Default",
                department: "Department",
                division: "Division",
                dueDate: "Due Date",
                email: "Email Address",
                employee: "Employee",
                employeeTitle: "Employee Title",
                endDate: "End Date",
                gender: "Gender",
                group: "Group",
                inventory: "Inventory",
                latitude: "Latitude",
                level: "Level",
                location: "Location",
                longitude: "Longitude",
                maps: "Maps",
                maritalStatus: "Marital Status",
                module: "Module",
                movementType: "Movement Type",
                name: "Name",
                nickname: "Nickname",
                notes: "Notes",
                pattern: "Pattern",
                phone: "Phone",
                provinceName: "Province",
                religion: "Religion",
                section: "Section",
                sell: "Sell",
                startDate: "Start Date",
                state: "State",
                superior: "Superior",
                symbol: "Symbol",
                termOfPayment: "Term of Payment",
                type: "Type",
                uom: "Unit of Measurement",
                warehouse: "Warehouse",
                workingTime: "Working Time",
            }
        },
        id: {
            translation: {
                address: "Alamat",
                branchCode: "Kode Cabang",
                branchName: "Nama Cabang",
                breakTime: "Waktu istirahat",
                businessEntityCode: "Kode Badan Usaha",
                businessEntityName: "Nama Badan Usaha",
                byEmployee: "Per Karyawan",
                buy: "Beli",
                category: "Kategori",
                cityName: "Kota",
                code: "Kode",
                companyCode: "Kode Perusahaan",
                companyName: "Nama Perusahaan",
                compensation: "Kompensasi",
                conversion: "Konversi",
                cycle: "Siklus",
                dateOfBirth: "Tanggal Lahir",
                default: "Bawaan",
                department: "Departemen",
                division: "Divisi",
                dueDate: "Jatuh Tempo",
                email: "Surel",
                employee: "Karyawan",
                employeeTitle: "Jabatan",
                endDate: "Tanggal Akhir",
                gender: "Jenis Kelamin",
                group: "Grup",
                inventory: "Persediaan",
                latitude: "Garis Lintang",
                level: "Tingkat",
                location: "Lokasi",
                longitude: "Garis Bujur",
                maps: "Peta",
                maritalStatus: "Status Perkawinan",
                module: "Modul",
                movementType: "Tipe Pergerakan",
                name: "Nama",
                nickname: "Nama Panggilan",
                notes: "Keterangan",
                pattern: "Pola",
                phone: "Telepon",
                provinceName: "Provinsi",
                religion: "Agama",
                section: "Seksi",
                sell: "Jual",
                startDate: "Tanggal Awal",
                state: "Status",
                superior: "Atasan",
                symbol: "Simbol",
                termOfPayment: "Syarat Bayar",
                type: "Tipe",
                uom: "Satuan",
                warehouse: "Gudang",
                workingTime: "Waktu Kerja",
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
