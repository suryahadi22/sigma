<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<aside>
    <ul id="sidenav" class="side-nav fixed">
        <li>
            <div class="userView">
                <div class="background">
                    <img src="<?php echo base_url('assets/dashboard/images/nav.jpg'); ?>">
                </div>
                <a href="<?php echo base_url('profile'); ?>" alt="Ubah Profil Kamu"><img class="circle" src="<?php echo base_url('assets/datapengguna/fotoprofil/').$this->session->userdata('avatar');; ?>"></a>
                <a href="<?php echo base_url('profile'); ?>" alt="Ubah Profil Kamu"><span class="white-text name"><?php echo ucwords(strtolower($this->session->userdata('nama'))); ?></span></a>
                <a href="<?php echo base_url('profile'); ?>" alt="Ubah Profil Kamu"><span class="white-text email"><?php echo strtolower($this->session->userdata('email')); ?></span></a>
            </div>
        </li>
      
        <li>
            <a class="waves-effect" href="<?php echo base_url('dashboard'); ?>"><i class="material-icons">home</i>Dashboard</a>
        </li>

        <li>
            <a class="waves-effect" href="<?php echo base_url('events'); ?>"><i class="material-icons">event</i>Events</a>
        </li>

        <li>
            <a class="waves-effect" href="<?php echo base_url('loker'); ?>"><i class="material-icons">work</i>Lowongan Kerja</a>
        </li>

        <li>
            <a class="waves-effect" href="<?php echo base_url('bantuan'); ?>"><i class="material-icons">help</i>Bantuan</a>
        </li>

        <li>
            <div class="divider">
        </li>

        <?php if($this->session->userdata('level') === 'administrator'): ?>
        <li>
            <a class="subheader">Admin</a>
        </li>

        <li>
            <a class="waves-effect" href="<?php echo base_url('users'); ?>"><i class="material-icons">people</i>Pengguna</a>
        </li>

        <li>   
            <div class="divider"></div>
        </li>
        <?php endif; ?>

        <li>
            <a class="waves-effect" href="<?php echo base_url('auth/logout'); ?>"><i class="material-icons">exit_to_app</i>Logout</a>
        </li>


    </ul>
</aside>

<?php
    /**
     * End of file sidebar.php
     * By Suryahadi Eko Hanggoro
     */
?>