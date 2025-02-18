<?php
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Adminpanel extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mcrud');
        $this->cek_login();
    }
    public function cek_login()
    {
        if (empty($this->session->userdata('username'))) {
            redirect('Login');
        }
    }
    public function index()
    {
        // cek login
        $data['content'] = "admin/adminpanel";
        $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();
        $data['master'] = $this->Mcrud->get_all_data('tbl_master_barang')->result();
        $data['barang'] = $this->Mcrud->get_all_data('tbl_barang')->result();
        // $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();

        //load view
        $this->load->view('admin/template', $data);
    }

    // public function detail_barang()
    // {
    //     // load data
    //     // $datawhere = array('id_barang' => $id);
    //     // $data['barang'] = $this->Mcrud->get_by_id('tbl_barang', $datawhere)->row_object();
    //     $qr_code = $this->input->post('qr_code');
    //     $data['qr_code'] = $qr_code;

    //     // load view
    //     $data['content'] = "admin/detail_barang";
    //     $$this->load->view('admin/template', $data);

    // }

    public function user()
    {
        // cek login
        $data['content'] = "admin/user";
        $data['user'] = $this->Mcrud->get_all_data('tbl_user')->result();
        // $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();

        //load view
        $this->load->view('admin/template', $data);
    }
    public function kategori()
    {
        // cek login
        $data['content'] = "admin/kategori";
        $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();
        // $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();

        //load view
        $this->load->view('admin/template', $data);
    }
    public function barang()
    {
        // cek login
        $data['content'] = "admin/barang";
        $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();
        $data['master'] = $this->Mcrud->get_all_data('tbl_master_barang')->result();
        $data['barang'] = $this->Mcrud->get_all_data('tbl_barang')->result();
        // $data['kategori'] = $this->Mcrud->get_all_data('tbl_kategori')->result();
        //load view
        $this->load->view('admin/template', $data);
    }
    public function add_user()
    {
        // get data
        $nm_lengkap = $_POST['nm_lengkap'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $level = $_POST['level'];
        // save data
        $datainsert = array(
            'nm_lengkap' => $nm_lengkap,
            'username' => $username,
            'password' => $password,
            'level' => $level
        );

        // Update data ke tabel 'tbl_seleksi'
        $this->Mcrud->insert('tbl_user', $datainsert);
        $this->session->set_flashdata('flash', 'Disimpan');
        redirect('Adminpanel/user');

    }
    public function hapus_user($id)
    {
        $datawhere = array('id_user' => $id);
        $data['user'] = $this->Mcrud->hapus_data($datawhere, 'tbl_user');
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Adminpanel/user');
    }

    public function add_kategori()
    {
        // get data
        $nm_kategori = $_POST['nm_kategori'];
        // save data
        $datainsert = array(
            'nm_kategori' => $nm_kategori
        );

        // Update data ke tabel 'tbl_seleksi'
        $this->Mcrud->insert('tbl_kategori', $datainsert);
        $this->session->set_flashdata('flash', 'Disimpan');
        redirect('Adminpanel/kategori');

    }
    public function edit_kategori()
    {
        // get data
        $id_kategori = $_POST['id_kategori'];
        $nm_kategori = $_POST['nm_kategori'];
        // save data
        $dataupdate = array(
            'nm_kategori' => $nm_kategori
        );

        // Update data ke tabel 'tbl_seleksi'
        $this->Mcrud->update('tbl_kategori', $dataupdate, 'id_kategori', $id_kategori);
        $this->session->set_flashdata('flash', 'Diedit');
        redirect('Adminpanel/kategori');
    }
    public function hapus_kategori($id)
    {
        $datawhere = array('id_kategori' => $id);
        $data['kategori'] = $this->Mcrud->hapus_data($datawhere, 'tbl_kategori');
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Adminpanel/kategori');
    }
    public function add_master()
    {
        // get data
        $id_kategori = $_POST['id_kategori'];
        $jenis_barang = $_POST['jenis_barang'];
        $th_pembelian = $_POST['th_pembelian'];
        // save data
        $datainsert = array(
            'id_kategori' => $id_kategori,
            'jenis_barang' => $jenis_barang,
            'th_pembelian' => $th_pembelian
        );

        // Update data ke tabel 'tbl_seleksi'
        $this->Mcrud->insert('tbl_master_barang', $datainsert);
        $this->session->set_flashdata('flash', 'Disimpan');
        redirect('Adminpanel/barang');

    }
    public function edit_master()
    {
        // get data
        $id_master = $_POST['id_master'];
        $id_kategori = $_POST['id_kategori'];
        $jenis_barang = $_POST['jenis_barang'];
        $th_pembelian = $_POST['th_pembelian'];
        // save data
        $dataupdate = array(
            'id_kategori' => $id_kategori,
            'jenis_barang' => $jenis_barang,
            'th_pembelian' => $th_pembelian
        );

        // Update data ke tabel 'tbl_seleksi'
        $this->Mcrud->update('tbl_master_barang', $dataupdate, 'id_master', $id_master);
        $this->session->set_flashdata('flash', 'Diedit');
        redirect('Adminpanel/barang');
    }
    public function hapus_master($id)
    {
        $datawhere = array('id_master' => $id);
        $data['master'] = $this->Mcrud->hapus_data($datawhere, 'tbl_master_barang');
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Adminpanel/barang');
    }
    // public function add_barang()
    // {
    //     // get data
    //     $id_barang = 
    //     $id_master = $_POST['id_master'];
    //     $nm_barang = $_POST['nm_barang'];
    //     $keterangan = $_POST['keterangan'];
    //     $status = $_POST['status'];
    //     // save data
    //     $datainsert = array(
    //         'id_master' => $id_master,
    //         'nm_barang' => $nm_barang,
    //         'keterangan' => $keterangan,
    //         'status' => $status
    //     );

    //     // Update data ke tabel 'tbl_seleksi'
    //     $this->Mcrud->insert('tbl_barang', $datainsert);
    //     $this->session->set_flashdata('flash', 'Disimpan');
    //     redirect('Adminpanel/barang');

    // Atau Ini sudah generate id
    //  $id_master = $this->input->post('id_master');
    //     $nm_barang = $this->input->post('nm_barang');
    //     $keterangan = $this->input->post('keterangan');
    //     $status = $this->input->post('status');

    //     // Get id_kategori from tbl_master based on id_master
    //     $id_kategori = $this->Mcrud->get_id_kategori_by_id_master_from_tbl_master_barang($id_master);

    //     // Ambil nomor urut terakhir dari 'id_bukti'
    //     $this->db->select_max('id_barang');
    //     $query = $this->db->get('tbl_barang');
    //     $row = $query->row();
    //     $last_id_barang = $row->id_barang;
    //     $last_urut = intval(substr($last_id_barang, -5));

    //     // Buat nomor urut baru dengan menambahkan 1 pada nomor urut terakhir
    //     $new_urut = $last_urut + 1;
    //     $new_urut_str = str_pad($new_urut, 5, '0', STR_PAD_LEFT);

    //     // Gabungkan nilai 'KategoriID', 'MasterID', '00', dan nomor urut baru untuk menghasilkan 'id_barang' yang baru
    //     $new_id_barang = $id_kategori . $id_master . '0' . $new_urut_str;

    //     $datainsert = array(
    //         'id_barang' => $new_id_barang,
    //         'id_master' => $id_master,
    //         'nm_barang' => $nm_barang,
    //         'keterangan' => $keterangan,
    //         'status' => $status
    //     );
    //     $this->Mcrud->insert('tbl_barang', $datainsert);
    //     $this->session->set_flashdata('flash', 'Disimpan');

    // }

    public function generateQRCode($id_barang)
    {
        // Dapatkan data barang berdasarkan id_barang
        $barang = $this->Mcrud->get_barang_by_id($id_barang);

        // Jika barang ditemukan, buat QR code
        if ($barang) {
            // Ambil id_barang untuk dimasukkan ke dalam QR code
            $data = $barang['id_barang'];

            // Inisialisasi objek QR code
            $qrCode = new QrCode($data);

            // Set ukuran QR code (opsional)
            $qrCode->setSize(300);

            // Simpan QR code sebagai string
            $qrCodeString = $qrCode->writeString();

            // Simpan QR code sebagai file dengan nama id_barang.png di folder qr_code
            $qrCodePath = FCPATH . 'qr_code/' . $id_barang . '.png';
            file_put_contents($qrCodePath, $qrCodeString);

            // Simpan nama file QR code ke dalam database
            $this->Mcrud->update_qr_code_path($id_barang, $qrCodePath);

            // Tampilkan halaman dengan QR code
            $data['qr_code'] = $qrCodePath;
            $data['content'] = "admin/qr_code_view";
            $this->load->view('admin/template', $data);
        } else {
            // Jika barang tidak ditemukan, tampilkan pesan kesalahan
            echo "Barang tidak ditemukan.";
        }
    }

    public function add_barang()
    {
        $id_master = $this->input->post('id_master');
        $nm_barang = $this->input->post('nm_barang');
        $keterangan = $this->input->post('keterangan');
        $status = $this->input->post('status');

        // Get id_kategori from tbl_master based on id_master
        $id_kategori = $this->Mcrud->get_id_kategori_by_id_master_from_tbl_master_barang($id_master);

        // Ambil nomor urut terakhir dari 'id_bukti'
        $this->db->select_max('id_barang');
        $query = $this->db->get('tbl_barang');
        $row = $query->row();
        $last_id_barang = $row->id_barang;
        $last_urut = intval(substr($last_id_barang, -5));

        // Buat nomor urut baru dengan menambahkan 1 pada nomor urut terakhir
        $new_urut = $last_urut + 1;
        $new_urut_str = str_pad($new_urut, 5, '0', STR_PAD_LEFT);

        // Gabungkan nilai 'KategoriID', 'MasterID', '00', dan nomor urut baru untuk menghasilkan 'id_barang' yang baru
        $new_id_barang = $id_kategori . $id_master . '0' . $new_urut_str;

        $datainsert = array(
            'id_barang' => $new_id_barang,
            'id_master' => $id_master,
            'nm_barang' => $nm_barang,
            'keterangan' => $keterangan,
            'status' => $status
        );
        // Insert data barang ke tabel 'tbl_barang'
        $this->Mcrud->insert('tbl_barang', $datainsert);
        // Generate QR code for the newly added barang
        // $this->generateQRCode($new_id_barang);
        $this->session->set_flashdata('flash', 'Disimpan');
        redirect('Adminpanel/barang');
    }
    public function hapus_barang($id)
    {
        $datawhere = array('id_barang' => $id);
        $data['barang'] = $this->Mcrud->hapus_data($datawhere, 'tbl_barang');
        $this->session->set_flashdata('flash', 'Dihapus');
        redirect('Adminpanel/barang');
    }
    public function detail_barang()
    {
        // Menerima data QR code dari AJAX
        $qr_code = $this->input->post('qr_code');

        // Lakukan pemrosesan data sesuai kebutuhan
        // Misalnya, load data barang berdasarkan QR code
        $datawhere = array('id_barang' => $qr_code);
        $data['barang'] = $this->Mcrud->get_by_id('tbl_barang', $datawhere)->row_object();

        // Load view
        $data['content'] = "admin/detail_barang";
        $this->load->view('admin/template', $data);
    }

}