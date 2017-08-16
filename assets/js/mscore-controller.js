
// CONTROLLER
/* ---
  semua controller mulai disini
--- */

// batas controller Siswa
app.controller('SiswaController', SiswaController);
function SiswaController($scope, factorySiswa, factoryGeolokasi, $http, SweetAlert, $window, $location, $routeParams, cfpLoadingBar) {
  cfpLoadingBar.start();

  $scope.formSiswa = {};
  $scope.formSiswa.update = "false";

  //variable untuk dapetin parameter nis siswa
  //update siswa
  var nis = $routeParams.nis;
  if(nis){
    //runing fungsi untuk ngambil data siswa
    getDetailSiswa(nis);
  }

  function getDetailSiswa(nis) {
    factorySiswa.getDetail(nis).success(function(response) {
      $scope.formSiswa = response;
      $scope.formSiswa.update = "true";
    });
  }

  //fungsi factory untuk dapetin provinsi
  factoryGeolokasi.getProvinsi().success(function(response) {
    $scope.provinsis = response;
  });


  //fungsi untuk dapetin kabupaten setelah milih provinsi
  $scope.getKabupaten = function(provinsi) {

    //dikosongin select option nya dulu
    $scope.kecamatans = [];
    $scope.desas = [];

    factoryGeolokasi.getKabupaten(provinsi.id).success(function(response) {
      $scope.kabupatens = response;
    });
  };

  //fungsi untuk dapetin kecamatan setelah milih kabupaten
  $scope.getKecamatan = function(kabupaten) {

    //dikosongin select option nya dulu
    $scope.desas = [];

    factoryGeolokasi.getKecamatan(kabupaten.id).success(function(response) {
      $scope.kecamatans = response;
    });
  };

  //fungsi untuk dapetin desa setelah milih kecamatan
  $scope.getDesa = function(kecamatan) {

    factoryGeolokasi.getDesa(kecamatan.id).success(function(response) {
      $scope.desas = response;
    });
  }

  $scope.siswa = [];

  //definisi variable untuk pagination
  $scope.isShow = true;
  $scope.start = 0;
  $scope.limit = 200;

  //menampilkan data siswa
  factorySiswa.getData($scope.start*$scope.limit, $scope.limit).success(function(response) {
    $scope.siswa = response.data;
    $scope.siswaTotal = response.total;
  });

  //loadmore atau pagination
  $scope.loadMore = function() {
    cfpLoadingBar.start();
    $scope.start++;
    factorySiswa.getData($scope.start*$scope.limit, $scope.limit).success(function(response) {
      angular.forEach(response.data, function(data){
           $scope.siswa.push(data);
      });
    });
  }

  //disable tombol loadmore kalo datanya udah di-load semua
  $scope.loadMoreDisabled = function() {
    if($scope.siswa.length >= $scope.siswaTotal) {
        return true;
    }
  }


  //fungsi ajax nyimpen data siswa
  $scope.simpanSiswa = function() {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
    method  : 'POST',
    url     : 'api/siswa/simpan.php',
    data    : $scope.formSiswa,  // pass in data as strings
    //headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
   })
    .success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);
      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  };

  $scope.aktifSiswa = function(index, nis, nama) {

    var aktif = $scope.siswa[index].aktif;
    if(aktif == 1) {
        var text = nama+" akan di non-aktifkan!";
        var buttonconfirm = "Serius, non-aktifkan aja!";
    } else {
        var text = nama+" akan di aktifkan kembali!";
        var buttonconfirm = "Serius, aktifkan lagi!";
    }

    swal({
        title: 'Serius nih?',
        text: text,
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#C1C1C1',
        confirmButtonColor: '#d9534f',
        cancelButtonText: 'Jangan',
        confirmButtonText: buttonconfirm,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                factorySiswa.aktifSiswa(nis).success(function(response) {
                  var aktif = response.aktif;

                  resolve(aktif);
                });
            })
        },
        allowOutsideClick: false
    }).then(function (aktif) {
        $scope.siswa[index].aktif = aktif;
        if(aktif == 1) {
            var icon = 'smile';
            swal({
                type: 'success',
                title: 'Alhamdulillah',
                text: nama+' berhasil di aktifkan kembali!'
            })
        } else {
            var icon = 'sad';
            swal({
                type: 'success',
                title: 'Alhamdulillah',
                text: nama+' berhasil di non-aktifkan!'
            })
        }
        $scope.siswa[index].icon = icon;
    })
  }

  $scope.cetakKartu = function(nis) {
    $window.open('pages/siswa/kartu-siswa.php?nis='+nis, 'MSC', 'width=351,height=232');
  }

  $scope.cetakSiswa = function(nis) {
    $window.open('pages/siswa/detail-siswa.php?nis='+nis, 'MSC', 'width=1000,height=700');
  }
}
// batas controller Siswa


