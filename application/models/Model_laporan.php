<?php 
class Model_laporan extends CI_model{
    public function view_barang(){
        $this->db->select('*');
        $this->db->from('barang a');
        $this->db->join('kategori b', 'a.id_kategori=b.id_kategori');
        return $this->db->get()->result_array();
    }

    public function view_jumlah_minimal(){
        $this->db->select('*');
        $this->db->from('barang a');
        $this->db->join('kategori b', 'a.id_kategori=b.id_kategori');
        $this->db->where('a.stok <= a.jml_minimal');
        return $this->db->get()->result_array();
    }

    public function view_tidak_terjual(){
        $this->db->select('*');
        $this->db->from('barang a');
        $this->db->join('kategori b', 'a.id_kategori=b.id_kategori');
        return $this->db->get()->result_array();
    }

    public function view_penyesuaian(){
        return $this->db->query("SELECT c.tanggal_penyesuaian, d.nama_sebab_alasan, b.kode_barang, b.nama_barang, b.kode_satuan, a.tambah, a.kurang, c.keterangan 
                                    FROM `penyesuaian_detail` a 
                                        JOIN barang b ON a.id_barang=b.id_barang 
                                            JOIN penyesuaian c ON a.id_penyesuaian=c.id_penyesuaian
                                                JOIN sebab_alasan d ON c.id_sebab_alasan=d.id_sebab_alasan");
    }

    public function view_promosi_barang(){
        return $this->db->query("SELECT a.*, b.ecer, b.grosir1, b.grosir2, b.grosir3, d.nama_kategori, e.nama_subkategori, f.nama_barang  FROM `promosi` a 
                                    JOIN promosi_detail b ON a.id_promosi=b.id_promosi 
                                        JOIN kategori_pelanggan c ON b.id_kategori_pelanggan=c.id_kategori_pelanggan 
                                        LEFT JOIN kategori d ON a.id_kategori=d.id_kategori 
                                        LEFT JOIN subkategori e ON a.id_subkategori=e.id_subkategori 
                                        LEFT JOIN barang f ON a.beli_barang=f.id_barang
                                        where c.permanen='y'");
    }

    public function view_penjualan($status){
        return $this->db->query("SELECT a.id_transaksi, a.waktu_proses, d.nama_karyawan, b.nama_pelanggan, c.nama_type_bayar, a.jumlah_bayar, a.keterangan, a.kode_transaksi 
                                    FROM `transaksi` a 
                                        LEFT JOIN pelanggan b ON a.id_pelanggan=b.id_pelanggan 
                                            LEFT JOIN type_bayar c ON a.id_type_bayar=c.id_type_bayar 
                                                JOIN karyawan d ON a.id_karyawan=d.id_karyawan where a.status='$status'");
    }

    public function view_penjualan_perbarang($status){
        return $this->db->query("SELECT a.kode_transaksi, a.waktu_proses, x.kode_barang, x.nama_barang, z.jumlah_jual, z.kode_satuan, z.harga_jual, z.diskon_jual, a.ppn/100*(z.jumlah_jual*z.harga_jual) as ppn, ((z.jumlah_jual*z.harga_jual-z.diskon_jual)-a.ppn/100*(z.jumlah_jual*z.harga_jual)) as total 
                                    FROM transaksi_detail z 
                                        JOIN `transaksi` a ON z.id_transaksi=a.id_transaksi 
                                            JOIN barang x ON z.id_barang=x.id_barang 
                                                LEFT JOIN pelanggan b ON a.id_pelanggan=b.id_pelanggan 
                                                    LEFT JOIN type_bayar c ON a.id_type_bayar=c.id_type_bayar 
                                                        JOIN karyawan d ON a.id_karyawan=d.id_karyawan where a.status='$status'");
    }

    public function view_penjualan_barang_terlaris(){
        return $this->db->query("SELECT b.kode_barang, b.nama_barang, c.nama_kategori, sum(jumlah_jual) as jumlah, a.kode_satuan 
                                    FROM `transaksi_detail` a 
                                        JOIN barang b ON a.id_barang=b.id_barang 
                                            JOIN kategori c ON b.id_kategori=c.id_kategori 
                                                GROUP BY a.id_barang ORDER BY sum(jumlah_jual) DESC");
    }

    public function view_pelanggan_tersering(){
        return $this->db->query("select a.nama_pelanggan, a.alamat_pelanggan_1, a.kota, b.trx, c.total from
                                    (select x.*, y.name as kota from pelanggan x JOIN city y ON x.city_id=y.city_id) as a 
                                    LEFT JOIN
                                    (select id_pelanggan, COUNT(*) trx from transaksi GROUP BY id_pelanggan HAVING COUNT(id_pelanggan)) as b on a.id_pelanggan=b.id_pelanggan
                                    LEFT JOIN
                                    (SELECT a.*, b.id_pelanggan, sum(a.jumlah_jual*a.jumlah_satuan*a.harga_jual-a.diskon_jual-(b.ppn/100*(a.jumlah_jual*a.jumlah_satuan*a.harga_jual))) as total FROM `transaksi_detail` a JOIN transaksi b ON a.id_transaksi=b.id_transaksi GROUP BY b.id_pelanggan) as c on a.id_pelanggan=c.id_pelanggan where b.trx >=1 ORDER BY b.trx DESC");
    }

}