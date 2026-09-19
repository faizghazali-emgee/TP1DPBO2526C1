class KelasBioskop:
    #constructor
    def __init__(self, id_input: str = "", nama: str = "", kursi: int = 50, harga: float = 0.0):
        self._id = id_input #menyimpan id inputan
        self._nama_kelas = nama #menyimpan nama
        self._jumlah_kursi = kursi #menyimpan jumlah kursi yang ada
        self._harga = harga #menyimpan harga tiket

    # Getter (Mengambil Nilai)
    def get_id(self) -> str:
        return self._id

    def get_nama_kelas(self) -> str:
        return self._nama_kelas

    def get_jumlah_kursi(self) -> int:
        return self._jumlah_kursi

    def get_harga(self) -> float:
        return self._harga

    # Setter (Mengubah Sebuah Nilai)
    def set_id(self, id_input: str):
        self._id = id_input

    def set_nama_kelas(self, nama: str):
        self._nama_kelas = nama

    def set_jumlah_kursi(self, kursi: int):
        self._jumlah_kursi = kursi

    def set_harga(self, harga: float):
        self._harga = harga