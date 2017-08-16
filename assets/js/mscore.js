var app = angular.module('mscore', ['ngRoute','chieffancypants.loadingBar','ngAnimate','socialbase.sweetAlert']);
var base_url = window.location.origin;

// CONFIG
/* ---
  semua config mulai disini
--- */

app.config(config);
function config($routeProvider,cfpLoadingBarProvider) {

  cfpLoadingBarProvider.includeSpinner = true;

  $routeProvider
  .when('/', {
    templateUrl: 'pages/dashboard.html'
  })

  //paging untuk siswa
  .when('/siswa', {
    templateUrl: 'pages/siswa/siswa.html',
    controller: 'SiswaController'
  })
  .when('/tambah-siswa', {
    templateUrl: 'pages/siswa/form-siswa.html',
    controller: 'SiswaController'
  })
  .when('/update-siswa/:nis', {
    templateUrl: 'pages/siswa/form-siswa.html',
    controller: 'SiswaController'
  })
  .when('/detail-siswa/:nis', {
    templateUrl: 'pages/siswa/detail-siswa.html',
    controller: 'SiswaController'
  })

  //paging untuk kelas
  .when('/kelas', {
    templateUrl: 'pages/kelas/kelas.html',
    controller: 'KelasController'
  })
  .when('/tambah-kelas', {
    templateUrl: 'pages/kelas/form-kelas.html',
    controller: 'KelasController'
  })
  .when('/update-kelas/:id', {
    templateUrl: 'pages/kelas/form-kelas.html',
    controller: 'KelasController'
  })
  .when('/anggota-kelas/:id', {
    templateUrl: 'pages/kelas/anggota-kelas.html',
    controller: 'KelasController'
  })

  //paging untuk asrama
  .when('/asrama', {
    templateUrl: 'pages/asrama/asrama.html',
    controller: 'AsramaController'
  })
  .when('/tambah-asrama', {
    templateUrl: 'pages/asrama/form-asrama.html',
    controller: 'AsramaController'
  })
  .when('/update-asrama/:id', {
    templateUrl: 'pages/asrama/form-asrama.html',
    controller: 'AsramaController'
  })
  .when('/anggota-asrama/:id', {
    templateUrl: 'pages/asrama/anggota-asrama.html',
    controller: 'AsramaController'
  })

  //paging untuk guru
  .when('/guru', {
    templateUrl: 'pages/guru/guru.html',
    controller: 'GuruController'
  })
  .when('/tambah-guru', {
    templateUrl: 'pages/guru/form-guru.html',
    controller: 'GuruController'
  })
  .when('/update-guru/:id', {
    templateUrl: 'pages/guru/form-guru.html',
    controller: 'GuruController'
  })

  //paging untuk akademik
  .when('/akademik', {
    templateUrl: 'pages/akademik/akademik.html',
    controller: 'AkademikController'
  })
  .when('/rpp', {
      templateUrl: 'pages/akademik/rpp.html',
      controller: 'RppController'
  })

  //paging untuk pegawai
  .when('/pegawai', {
    templateUrl: 'pages/pegawai/pegawai.html',
    controller: 'PegawaiController'
  })
  .when('/tambah-pegawai', {
    templateUrl: 'pages/pegawai/form-pegawai.html',
    controller: 'PegawaiController'
  })
  .when('/update-pegawai/:id', {
    templateUrl: 'pages/pegawai/form-pegawai.html',
    controller: 'PegawaiController'
  })
  .when('/detail-pegawai/:id', {
    templateUrl: 'pages/pegawai/detail-pegawai.html',
    controller: 'PegawaiController'
  })

  //paging untuk keuangan
  .when('/keuangan', {
    templateUrl: 'pages/keuangan/keuangan.html',
    controller: 'KeuanganController'
  })
  .otherwise({ redirectTo: '/' })
}

/* ---
  akhir code config
--- */



// CONFIG
/* ---
  semua config mulai disini
--- */

//filter ucwords
app.filter("ucwords", function () {
  return function (input){
    if(input) { //when input is defined the apply filter
      input = input.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
      });
    }
    return input;
  }
});

/* ---
  akhir code config
--- */




// FACTORY
/* ---
  semua factory mulai disini
--- */

//factoryGeolokasi
app.factory('factoryGeolokasi', function($http) {
  var factoryGeolokasi = {};

  factoryGeolokasi.getProvinsi = function() {
    return $http.get(base_url+'/msc/api/geolocation/provinsi.php');
  }

  factoryGeolokasi.getKabupaten = function(id) {
    return $http.get(base_url+'/msc/api/geolocation/kabupaten.php?provinsi_id='+id);
  }

  factoryGeolokasi.getKecamatan = function(id) {
    return $http.get(base_url+'/msc/api/geolocation/kecamatan.php?kabupaten_id='+id);
  }

  factoryGeolokasi.getDesa = function(id) {
    return $http.get(base_url+'/msc/api/geolocation/desa.php?kecamatan_id='+id);
  }

  return factoryGeolokasi;
});

