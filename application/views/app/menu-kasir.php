<?php $users = $this->model_app->edit('karyawan', array('id_karyawan' => $this->session->id_users))->row_array(); ?>
<section class="sidebar">

  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img src="<?php echo base_url()."asset/images/$users[foto_karyawan]" ?>" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
      <p><?php echo $users['nama_karyawan']; ?></p>
      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
  </div>

  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header" style='color:#fff; text-transform:uppercase; border-bottom:2px solid #00c0ef'>MENU KASIR</li>
    <li><a href="<?php echo base_url(); ?>app/home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
    <li class="treeview">
      <a href="#"><i class="fa fa-archive"></i> <span>Barang</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li><a href="<?php echo base_url(); ?>app/barang"><i class="fa fa-circle-o"></i> Daftar Barang</a></li>
        <li><a href="<?php echo base_url(); ?>app/penjualan"><i class="fa fa-circle-o"></i> Transaksi Penjualan</a></li>
        <li><a href="<?php echo base_url(); ?>app/return_penjualan"><i class="fa fa-circle-o"></i> Return Penjualan</a></li>
      </ul>
    </li>
    <li><a href="<?php echo base_url(); ?>app/pelanggan"><i class="fa fa-users"></i> <span>Pelanggan</span></a></li>
    <li><a href="<?php echo base_url(); ?>app/transaksi_penjualan"><i class="glyphicon glyphicon-shopping-cart"></i> <span>Penjualan</span></a></li>
    <li><a href="<?php echo base_url(); ?>app/logout"><i class="glyphicon glyphicon-off"></i> <span>Logout</span></a></li>
  </ul>
</section>