//batas controller kelas
app.controller('KelasController', KelasController);
function KelasController($scope, $window, SweetAlert, factorySiswa, factoryKelas, $http, $routeParams, cfpLoadingBar) {
  cfpLoadingBar.start();

  $scope.formKelas = {};
  $scope.formKelas.update = "false";

  var id = $routeParams.id;
  if(id) {
    getDetailKelas(id);
  }

  //fungsi dapetin detail kelas
  function getDetailKelas(id) {
    factoryKelas.getDetail(id).success(function(response) {
      $scope.formKelas = response;
      //default value untuk select tingkat kelas
      $scope.formKelas.id_tingkat = {"id":response.id_tingkat,"tingkat":response.tingkat};
      //default value untuk menunjukkan kalo ini adalah sesi update
      $scope.formKelas.update = "true";
    })
  }

  //fungsi factory untuk menampilkan data kelas
  factoryKelas.getData().success(function(response) {
    $scope.kelas = response;
  });

  //fungsi factory untuk menampilkan anggota kelas
  factoryKelas.getAnggota(id).success(function(response) {
    $scope.anggota = response.anggota;
    $scope.siswa = response.siswa;
  });

  factorySiswa.getTingkat().success(function(response) {
    $scope.tingkats = response;
  });


  //fungsi untuk memasukkan siswa kedalam aggota kelas
  //fungsi untuk mengularkan siswa dari anggota kelas
  $scope.simpanAnggota = function($index, nis, nama, type, id) {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
      method: 'POST',
      url: 'api/kelas/simpan-anggota.php',
      data: {id:id,nis:nis,type:type}
    })
    .success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);

        //menghilangkan nama dari daftar anggota
        var anggota = {"nis":nis,"nama":nama};
        if(type == 'masuk') {
          $scope.anggota.push(anggota);
          $scope.siswa.splice($index, 1);
        } else {
          $scope.anggota.splice($index, 1);
          $scope.siswa.push(anggota)
        }

      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  }

  //fungsi ajax nyimpen data kelas
  $scope.simpanKelas = function() {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
      method: 'POST',
      url: 'api/kelas/simpan.php',
      data: $scope.formKelas
    })
    .success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);
      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  }

  $scope.cetakAnggotaKelas = function(id) {
    $window.open('pages/kelas/anggota-kelas.php?id='+id, 'MSC', 'width=650,height=660');
  }

}
//batas controller kelas


//batas controller asrama
app.controller('AsramaController', AsramaController);
function AsramaController($scope, factoryAsrama, $http, SweetAlert, $routeParams, cfpLoadingBar) {
  cfpLoadingBar.start();

  $scope.formAsrama = {};
  $scope.formAsrama.update = "false";

  var id = $routeParams.id;
  if(id) {
    getDetailAsrama(id);
  }

  function getDetailAsrama(id) {
    factoryAsrama.getDetail(id).success(function(response) {
      $scope.formAsrama = response;
      //default value untuk menunjukkan kalo ini adalah sesi update
      $scope.formAsrama.update = "true";
    });
  }

  $scope.pilihPegawai = function(nip) {
    $scope.formAsrama.nipwali = nip;
  }

  //fungsi factory untuk menampilkan asrama
  factoryAsrama.getData().success(function(response) {
    $scope.asrama = response;
  });

  //fungsi factory untuk menampilkan anggota kelas
  factoryAsrama.getAnggota(id).success(function(response) {
    $scope.anggota = response.anggota;
    $scope.siswa = response.siswa;
  });

  //fungsi untuk memasukkan siswa kedalam aggota kelas
  //fungsi untuk mengularkan siswa dari anggota kelas
  $scope.simpanAnggota = function($index, nis, nama, type, id) {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
      method: 'POST',
      url: 'api/asrama/simpan-anggota.php',
      data: {id:id,nis:nis,type:type}
    })
    .success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);

        //menghilangkan nama dari daftar anggota
        var anggota = {"nis":nis,"nama":nama};
        if(type == 'masuk') {
          $scope.anggota.push(anggota);
          $scope.siswa.splice($index, 1);
        } else {
          $scope.anggota.splice($index, 1);
          $scope.siswa.push(anggota)
        }

      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  }

  //fungsi ajax nyimpen data asrama
  $scope.simpanAsrama = function() {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
      method: 'POST',
      url: 'api/asrama/simpan.php',
      data: $scope.formAsrama
    })
    .success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);
      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  }

}

