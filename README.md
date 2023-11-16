# Solusi Indonesia WebApp v2
powered by UserSpice5 x Bootstrap 4

== Sticky Warning Core Userspice ==
- users\views\_admin_pages.php  : 
    comment di line #202 bagian: echo oxfordList
    untuk hide tampilan folder yang di monitor
- Bawaan Userspice 5 tidak menggunakan composer. Sehingga composer sekarang berpindah ke folder usersc
    mpdf
    phpoffice

###### 01 Jul 2023 ######
- Version 2.4.0
- Bug fix
    Perbaikan datatable editor select2. Sekarang sudah support paginasi serverside, data lama tidak hilang saat di edit
- Update
    - Layout berubah dari fixed header menjadi canvas-menu
    - usersc\templates\inspinia-side\assets\css\custom.css
        Penambahan fitur datatables compact
- Add
    - usersc\helpers\fn_ajax_results.php
        Digunakan sebagai template return hasil ajax. Parameter dapat dilihat di file terkait

###### 08 Apr 2023 ######
- Add
    menu side Inspinia

###### 30 Mar 2023 ######
- Update
    usersc\helpers\button_fn_generate.php
        Tambah Tombol View

###### 13 Mar 2023 ######
- Improve
    button_fn_generate.php
        button nonaktif_d ditambahkan auto reload

###### 08 Mar 2023 ######
- Update
    Datatables to Single File JS

###### 07 Feb 2023 ######
- Update
    update userspice 5.4.5 -> 5.5.5

###### 03 Jan 2023 ######
- Update
    usersc\templates\inspinia\template_js_setup.php : new global var imtxxmh_kode untuk movement type. default 0
    Movement Type hanya dipakai untuk form yang memerlukan movement terkait inventory.
    Jika tidak diperlukan, maka ikut default.

###### 01 Jan 2023 ######
Happy New Year

###### 27 Dec 2022 ######
- Update
    - Penambahan field last_edited_by dan last_edited_on

###### 27 Dec 2022 ######
- Add
    - mpdf via composer
    - phpoffice\phpspreadsheet via composer

###### 17 Dec 2022 ######
- Add
    - usersc\applications\core\noakses.php      : Jika users belum mempunyai hak akses data, maka akan di logout-kan dan redirect ke halaman ini
- Update
    - usersc\scripts\custom_login_script.php    : Redirect dibedakan ke 2 halaman, Dashboard atau No Akses.

###### 18 Sep 2022 ######
- Update
    - Mengganti stuktur ke bentuk folder per menu, kecuali untuk core. Setiap menu mempunyai 2 folder, didalam \views dan \models

###### 8 Sep 2022 ######
- Update
    - usersc\applications\views\users_s_akses\users_s_akses.php     : CRUD hanya generate page tertentu
- Bug fix
    - usersc\applications\views\users_s_akses\users_s_akses.php     : script delete tombol non aktif

###### 7 Sep 2022 ######
- Bug fix
    - helpers\  : mengganti query menggunakan class datatables
- Update
    - mengganti index button menjadi name
- Remove
    - helpers\fn_reject.php : fitur reject sudah tidak digunakan lagi

###### 12 Aug 2022 ######
- Add
    - usersc\templates\inspinia\template_page_title.php     : untuk Page Title & Page Info
    - usersc\applications\admin\pages_extend.php            : untuk mengisi Page Info
- Bug fix
    - usersc\includes\loader.php    : fix query join pages_extend
- Update
    - Page Title pindah ke usersc\templates\inspinia\template_page_title.php

###### 16 Jun 2022 ######
- Improve
    - usersc\templates\inspinia\assets\js\datatables_setup.js
        Avoid form closed when user click outside modal. Using onBackground: none

###### 10 Jun 2022 ######
- Bug fix
    - usersc\templates\inspinia\template_css_datatables_load.php    : fix searchPanes asset file
- Update
    - usersc\templates\inspinia\template_js_load.php    : jquery validation pindah ke general js asset

###### 04 Jun 2022 ######
- Update UserSpice 5.4.4
- Update Logo Admin Panel ke Logo Solusi Indonesia
- Bug fix 
    - usersc\applications\core\login.php    : fix login error message yang muncul di dashboard setelah redirect
- Add
    - usersc\includes\system_messages_header.php    : untuk fix error message yang muncul di dashboard setelah redirect
    - usersc\helpers\fn_editor_selectize.php        : untuk populate options selectize datatables editor

###### 14 May 2022 ######
- Update UserSpice 5.4.3
- Bug fix 
    - core\user_settings.php    : redirect URL cancel button
    - setting\usersakses_s.php  : view db v_cabang_m_company_m tidak digunakan lagi. aplikasi hanya berlaku untuk 1 company, tetapi tetap multi cabang
    - users\includes\loader.php : missing field pages.info, moved to pages_extend.info agar tidak merusak table utama dari userspice
- Add
    - core\session_debug.php    : Untuk melihat variable yang disimpan di $_SESSION. Tidak ditampilkan di menu, tetapi dapat diakses oleh user via URL
    - core\cabang_m.php         : Master Cabang

###### 01 May 2022 ######
- Upgrade dari UserSpice4 menjadi UserSpice5
- Upgrade dari Bootstrap 3 menjadi Bootstrap 4
- Upgrade Datatables css dari Bootstrap 3 menjadi Bootstrap 4
- Semua fitur fungsional dari Solusi Indonesia WebApp v1 akan dipindahkan secara bertahap