//factorySiswa
app.factory('factorySiswa', function($http) {
  var factorySiswa = {};

  factorySiswa.getData = function(start, limit) {
    return $http.get(base_url+'/msc/api/siswa/siswa.php?start='+start+'&limit='+limit);
  }

  factorySiswa.getDetail = function(nis) {
    return $http.get(base_url+'/msc/api/siswa/detail.php?nis='+nis);
  };

  factorySiswa.aktifSiswa = function(nis) {
      return $http.get(base_url+'/msc/api/siswa/aktif.php?nis='+nis);
  }

  factorySiswa.getTingkat = function() {
    return $http.get(base_url+'/msc/api/tingkat/tingkat.php');
  }

  factorySiswa.getAsrama = function() {
    return $http.get(base_url+'/msc/api/siswa/asrama.php');
  }

  return factorySiswa;
});


//factoryKelas
app.factory('factoryKelas', function($http) {
  var factoryKelas = {};

  factoryKelas.getData = function() {
    return $http.get(base_url+'/msc/api/kelas/kelas.php');
  }

  factoryKelas.getDetail = function(id) {
    return $http.get(base_url+'/msc/api/kelas/detail.php?id='+id);
  }

  factoryKelas.getAnggota = function(id) {
    return $http.get(base_url+'/msc/api/kelas/anggota.php?id='+id);
  }

  return factoryKelas;
});


//factoryAsrama
app.factory('factoryAsrama', function($http) {
  var factoryAsrama = {};

  factoryAsrama.getData = function() {
    return $http.get(base_url+'/msc/api/asrama/asrama.php');
  }

  factoryAsrama.getDetail = function(id) {
    return $http.get(base_url+'/msc/api/asrama/detail.php?id='+id)
  }

  factoryAsrama.getAnggota = function(id) {
    return $http.get(base_url+'/msc/api/asrama/anggota.php?id='+id);
  }

  return factoryAsrama;
});


//factoryPegawai
app.factory('factoryPegawai', function($http) {
  var factoryPegawai = {};

  factoryPegawai.getData = function(start, limit) {
    return $http.get(base_url+'/msc/api/pegawai/pegawai.php?start='+start+'&limit='+limit);
  }

  factoryPegawai.getDetail = function(nip) {
    return $http.get(base_url+'/msc/api/pegawai/detail.php?nip='+nip);
  }

  factoryPegawai.aktifPegawai = function(nip) {
    return $http.get(base_url+'/msc/api/pegawai/aktif.php?nip='+nip);
  }

  return factoryPegawai;
});

//factoryGuru
app.factory('factoryGuru', function($http) {
  var factoryGuru = {};

  factoryGuru.getData = function() {
    return $http.get(base_url+'/msc/api/guru/guru.php');
  }

  factoryGuru.getDetail = function(id) {
    return $http.get(base_url+'/msc/api/guru/detail.php?id='+id);
  }

  factoryGuru.simpanGuru = function(data) {
    return $http.post(base_url+'/msc/api/guru/simpan.php', data);
  }

  return factoryGuru;
});

//factoryAkademik
app.factory('factoryAkademik', function($http) {
  var factoryAkademik = {};

  factoryAkademik.getData = function() {
    return $http.get(base_url+'/msc/api/akademik/akademik.php');
  }

  factoryAkademik.simpanPelajaran = function(data) {
    return $http.post(base_url+'/msc/api/akademik/simpan-pelajaran.php', data);
  }

  factoryAkademik.getRPP = function() {
    return $http.post(base_url+'/msc/api/akademik/rpp.php');
  }

  return factoryAkademik;
});

//factoryKeuangan
app.factory('factoryKeuangan', function($http) {
  var factoryKeuangan = {};

  factoryKeuangan.getLogTransaksi = function() {
    return $http.get(base_url+'/msc/api/keuangan/log_transaksi.php');
  };

  factoryKeuangan.getSummary = function() {
    return $http.get(base_url+'/msc/api/keuangan/summary.php');
  }

  return factoryKeuangan;
});

//factoryAllert
app.factory('SweetAlert', function() {
  var SweetAlert = {};
  SweetAlert.getAllert = function(status,title,message) {
    swal({
      title: title,
      type: status,
      text: message
    }).then(function() {

    });
  };

  return SweetAlert;
})

/* ---
  akhir code factory
--- */




// DIRECTIVES
/* ---
  semua directive mulai disini
--- */

// directive sidebar
app.directive('layoutSidebar', layoutSidebar);
function layoutSidebar() {
  return {
    restrict: 'A',
    templateUrl: 'layouts/sidebar.html'
  }
}

//directive footer
app.directive('layoutFooter', layoutFooter);
function layoutFooter() {
  return {
    restrict: 'A',
    templateUrl: 'layouts/footer.html'
  }
}

/* ---
  akhir code directive
--- */
