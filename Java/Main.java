package Java; //tempat dimana file itu dikumpulkan
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class Main {
    //list statis untuk menyimpan semua objek kelasbioskop (database sementara)
    private static List<KelasBioskop> daftarKelas = new ArrayList<>();
    //scanner membaca input
    private static Scanner scanner = new Scanner(System.in);

    //cari index objek di daftar kelas bedasarkan id, mengembalikan index/-1 jika tidak ditemukan
    private static int cariIndexById(String id) {
        for (int i = 0; i < daftarKelas.size(); i++) {
            if (daftarKelas.get(i).getId().equals(id)) return i;
        }
        return -1;
    }

    //untuk mencetak garis pembatas tabel
    private static void cetakGaris(int wId, int wNama, int wKursi, int wHarga) {
        System.out.println("+" + "-".repeat(wId + 2) +
                            "+" + "-".repeat(wNama + 2) +
                            "+" + "-".repeat(wKursi + 2) +
                            "+" + "-".repeat(wHarga + 2) + "+");
    }

    //untuk mencetak garis tabel
    private static void tampilkanTabelDinamis(List<KelasBioskop> data) {
        int wId = 2, wNama = 4, wKursi = 5, wHarga = 10;

        for (KelasBioskop k : data) {
            wId = Math.max(wId, k.getId().length());
            wNama = Math.max(wNama, k.getNamaKelas().length());
            wKursi = Math.max(wKursi, String.valueOf(k.getJumlahKursi()).length());
            wHarga = Math.max(wHarga, String.valueOf((long) k.getHarga()).length());
        }

        cetakGaris(wId, wNama, wKursi, wHarga);
        System.out.printf("| %-"+wId+"s | %-"+wNama+"s | %-"+wKursi+"s | %-"+wHarga+"s |\n",
                "ID", "Nama", "Kursi", "Harga (Rp)");
        cetakGaris(wId, wNama, wKursi, wHarga);

        for (KelasBioskop k : data) {
            System.out.printf("| %-"+wId+"s | %-"+wNama+"s | %-"+wKursi+"d | %-"+wHarga+".0f |\n",
                    k.getId(), k.getNamaKelas(), k.getJumlahKursi(), k.getHarga());
        }
        cetakGaris(wId, wNama, wKursi, wHarga);
    }

    //untuk menambah data
    public static void tambahData() {
        System.out.print("ID Kelas Penayangan: ");
        String id = scanner.nextLine().trim();
        if (id.isEmpty()) {//kalo id nya diisi kosong
            System.out.println("Error: ID tidak boleh kosong!");
            return;
        }
        if (cariIndexById(id) != -1) {//kalo idnya udah ada
            System.out.println("Error: ID sudah terdaftar!");
            return;
        }

        System.out.print("Nama Kelas Penayangan: ");
        String nama = scanner.nextLine().trim();
        if (nama.isEmpty()) {//nama kelas juga gaboleh kosong
            System.out.println("Error: Nama kelas tidak boleh kosong!");
            return;
        }

        System.out.print("Harga Tiket: ");
        double harga;
        try {
            harga = Double.parseDouble(scanner.nextLine());
            if (harga <= 0) {//harga tiket gaboleh 0 atau minus
                System.out.println("Error: Harga tiket harus lebih dari 0!");
                return;
            }
        } catch (NumberFormatException e) {//kalo harga pake huruf
            System.out.println("Error: Format harga salah!");
            return;
        }
        //kurang lebih jumlah kursi sama kayak harga tiket
        System.out.print("Jumlah Kursi: ");
        int kursi;
        try {
            kursi = Integer.parseInt(scanner.nextLine());
            if (kursi < 0) {
                System.out.println("Error: Jumlah kursi tidak boleh negatif!");
                return;
            }
        } catch (NumberFormatException e) {
            System.out.println("Error: Format kursi salah!");
            return;
        }

        daftarKelas.add(new KelasBioskop(id, nama, kursi, harga));
        System.out.println("Data berhasil ditambahkan!");
    }

    //menampilkan data
    public static void tampilkanData() {
        if (daftarKelas.isEmpty()) {
            System.out.println("Belum ada data kelas Penayangan.");
            return;
        }
        System.out.println("\n--- DAFTAR KELAS TEMPAT DUDUK ---");
        tampilkanTabelDinamis(daftarKelas);
    }

    //mengubah data bedasarkan id yang diminta
    //setelah diminta id, prosesnya sama seperti input data
    public static void updateData() {
        System.out.print("Masukkan ID Kelas Penayangan yang diubah: ");
        String id = scanner.nextLine().trim();
        int idx = cariIndexById(id);
        if (idx == -1) {
            System.out.println("Error: Data tidak ditemukan!");
            return;
        }

        System.out.print("Nama Kelas Penayangan Baru: ");
        String nama = scanner.nextLine().trim();
        if (nama.isEmpty()) {
            System.out.println("Error: Nama kelas tidak boleh kosong!");
            return;
        }

        System.out.print("Jumlah Kursi Baru: ");
        int kursi = Integer.parseInt(scanner.nextLine());
        if (kursi < 0) {
            System.out.println("Error: Jumlah kursi tidak boleh negatif!");
            return;
        }

        System.out.print("Harga Tiket Baru: ");
        double harga = Double.parseDouble(scanner.nextLine());
        if (harga <= 0) {
            System.out.println("Error: Harga tiket harus lebih dari 0!");
            return;
        }

        KelasBioskop k = daftarKelas.get(idx);
        k.setNamaKelas(nama);
        k.setJumlahKursi(kursi);
        k.setHarga(harga);
        System.out.println("Data berhasil diperbarui!");
    }

    //untuk menghapus data
    public static void hapusData() {
        //minta id nya yang pengen dihapus
        System.out.print("Masukkan ID Kelas Penayangan yang dihapus: ");
        String id = scanner.nextLine().trim();
        int idx = cariIndexById(id);
        if (idx != -1) {
            daftarKelas.remove(idx);
            //kalo datanya bener, data dihapus
            System.out.println("Data berhasil dihapus!");
        } else {//kalo salah yaa eror
            System.out.println("Error: Data tidak ditemukan!");
        }
    }

    //buat nyari data bedasarkan id
    public static void cariData() {
        System.out.print("Masukkan ID Kelas Penayangan yang dicari: ");
        String id = scanner.nextLine().trim();
        int idx = cariIndexById(id);
        if (idx != -1) {
            List<KelasBioskop> hasil = new ArrayList<>();
            hasil.add(daftarKelas.get(idx));
            tampilkanTabelDinamis(hasil);
        } else {
            System.out.println("Error: Data tidak ditemukan!");
        }
    }

    //mulai jalankan program
    public static void main(String[] args) {
        //input data dummy
        daftarKelas.add(new KelasBioskop("101", "The Premier XXI", 40, 150000));
        daftarKelas.add(new KelasBioskop("102", "IMAX", 300, 85000));
        daftarKelas.add(new KelasBioskop("103", "Deluxe", 100, 65000));

        int pilihan = 0;
        //melakukan pengulangan sampai kita memilih (6) atau keluar
        do {
            System.out.println("\n=== KELOLA KELAS TEMPAT DUDUK BIOSKOP ===");
            System.out.println("1. Tambah Kelas\n2. Tampilkan Kelas\n3. Update Kelas\n4. Hapus Kelas\n5. Cari Kelas\n6. Keluar");
            System.out.print("Pilihan: ");
            try {
                pilihan = Integer.parseInt(scanner.nextLine());
            } catch (NumberFormatException e) {//inputnya angka, bukan huruf
                System.out.println("Error Input: Masukkan angka menu!");
                continue;
            }
            //sebuah pilihan
            switch (pilihan) {
                case 1 -> tambahData();
                case 2 -> tampilkanData();
                case 3 -> updateData();
                case 4 -> hapusData();
                case 5 -> cariData();
            }//keluar

        } while (pilihan != 6);
    }
}