//batas controller asrama


//batas controller pegawai
app.controller('PegawaiController', PegawaiController);
function PegawaiController($scope, factoryPegawai, $http, $window, cfpLoadingBar, $routeParams, SweetAlert) {
  cfpLoadingBar.start();

  $scope.formPegawai = {};
  $scope.formPegawai.update = "false";

  //variable untuk dapetin parameter nis siswa
  //update siswa
  var nip = $routeParams.id;
  if(nip){
    //runing fungsi untuk ngambil data siswa
    getDetailPegawai(nip);
    console.log(nip);
  }

  function getDetailPegawai(nip) {
    factoryPegawai.getDetail(nip).success(function(response) {
      $scope.formPegawai = response;
      $scope.formPegawai.update = "true";
    });
  }

  $scope.pegawai = [];

  //definisi variable untuk pagination
  $scope.isShow = true;
  $scope.start = 0;
  $scope.limit = 50;

  //menampilkan data pegawai
  factoryPegawai.getData($scope.start*$scope.limit, $scope.limit).success(function(response) {
    $scope.pegawai = response.data;
    $scope.pegawaiTotal = response.total;
  });

  //loadmore atau pagination
  $scope.loadMore = function() {
    cfpLoadingBar.start();
    $scope.start++;
    factoryPegawai.getData($scope.start*$scope.limit, $scope.limit).success(function(response) {
      angular.forEach(response.data, function(data){
           $scope.pegawai.push(data);
      });
    });
  }

  //disable tombol loadmore kalo datanya udah di-load semua
  $scope.loadMoreDisabled = function() {
    if($scope.pegawai.length >= $scope.pegawaiTotal) {
        return true;
    }
  }

  //fungsi ajax nyimpen data siswa
  $scope.simpanPegawai = function() {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
    method  : 'POST',
    url     : 'api/pegawai/simpan.php',
    data    : $scope.formPegawai,  // pass in data as strings
    //headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  // set the headers so angular passing info as form data (not request payload)
   })
    .success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);
      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  };

  $scope.aktifPegawai = function(index, nip, nama) {
    var aktif = $scope.pegawai[index].aktif;
    if(aktif == 1) {
        var text = nama+" akan di non-aktifkan!";
        var buttonconfirm = "Serius, non-aktifkan aja!";
    } else {
        var text = nama+" akan di aktifkan kembali!";
        var buttonconfirm = "Serius, aktifkan lagi!";
    }

    swal({
        title: 'Serius nih?',
        text: text,
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#C1C1C1',
        confirmButtonColor: '#d9534f',
        cancelButtonText: 'Jangan',
        confirmButtonText: buttonconfirm,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve, reject) {
                factoryPegawai.aktifPegawai(nip).success(function(response) {
                  var aktif = response.aktif;

                  resolve(aktif);
                });
            })
        },
        allowOutsideClick: false
    }).then(function (aktif) {
        $scope.pegawai[index].aktif = aktif;
        if(aktif == 1) {
            var icon = 'smile';
            swal({
                type: 'success',
                title: 'Alhamdulillah',
                text: nama+' berhasil di aktifkan kembali!'
            })
        } else {
            var icon = 'sad';
            swal({
                type: 'success',
                title: 'Alhamdulillah',
                text: nama+' berhasil di non-aktifkan!'
            })
        }
        $scope.pegawai[index].icon = icon;
    })
  }

  $scope.cetakPegawai = function(nip) {
    $window.open('pages/pegawai/detail-pegawai.php?nip='+nip, 'MSC', 'width=1000,height=700');
  }

}
//batas controller pegawai

