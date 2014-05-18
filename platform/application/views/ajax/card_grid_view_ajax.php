<?php
$this->lang->load('market',$_SESSION['language']);
?>
<!-- Cards -->

<div id="list_view">
	<table id="cards" style="text-align: left;">
		<?php
		$i = 0;
		foreach ($cards as $card) {
			if ($i % 3 == 0) {
    		if ($i != 0) {?>
		</tr>
		<?php }?>
		<tr align="center" style="height: 300px;">
			<?php }
			$i ++;
                        $rest = 0;
			?>
			<td><font class="card-name"><?= $card->name ?> </font>
				<hr /> <?php $h = 50; $w = 40;?>
				<div class="card-holder">
					<img
						src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card->id?>/ui/list_view.png"
						class="card-pic" alt="card">
					<table class="card-elements">
						<tr>
                                                    <td><img
                                                            <?php if($images[$card->id-1]){ ?>
                                                            src="<?=base_url()?>/h7-assets/resources/img/main-icons/white_images_icon.png"
                                                            <?php } else { ?>
                                                            src="<?=base_url()?>/h7-assets/resources/img/main-icons/empty_button.png"
                                                            <?php } ?>
                                                            alt="" height="<?=$h?>" width="<?=$w?>"></td>
                                                    
                                                    <td><img
                                                            <?php if($audios[$card->id-1]){ ?>
                                                            src="<?=base_url()?>/h7-assets/resources/img/main-icons/white_music_icon.png"
                                                            <?php } else { ?>
                                                            src="<?=base_url()?>/h7-assets/resources/img/main-icons/empty_button.png"
                                                            <?php } ?>
                                                            alt="" height="<?=$h?>" width="<?=$w?>"></td>
						</tr>
						<tr>
							<td><img
                                                                <?php if($videos[$card->id-1]){ ?>
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/white_video_icon.png"
                                                                <?php } else { ?>
                                                                src="<?=base_url()?>/h7-assets/resources/img/main-icons/empty_button.png"
								<?php } ?>
                                                                alt="" height="<?=$h?>" width="<?=$w?>"></td>
							<td><img
                                                                <?php if($games[$card->id-1]){ ?>
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/white_games_icon.png" 
                                                                <?php } else { ?>
                                                                src="<?=base_url()?>/h7-assets/resources/img/main-icons/empty_button.png" 
								<?php } ?>
                                                                alt="" height="<?=$h?>" width="<?=$w?>"></td>
						</tr>
					</table>
					<?php if (in_array($card->id , $user_cards) ) {?>
                                        <a href="javascript:void(0);" onclick="my_collection(<?=$card->id?>);return false;" class="trade-button" style="text-decoration: none;"> <img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/done_button.png"
                                                        alt="" width="40" height="41"> </a>
                                                            <?php } else {?>
						<a href="javascript:void(0);"
						onclick="buy_card_now('<?= $card->price ?>', '<?= $user_points?>' , '<?= $card->score ?>', '<?= $card->id ?>')"
						class="trade-button" style="text-decoration: none;"> <img
                                                        <?php if($card->price != 0) { ?>
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/get_button.png"
                                                        <?php }else{ ?>
                                                        src="<?=base_url()?>/h7-assets/resources/img/main-icons/trade_icon.png"
                                                        <?php } ?>
                                                        alt="" width="40" height="41">
                                                            <?php }?>
					</a> <font color="#68c220" class="grid-card-points"><?= $card->score ?>
							<?=$this->lang->line('Points');?></font>
                                                        <?php if($card->price != 0) { ?>
                                                        <br /> <font color="#68c220" class="grid-card-coins"><?= $card->price ?>
							<?=$this->lang->line('Hit_Coins');?></font>
                                                        <?php } ?>
				
				</div>
			</td>
			<?php } ?>
		
		
		<tr style="height: 30px;"></tr>
	</table>
</div>
<script>
function buy_card_now(card_price, user_points,card_score, card_id) {
	platform_page = "<?=base_url() ?>index.php?/platform/buy_card";
	$('#card-ajax').html('Processing ...'); //want to load card view after this ...
	$('#card-sta-hide').hide();
	$.post(platform_page, { card_price : card_price, user_points : user_points , card_id : card_id , cat_id : <?= $cat_id?> , card_score : card_score})
	.done(function( data ) {
		if (data > -1) {
			alert_success("Succeeded");
    		$("#user_points").html(data);
		}
		else {
    		alert_error("No Enough Points :(");
		}
		get_cards("<?=$cat_id ?>", "<?=$cat_name ?>");
	});
}
</script>