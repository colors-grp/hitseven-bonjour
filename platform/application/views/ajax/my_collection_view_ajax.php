	<!-- 	Load the Image Popup ... -->
	<?php
	$this->load->view('popups/image_popup');
	?>
	
    <!-- 	Load the Audio Popup ... -->
	<?php
	$this->load->view('popups/audio_popup');
	?>
    
    <!-- 	Load the Video Popup ... -->
	<?php
	$this->load->view('popups/video_popup');
	?>
    <!-- 	Load the Game Popup ... -->
	<?php
	$this->load->view('popups/game_popup');
	?>
	

<?php if ($images != false) { ?>
<table id="card-photos">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_photo.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" />Photos
		</td>
	</tr>
        
        <?php
        for($pos=0;$pos<count($images);) { ?>
	<tr align="center">
    <?php  $counter = 0; 
    for($i=0;$i<3&&$pos<count($images);$i++,$pos++,$counter++) { ?>
		<td class="photo-padding">
			<a href="javascript:void(0)"
				onclick="display_image('<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/image/<?= $images[$pos]?>')">
					<img
					src="<?= base_url(); ?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/image/<?= $images[$pos]?>"
					border="0" class="img-circle" style="width: 40px; height: 40px;">
			</a>
		
		</td>
            <?php } ?> 
        </tr> 
        <tr align="center">
            <?php $pos = $pos - $counter; //log_message('error','mo7eb my_collection_view_ajax $pos='.$pos.'   $counter='.$counter);
                for($i=0;$i<3&&$pos<count($images);$i++,$pos++) { 
            ?>
                <td> <?=$images[$pos]?> </td>
            <?php } ?> 
        </tr> 
        <?php } ?>
</table>
<?php } if ($videos != false) { ?>
<table id="card-videos">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_video.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" />Videos
		</td>
	</tr>
	
	<tr align="center">
		<?php foreach ($videos as $video) { ?>
		<td class="photo-padding">
			<a href="javascript:void(0)" onclick ="show_video('<?=base_url();?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/video/<?= $video?>')">
				<img src="<?= base_url() ?>/h7-assets/resources/img/main-icons/video_icon.jpg" border="0" class="img-circle">
			</a> 
		</td>
		<?php }?>
	</tr>
        <tr align="center">
            <?php foreach ($videos as $video) { ?>
            <td>
                <?=$card_name?>
            </td>
            <?php }?>
        </tr>
</table>
<?php } if ($audios != false) { ?>
<table id="card-music">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_music.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" />Music
		</td>
	</tr>
	<tr align="center">
		<?php foreach ($audios as $audio) {  ?>
		<td class="photo-padding">
			<a href="javascript:void(0)" onclick ="play_audio('<?=base_url();?>h7-assets/images/categories/<?=$cat_name?>/cards/<?= $card_id?>/audio/<?= $audio?>')">
				<img src="<?= base_url(); ?>h7-assets/resources/img/main-icons/music_icon.jpg" border="0" class="img-circle" > 
			</a>
		</td>
		<?php }?>
	</tr>
	<tr align="center">
            <?php foreach ($audios as $audio) { ?>
            <td>
                <?=$card_name?>
            </td>
            <?php }?>
        </tr>
</table>
<?php } if ($games != false) { ?>

<table id="card-game">
	<tr>
		<td colspan="4" style="border-bottom: 2px solid #68c220;"><img
			src="<?=base_url()?>h7-assets/resources/img/main-icons/cards_game.png"
			style="margin-right: 7px; margin-left: 7px; margin-bottom: 7px;" />Games
		</td>
	</tr>
	
	<tr align="center">
		<?php foreach ($games->result() as $game) {  ?>
		<td class="photo-padding">
			<a href="javascript:void(0)" onclick ="open_game('<?=$card_id?>', '<?= $game->game_id?>','<?= $game->game_type?>', '<?= $card_name ?>')">
				<img src="<?= base_url(); ?>h7-assets/resources/img/main-icons/game_icon.jpg" border="0" class="img-circle" > 
			</a>
		</td>
		<?php }?>
	</tr>
        <tr align="center">
            <?php foreach ($games->result() as $game) { ?>
            <td>
                <?=$card_name?>
            </td>
            <?php }?>
        </tr>
</table>
<?php } ?>