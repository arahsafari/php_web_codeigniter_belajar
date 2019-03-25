<?php
/**
 * Created by PhpStorm.
 * User: Kacangrebus
 * Date: 23/03/2019
 * Time: 2:41
 */

class belajar_controller extends CI_Controller
{

    function __construct(){
        parent::__construct();
        $this->load->model('belajar_model');
    }


    public function index(){
        if ($this->session->userdata('logged_in')!=1) {
            redirect(site_url('login_controller/index'));
        }

        $this->load->view('dashboard');
    }


    public function lihat_data_view(){
        $table = 'mahasiswa';
        $hasil =$this->belajar_model->get_mahasiswa($table);
        $data = array(
            'data_ke_view' => $hasil,
            'judul' => "ini judul website ini"
        );
        // $data['data_ke_view']= $hasil;
        $this->load->view('tabel',$data);
    }

    public function input_data_view(){
        $this->load->view('form');
    }

    public function input_data(){
    $nim = $this->input->post('nim');
    $nama = $this->input->post('nama');
    $kelas = $this->input->post('kelas');
    $jurusan = $this->input->post('jurusan');
    $table = "mahasiswa";

        $data_insert = array (
            'nim' => $nim,
            'nama' => $nama,
            'kelas' => $kelas,
            'jurusan' => $jurusan
        );


        $insert = $this->belajar_model->input_data_mahasiswa($table,$data_insert);

        if($insert){
            $this->session->set_flashdata('alert', 'sukses_insert');
            redirect(site_url('belajar_controller/lihat_data_view'));
        }else{
            echo "<script>alert('Gagal Menambahkan Data');</script>";
        }

    }

    public function delete_data($nim){
        $table = 'mahasiswa';
        $this->belajar_model->delete_mahasiswa($table,$nim);
        $this->session->set_flashdata('alert', 'sukses_delete');
        redirect(site_url('belajar_controller/lihat_data_view'));
    }

    public function edit_data_view($nim){
        $table = 'mahasiswa';
        $hasil =$this->belajar_model->get_mahasiswa_nim($table,$nim);
        $data['data_ke_view']= $hasil;
        $this->load->view('edit',$data);

    }

    public function edit_data($nim){
        $table = 'mahasiswa';
        $nama = $this->input->post('nama');
        $kelas = $this->input->post('kelas');
        $jurusan = $this->input->post('jurusan');

        $data_update = array (
            'nama' => $nama,
            'kelas' => $kelas,
            'jurusan' => $jurusan
        );

        $update = $this->belajar_model->update_mahasiswa($table,$nim,$data_update);
        if($update){
            $this->session->set_flashdata('alert', 'sukses_update');
            redirect(site_url('belajar_controller/lihat_data_view'));
        }else{
            echo "<script>alert('Gagal mengupdate Data');</script>";
        }

    }




}