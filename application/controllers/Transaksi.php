<?php

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        if ($this->session->userdata('role') == 'owner') {
            echo "Error Unauthorized";
            die;
        }
    }

    public function index()
    {
        $data['title'] = 'Data Transaksi';
        // memanggil data transaksi dari tabel transaksi menggunakan model
        $data['transaksi'] = $this->Transaksi_m->get_transaksi();
        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/index', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $valid = $this->form_validation;

        $valid->set_rules('kode_invoice', 'Kode Invoice', 'required');

        if ($valid->run()) {
            $this->Transaksi_m->insert($this->input->post());
            $this->session->set_flashdata('message', 'Data Berhasil Ditambahkan');
            redirect('transaksi');
        }

        $data['title'] = 'Tambah Transaksi';
        $data['transaksi'] = $this->Transaksi_m->get_transaksi();
        $data['paket'] = $this->Paket_m->get_paket();
        $data['member'] = $this->Member_m->get_member();

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/tambah', $data);
        $this->load->view('templates/footer');
    }

    public function ubah($id)
    {
        $valid = $this->form_validation;

        $valid->set_rules('kode_invoice', 'Kode Invoice', 'required');

        if ($valid->run()) {
            $this->Transaksi_m->update($this->input->post());
            $this->session->set_flashdata('message', 'Data Berhasil Diubah');
            redirect('transaksi');
        }

        $data['title'] = 'Ubah Data';
        $data['transaksi'] = $this->Transaksi_m->get_transaksi($id);
        $data['paket'] = $this->Paket_m->get_paket();
        $data['member'] = $this->Member_m->get_member();

        $this->load->view('templates/header', $data);
        $this->load->view('transaksi/ubah', $data);
        $this->load->view('templates/footer');
    }

    public function hapus($id)
    {
        $this->db->delete('tb_detail_transaksi', ['id_transaksi' => $id]);
        $this->db->delete('tb_transaksi', ['id_transaksi' => $id]);
        $this->session->set_flashdata('message', 'Data Berhasil Dihapus');
        redirect('transaksi');
    }
}
