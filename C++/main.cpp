#include <iostream>
#include <vector>
#include <limits>
#include <iomanip>
#include <algorithm>
#include "KelasBioskop.cpp"

using namespace std;

vector<KelasBioskop> daftarKelas; //deklarasi array untuk menyimpan data kelas

//fungsi untuk mencari index data berdasarkan ID
//mengembalikan index jika ditemukan, -1 jika tidak ditemukan
int cariIndexById(const string& id) {
    for (size_t i = 0; i < daftarKelas.size(); i++) { //looping seluruh elemen dalam array
        if (daftarKelas[i].getId() == id) return i; //jika id cocok, kembalikan index-nya
    }
    return -1; //jika tidak ditemukan
}

//prosedur pembantu untuk mencetak garis pembatas tabel secara dinamis
void cetakGaris(int wId, int wNama, int wKursi, int wHarga) {
    cout << "+" << string(wId + 2, '-') 
        << "+" << string(wNama + 2, '-') 
        << "+" << string(wKursi + 2, '-') 
        << "+" << string(wHarga + 2, '-') << "+\n";
}

//prosedur pembantu untuk menampilkan data dalam bentuk tabel dinamis
void tampilkanTabelDinamis(const vector<KelasBioskop>& data) {
    int wId = 2;        // panjang minimal header "ID"
    int wNama = 4;      // panjang minimal header "Nama"
    int wKursi = 5;     // panjang minimal header "Kursi"
    int wHarga = 10;    // panjang minimal header "Harga (Rp)"

    // menghitung lebar maksimum kolom berdasarkan isi data
    for (const auto& k : data) {
        wId = max(wId, (int)k.getId().length());
        wNama = max(wNama, (int)k.getNamaKelas().length());
        wKursi = max(wKursi, (int)to_string(k.getJumlahKursi()).length());
        wHarga = max(wHarga, (int)to_string((long long)k.getHarga()).length());
    }

    cetakGaris(wId, wNama, wKursi, wHarga);
    cout << "| " << left << setw(wId) << "ID"
        << " | " << left << setw(wNama) << "Nama"
        << " | " << left << setw(wKursi) << "Kursi"
        << " | " << left << setw(wHarga) << "Harga (Rp)" << " |\n";
    cetakGaris(wId, wNama, wKursi, wHarga);

    for (const auto& k : data) {
        cout << "| " << left << setw(wId) << k.getId()
            << " | " << left << setw(wNama) << k.getNamaKelas()
            << " | " << left << setw(wKursi) << k.getJumlahKursi()
            << " | " << left << setw(wHarga) << fixed << setprecision(0) << k.getHarga() << " |\n";
    }
    cetakGaris(wId, wNama, wKursi, wHarga);
}

//prosedur untuk menambah data kelas baru
void tambahData() {
    string id, nama;
    double harga;
    int kursi;
    char opsi;

    cout << "ID Kelas Penayangan: "; cin >> id;
    if (id.empty()) { //validasi ID tidak boleh kosong
        cout << "Error: ID tidak boleh kosong!\n";
        return;
    }
    if (cariIndexById(id) != -1) { //validasi ID tidak boleh duplikat
        cout << "Error: ID sudah terdaftar!\n";
        return;
    }
    cin.ignore(numeric_limits<streamsize>::max(), '\n'); //membersihkan buffer sebelum getline
    cout << "Nama Kelas Penayangan: "; getline(cin, nama);
    if (nama.empty()) { //validasi nama tidak boleh kosong
        cout << "Error: Nama kelas tidak boleh kosong!\n";
        return;
    }
    cout << "Harga Tiket: "; 
    if (!(cin >> harga)) { //validasi format input harga harus angka
        cout << "Error: Format harga salah!\n";
        cin.clear(); cin.ignore(numeric_limits<streamsize>::max(), '\n');
        return;
    }
    if (harga <= 0) { //validasi harga harus lebih dari 0
        cout << "Error: Harga tiket harus lebih dari 0!\n";
        return;
    }

    cout << "Jumlah Kursi: "; cin >> kursi;
    if (kursi < 0) { //validasi jumlah kursi tidak boleh negatif
        cout << " Error: Jumlah kursi tidak boleh negatif!\n";
        return;
    }
    daftarKelas.push_back(KelasBioskop(id, nama, kursi, harga)); //tambah data 
    
    cout << " Data berhasil ditambahkan!\n";
}