//batas controller guru
app.controller('GuruController', GuruController);
function GuruController($scope, factoryGuru, factoryAkademik, $http, cfpLoadingBar, SweetAlert, $routeParams) {
  cfpLoadingBar.start();

  $scope.formGuru = {};
  $scope.formGuru.update = 'false';

  var nip = $routeParams.id;
  if(nip) {
    factoryGuru.getDetail(nip).success(function(response) {
      $scope.formGuru = response;
      $scope.formGuru.update = "true";
      $scope.formGuru.id_pelajaran = {"id":response.id_pelajaran,"pelajaran":response.pelajaran};
    });

  }

  //fungsi factory untuk menampilkan data guru
  factoryGuru.getData().success(function(response) {
    $scope.guru = response;
  });

  //fungsi factory untuk menampilkan pilihan mata pelajaran
  $scope.pelajarans = [];
  factoryAkademik.getData().success(function(response) {
    angular.forEach(response, function(data){
      $scope.pelajarans.push({id:data.id,pelajaran:data.pelajaran});
    });
  });

  $scope.pilihGuru = function(nip, nama) {
    $scope.formGuru.nip = nip;
    $scope.formGuru.nama = nama;
    $scope.formKelas.nipwali = nip;
  }

  $scope.simpanGuru = function() {
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    factoryGuru.simpanGuru($scope.formGuru).success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);
      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });
  }

}
//batas controller guru


//batas controller akademik
app.controller('AkademikController', AkademikController);
function AkademikController($scope, factoryAkademik, $http, cfpLoadingBar, SweetAlert) {
  cfpLoadingBar.start();

  $scope.formPelajaran = {};
  $scope.formPelajaran.update = "false";

  factoryAkademik.getData().success(function(response) {
    $scope.akademik = response;
  });

  $scope.updateSiswa = function(index) {
    $scope.formPelajaran = $scope.akademik[index];
    $scope.formPelajaran.update = "true";
  }

  $scope.simpanPelajaran = function(){
    cfpLoadingBar.start();
    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    factoryAkademik.simpanPelajaran($scope.formPelajaran).success(function(data) {
      if(data.success) {
        //notifikasi
        SweetAlert.getAllert('success', 'Alhamdulillah!', data.message);
        $scope.akademik.push($scope.formPelajaran);
      } else {
        //notifikasi
        SweetAlert.getAllert('error', 'Astagfirullah!', data.message);
      }
    });

  }
}

//batas controller akademik
app.controller('RppController', RppController);
function RppController($scope, $http, cfpLoadingBar, factoryAkademik, $window) {
  cfpLoadingBar.start();

  factoryAkademik.getRPP().success(function(response) {
    $scope.rpp = response;
  });

  $scope.uploadRPP = function(nip) {
      var left = screen.width/2 - 200;
      var top = screen.height/2 - 200;
      $window.open('pages/akademik/upload-rpp.php?nip='+nip, 'MSC', 'width=351,height=388,left='+left+',top='+top);
  }
}

//batas controller keuangan
app.controller('KeuanganController', KeuanganController);
function KeuanganController($scope, factorySiswa, factoryKeuangan, $http, cfpLoadingBar, SweetAlert) {
  cfpLoadingBar.start();

  $scope.tanggal = new Date();

  //fungsi factory untuk menampilkan summary keuangan
  factoryKeuangan.getSummary().success(function(response) {
    $scope.summaries = response;
  });

  //fungsi factory untuk menampilkan log transaksi harian
  factoryKeuangan.getLogTransaksi().success(function(response) {
    $scope.transaksi = response;
  });

  //definisi form supaya jadi array object
  $scope.formTransaksi = {};

  //definisi form spp
  $scope.spp = [{id: 'spp1'}];
  //fungsi supaya bisa nambahin form spp lebih dari satu
  $scope.addNewChoice = function() {
    var newItemNo = $scope.spp.length+1;
    $scope.spp.push({'id':'spp'+newItemNo});
  };

  //fungsi pilih key untuk nis dan nama
  $scope.pilihSiswa = function(nis,nama) {
    $scope.nis  = nis;
    $scope.nama = nama;
  }

  //fungsi ajax untuk menyimpan transaksi
  $scope.simpanTransaksi = function() {
    cfpLoadingBar.start();

    //notifikasi
    SweetAlert.getAllert('info', 'Loading...', 'Sabar sebentar yah :)');

    $http({
      method  : 'POST',
      url     : 'api/keuangan/transaksi.php',
      data    : {
        nis: $scope.nis,
        nama: $scope.nama,
        transfer: $scope.transfer,
        tanggal: $scope.tanggal,
        petugas: $scope.petugas,
        pangkal:$scope.formTransaksi,
        spp:$scope.spp
      },
      header  : { 'Content-Type':'application/x-www-form-urlencoded'}
    })
    .success(function(response) {
      //notifikasi
      SweetAlert.getAllert('success', 'Alhamdulillah!', 'Data sudah tersimpan');
      $scope.transaksi = response;
    })
  }

}
//batas controller keuangan
