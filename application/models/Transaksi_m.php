<?php

class Transaksi_m extends CI_Model
{

    public function get_transaksi($id = '')
    {
        if ($id == '') {
            // untuk mengambil tabel outlet, member, dan user berdasarkan nama dan menggati nama tersebut menggunakan nama alias
            $this->db->select('*, tb_outlet.nama as nama_outlet, tb_member.nama as nama_member, tb_user.nama as nama_user');
            $this->db->join('tb_outlet', 'id_outlet', 'left');
            $this->db->join('tb_user', 'id_user', 'left');
            $this->db->join('tb_member', 'id_member', 'left');
            // untuk mengambil data transaksi dari tabel transaksi
            return $this->db->get('tb_transaksi')->result_array();
        } else {
            // untuk mengambil data transaksi dari tabel transaksi berdasarkan id transaksi
            return $this->db->get_where('tb_transaksi', ['id_transaksi' => $id])->row_array();
        }
    }

    // untuk menambah data transaksi di tabel transaksi
    public function insert($post)
    {

        $id_outlet = $this->session->userdata('id_outlet');

        $this->db->insert('tb_transaksi', [
            // 'id_transaksi' => id('tb_transaksi', 'id_transaksi'),
            'id_transaksi' => $post['id_transaksi'],
            'id_outlet' => $id_outlet,
            'kode_invoice' => $post['kode_invoice'],
            'id_member' => $post['id_member'],
            'id_user' => $this->session->userdata('id_user'),
            'tgl' => $post['tgl'],
            'batas_waktu' => $post['batas_waktu'],
            'tgl_bayar' => $post['tgl_bayar'],
            'biaya_tambahan' => $post['biaya_tambahan'],
            'pajak' => $post['pajak'],
            'diskon' => $post['diskon'],
            'status' => $post['status'],
            'dibayar' => $post['dibayar'],
            'total_bayar' => $post['total_bayar'],
            'cash' => $post['cash'],
        ]);

        // untuk melakukan perulangan pada tabel transaksi berdasarkan id paket
        for ($i = 0; $i < count($post['id_paket']); $i++) {
            $this->db->insert('tb_detail_transaksi', [
                'id_detail_transaksi' => $post['id_detail_transaksi'],
                'id_transaksi' => id('tb_transaksi', 'id_transaksi'),
                'id_paket' => $post['id_paket'][$i],
                'qty' => $post['qty'][$i],
                'keterangan' => $post['keterangan'][$i],
                'keterangan' => $post['keterangan'][$i],
                'total_harga' => $post['total_harga'][$i],
            ]);
        }
    }

    // untuk mengupdate data tabel berdasarkan id 
    public function update($post)
    {
        $id_outlet = $this->session->userdata('id_outlet');

        $this->db->where('kode_invoice', $post['kode_invoice']);
        $this->db->update('tb_transaksi', [
            // 'id_transaksi' => id('tb_transaksi', 'id_transaksi'),
            'id_outlet' => $id_outlet,
            'id_member' => $post['id_member'],
            'id_user' => $this->session->userdata('id_user'),
            'tgl' => $post['tgl'],
            'batas_waktu' => $post['batas_waktu'],
            'tgl_bayar' => $post['tgl_bayar'],
            'status' => $post['status'],
            'dibayar' => $post['dibayar'],
        ]);
    }
}
