#ifndef KELASBIOSKOP_H
#define KELASBIOSKOP_H

#include <string>

using namespace std;

class KelasBioskop {
    private:
        string id;
        string namaKelas;
        int jumlahKursi;
        double harga;

    public:
        //constructor kosong
        KelasBioskop(){ }

        //constructor 
        KelasBioskop(string idInput, string nama, int kursi, double hrg){
            this->id = idInput;
            this->namaKelas = nama;
            this->jumlahKursi = kursi;
            this->harga = hrg;
        }

        //getter
        string getId() const { return id; }
        string getNamaKelas() const { return namaKelas; }
        int getJumlahKursi() const { return jumlahKursi; }
        double getHarga() const { return harga; }

        //setter (tanpa validasi)
        void setId(string idInput){ id = idInput; }
        void setNamaKelas(string nama){ namaKelas = nama; }
        void setJumlahKursi(int kursi){ jumlahKursi = kursi; }
        void setHarga(double hrg){ harga = hrg; }

        //destruktor
        ~KelasBioskop(){ }
};

#endif