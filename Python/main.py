#Mengimpor kelas dari KelasBioskop.py
from KelasBioskop import KelasBioskop

#List global untuk menyimpan semua objek KelasBioskop
daftar_kelas = []

#mencari Posisi Index di daftar Kelas
#mengembalikan index kalo ada, klo gaada mengembalikan -1
def cari_index_by_id(id_search: str) -> int:
    for i, item in enumerate(daftar_kelas):
        if item.get_id() == id_search:
            return i
    return -1

#Mencetak Garis Pembatas
#panjang tiap kolom ditambah 2 spasi di kiri dan kanan sisi kolom
def cetak_garis(w_id: int, w_nama: int, w_kursi: int, w_harga: int):
    print(f"+{'-' * (w_id + 2)}+{'-' * (w_nama + 2)}+{'-' * (w_kursi + 2)}+{'-' * (w_harga + 2)}+")

#menampilkan data dalam bentuk tabel yang dinamis
#parameternya dari list objek kelasbioskop
def tampilkan_tabel_dinamis(data: list):
    #lebar minimum
    w_id, w_nama, w_kursi, w_harga = 2, 4, 5, 10

    for k in data:
        w_id = max(w_id, len(k.get_id()))
        w_nama = max(w_nama, len(k.get_nama_kelas()))
        w_kursi = max(w_kursi, len(str(k.get_jumlah_kursi())))
        w_harga = max(w_harga, len(str(int(k.get_harga()))))

    #cetak header
    cetak_garis(w_id, w_nama, w_kursi, w_harga)
    print(f"| {'ID':<{w_id}} | {'Nama':<{w_nama}} | {'Kursi':<{w_kursi}} | {'Harga (Rp)':<{w_harga}} |")
    cetak_garis(w_id, w_nama, w_kursi, w_harga)

    #cetak setiap baris data
    for k in data:
        print(f"| {k.get_id():<{w_id}} | {k.get_nama_kelas():<{w_nama}} | {k.get_jumlah_kursi():<{w_kursi}} | {int(k.get_harga()):<{w_harga}} |")
    cetak_garis(w_id, w_nama, w_kursi, w_harga)

#Menambah jenis tingkatan kelas yang baru
def tambah_data():
    id_input = input("ID Kelas Penayangan: ").strip()
    if not id_input:
        print("Error: ID tidak boleh kosong!")
        return
    #Validasi id yang memang harus unik
    if cari_index_by_id(id_input) != -1:
        print("Error: ID sudah terdaftar!")
        return
    #input nama kelas
    nama = input("Nama Kelas Penayangan: ").strip()
    if not nama:#gabole kosong
        print("Error: Nama kelas tidak boleh kosong!")
        return
    #input harga tiket
    try:
        harga = float(input("Harga Tiket: "))
        if harga <= 0:#kalo angkanya minus
            print("Error: Harga tiket harus lebih dari 0!")
            return
    except ValueError:#kalo bukan angka
        print("Error: Format harga salah!")
        return

    #input jumlah kursi, untuk syaratnya kurang lebih sama kayak harga tiket
    try:
        kursi = int(input("Jumlah Kursi: "))
        if kursi < 0:
            print("Error: Jumlah kursi tidak boleh negatif!")
            return
    except ValueError:
        print("Error: Format kursi salah!")
        return
    #disimpan datanya kedalam daftar
    daftar_kelas.append(KelasBioskop(id_input, nama, kursi, harga))
    print("Data berhasil ditambahkan!")

#menampilkan seluruh data kelas dalam bentuk tabel
def tampilkan_data():
    if not daftar_kelas:#cek apakah list nya kosong atau kga
        print("Belum ada data kelas Penayangan.")
        return
    print("\n--- DAFTAR KELAS TEMPAT DUDUK ---")
    tampilkan_tabel_dinamis(daftar_kelas)

#memperbaharui data bedasarkan id
def update_data():
    id_input = input("Masukkan ID Kelas Penayangan yang diubah: ").strip()
    idx = cari_index_by_id(id_input)
    if idx == -1:#kalo idnya tidak ditemukan
        print("Error: Data tidak ditemukan!")
        return
    #input nama baru
    nama = input("Nama Kelas Penayangan Baru: ").strip()
    if not nama:
        print("Error: Nama kelas tidak boleh kosong!")
        return

    #input kursi dan harga
    try:
        kursi = int(input("Jumlah Kursi Baru: "))
        if kursi < 0:
            print("Error: Jumlah kursi tidak boleh negatif!")
            return
        harga = float(input("Harga Tiket Baru: "))
        if harga <= 0:
            print("Error: Harga tiket harus lebih dari 0!")
            return
    except ValueError:
        print("Error: Format input salah!")
        return

    #perbarui data
    daftar_kelas[idx].set_nama_kelas(nama)
    daftar_kelas[idx].set_jumlah_kursi(kursi)
    daftar_kelas[idx].set_harga(harga)
    print("Data berhasil diperbarui!")

#data dihapus bedasarkan id
def hapus_data():
    id_input = input("Masukkan ID Kelas Penayangan yang dihapus: ").strip()
    idx = cari_index_by_id(id_input)
    if idx != -1:
        daftar_kelas.pop(idx)#ngehapus data bedasarkan id yang diinginkan
        print("Data berhasil dihapus!")
    else:#kalo gaada idnya
        print("Error: Data tidak ditemukan!")

#cari seuatu kelas dengan menggunakan id
def cari_data():
    id_input = input("Masukkan ID Kelas Penayangan yang dicari: ").strip()
    idx = cari_index_by_id(id_input)
    if idx != -1:
        tampilkan_tabel_dinamis([daftar_kelas[idx]])
    else:
        print("Error: Data tidak ditemukan!")

def main():
    #mengisi data awal/dummy
    daftar_kelas.append(KelasBioskop("101", "The Premier XXI", 40, 150000))
    daftar_kelas.append(KelasBioskop("102", "IMAX", 300, 85000))
    daftar_kelas.append(KelasBioskop("103", "Deluxe", 100, 65000))

    #perulangan sampai memilih (6) atau keluar
    while True:
        print("\n=== KELOLA KELAS TEMPAT DUDUK BIOSKOP ===")
        print("1. Tambah Kelas\n2. Tampilkan Kelas\n3. Update Kelas\n4. Hapus Kelas\n5. Cari Kelas\n6. Keluar")
        try:
            pilihan = int(input("Pilihan: "))
        except ValueError:
            print("Error Input: Masukkan angka menu!")
            continue

        #memanggil Fungsi Pilihan
        if pilihan == 1: tambah_data()
        elif pilihan == 2: tampilkan_data()
        elif pilihan == 3: update_data()
        elif pilihan == 4: hapus_data()
        elif pilihan == 5: cari_data()
        elif pilihan == 6: break

if __name__ == "__main__":
    main()