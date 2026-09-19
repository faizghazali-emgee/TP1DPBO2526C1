<?php

class KelasBioskop {
    private $id;
    private $namaKelas;
    private $jumlahKursi;
    private $harga;

    public function __construct($id = "", $nama = "", $kursi = 50, $harga = 0) {
        $this->id = $id;
        $this->namaKelas = $nama;
        $this->jumlahKursi = $kursi;
        $this->harga = $harga;
    }

    // Getter
    public function getId() {
        return $this->id;
    }

    public function getNamaKelas() {
        return $this->namaKelas;
    }

    public function getJumlahKursi() {
        return $this->jumlahKursi;
    }

    public function getHarga() {
        return $this->harga;
    }

    // Setter
    public function setId($id) {
        $this->id = $id;
    }

    public function setNamaKelas($nama) {
        $this->namaKelas = $nama;
    }

    public function setJumlahKursi($kursi) {
        $this->jumlahKursi = $kursi;
    }

    public function setHarga($harga) {
        $this->harga = $harga;
    }
}