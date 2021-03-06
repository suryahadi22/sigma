<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content light-blue lighten-1 white-text">
                <span class="card-title"><?php echo $judul; ?></span>
            </div>
            <div class="card-content">
                <form class="row" id="edit-user-form" method="post" action="">
                    <?php if(validation_errors()): ?>
                        <div class="col s12">
                            <div class="card-panel red">
                                <span class="white-text"><?php echo validation_errors('<p>', '</p>'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if($message = $this->session->flashdata('message')): ?>
                        <div class="col s12">
                            <div class="card-panel <?php echo ($message['status']) ? 'green' : 'red'; ?>">
                                <span class="white-text"><?php echo $message['message']; ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="input-field col s12 m6">
                        <input id="nama" name="nama" type="text" value="<?php echo $event->nama; ?>">
                        <label for="nama" class="">Nama Event</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="contact" name="contact" type="text" value="<?php echo $event->contact; ?>">
                        <label for="contact" class="">Contact Person</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="tanggal_mulai" class="datepicker" name="tanggal_mulai" type="text" value="<?php echo $event->tanggal_mulai; ?>">
                        <label for="tanggal_mulai" class="">Tanggal Mulai</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="tanggal_berakhir" class="datepicker" name="tanggal_berakhir" type="text" value="<?php echo $event->tanggal_berakhir; ?>">
                        <label for="tanggal_berakhir" class="">Tanggal Berakhir</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input id="keterangan" name="keterangan" type="text" value="<?php echo $event->keterangan; ?>">
                        <label for="keterangan" class="">Keterangan</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <button type="submit" name="submit" value="<?php echo $event->id; ?>" class="btn amber waves-effect waves-green">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
/**
 * End of file eventEdit.php
 * By Suryahadi Eko Hanggoro
 */
?>