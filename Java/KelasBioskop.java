package Java;

public class KelasBioskop {

    //atribut private agar tidak langsung diakses (enkapsulasi)
    private String id;
    private String namaKelas;
    private int jumlahKursi;
    private double harga;

    //constructor kosong
    public KelasBioskop() {}

    //constructor berparameter
    public KelasBioskop(String idInput, String nama, int kursi, double hrg) {
        this.id = idInput;
        this.namaKelas = nama;
        this.jumlahKursi = kursi;
        this.harga = hrg;
    }

    // Getter untuk membaca nilai
    public String getId() { return id; }
    public String getNamaKelas() { return namaKelas; }
    public int getJumlahKursi() { return jumlahKursi; }
    public double getHarga() { return harga; }

    // Setter untuk mengubah nilai
    public void setId(String idInput) { this.id = idInput; }
    public void setNamaKelas(String nama) { this.namaKelas = nama; }
    public void setJumlahKursi(int kursi) { this.jumlahKursi = kursi; }
    public void setHarga(double hrg) { this.harga = hrg; }
}