//prosedur untuk menampilkan seluruh data kelas yang tersimpan
void tampilkanData() {
    if (daftarKelas.empty()) { //jika array masih kosong
        cout << "Belum ada data kelas Penayangan.\n";
        return;
    }
    cout << "\n--- DAFTAR KELAS TEMPAT DUDUK ---\n";
    tampilkanTabelDinamis(daftarKelas);
}

//prosedur untuk memperbarui data kelas berdasarkan ID
void updateData() {
    string id;
    cout << "Masukkan ID Kelas Penayangan yang diubah: "; cin >> id;
    int idx = cariIndexById(id); //cari index data berdasarkan ID
    if (idx == -1) { //jika ID tidak ditemukan
        cout << " Error: Data tidak ditemukan!\n";
        return;
    }

    string nama; int kursi; double harga;
    cin.ignore(numeric_limits<streamsize>::max(), '\n'); //membersihkan buffer sebelum getline
    cout << "Nama Kelas Penayangan Baru: "; getline(cin, nama);
    if (nama.empty()) { //validasi nama tidak boleh kosong
        cout << " Error: Nama kelas tidak boleh kosong!\n";
        return;
    }
    cout << "Jumlah Kursi Baru: "; cin >> kursi;
    if (kursi < 0) { //validasi jumlah kursi tidak boleh negatif
        cout << " Error: Jumlah kursi tidak boleh negatif!\n";
        return;
    }
    cout << "Harga Tiket Baru: "; cin >> harga;
    if (harga <= 0) { //validasi harga harus lebih dari 0
        cout << " Error: Harga tiket harus lebih dari 0!\n";
        return;
    }

    //update data melalui setter
    daftarKelas[idx].setNamaKelas(nama);
    daftarKelas[idx].setJumlahKursi(kursi);
    daftarKelas[idx].setHarga(harga);
    cout << "Data berhasil diperbarui!\n";
}

//prosedur untuk menghapus data kelas berdasarkan ID
void hapusData() {
    string id;
    cout << "Masukkan ID Kelas Penayangan yang dihapus: "; cin >> id;
    int idx = cariIndexById(id); //cari index data berdasarkan ID
    if (idx != -1) { //jika data ditemukan
        daftarKelas.erase(daftarKelas.begin() + idx); //hapus data dari array
        cout << " Data berhasil dihapus!\n";
    } else {
        cout << " Error: Data tidak ditemukan!\n";
    }
}

//prosedur untuk mencari dan menampilkan data kelas berdasarkan ID
void cariData() {
    string id;
    cout << "Masukkan ID Kelas Penayangan yang dicari: "; cin >> id;
    int idx = cariIndexById(id); //cari index data berdasarkan ID
    if (idx != -1) { //jika data ditemukan
        tampilkanTabelDinamis({daftarKelas[idx]});
    } else {
        cout << " Error: Data tidak ditemukan!\n";
    }
}

//fungsi utama, menampilkan menu dan mengatur alur program
int main() {
    int pilihan;
    //data awal
    daftarKelas.push_back(KelasBioskop("101", "The Premier XXI", 40, 150000));
    daftarKelas.push_back(KelasBioskop("102", "IMAX", 300, 85000));
    daftarKelas.push_back(KelasBioskop("103", "Deluxe", 100, 65000));

    do {
        //menampilkan menu pilihan ke user
        cout << "\n=== KELOLA KELAS TEMPAT DUDUK BIOSKOP ===\n";
        cout << "1. Tambah Kelas\n2. Tampilkan Kelas\n3. Update Kelas\n4. Hapus Kelas\n5. Cari Kelas\n6. Keluar\nPilihan: ";
        if (!(cin >> pilihan)) { //validasi input menu harus berupa angka
            cout << " Error Input: Masukkan angka menu!\n";
            cin.clear(); cin.ignore(numeric_limits<streamsize>::max(), '\n');
            continue;
        }

        //memanggil fungsi sesuai pilihan menu
        switch (pilihan) {
            case 1: tambahData(); break; //opsi 1: tambah data kelas
            case 2: tampilkanData(); break; //opsi 2: tampilkan seluruh data kelas
            case 3: updateData(); break; //opsi 3: perbarui data kelas
            case 4: hapusData(); break; //opsi 4: hapus data kelas
            case 5: cariData(); break; //opsi 5: cari data kelas berdasarkan ID
        }
    } while (pilihan != 6); //ulangi selama user belum memilih opsi keluar (6)
    return 0;
}