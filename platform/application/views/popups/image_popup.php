
<div id="display_img" style="display: none;" align = "center">
	<div class="popup-container">
		<div id="game-content"> 
			<img id="img_id" src="">
		</div>
		<div id="right-bar"> 
		<a href="" onclick=""><img id="close-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
			<table style="margin-top: 5px;">
				<tr>
					<td>
						<h4 style="margin-top: -31px;"><?= $card_name?></h4>
					</td>
					<td>
						<div class="card-holder-popup" style="margin-left: 25px;">
							<img align = "center" src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/ui/list_view.png"
								class="card-pic-popup" alt="card">
						</div>
					</td>
				</tr>
				<tr style="height: 40px;">
					<td colspan="2" style="border-bottom: 4px solid #68c220;"></td>
				</tr>
			</table>
			<h5 style = "text-align: left;">
				<img
					src="<?=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
					style="margin-right: 5px;"><a href="#" onclick="getElementReadyForFullScreenMode('#display_img')" ><?=$card_name?></a>
			</h5>
		</div>
	</div>
</div>


<script>
	
function display_image(img_src) {
		<?php if($own_card!=FALSE ){?>
		// Opening animations
		document.getElementById("img_id").src = img_src; 
		wid = 950;
		hit = 458;
		$("#display_img").modal({
			minHeight:hit,
			minWidth: wid,
			onOpen: function (dialog) {
			dialog.overlay.fadeIn('slow', function () {
				dialog.data.hide();
				dialog.container.fadeIn('slow', function () {
					dialog.data.slideDown('slow');	 
				});
			});
		}});
		<?php }else  {?>
			alert_warning('Buy card ya 7abeeby l awl :P');
		<?php }?>
}
function getElementReadyForFullScreenMode(elementName){
	$(elementName).width(screen.width).height(screen.height);
	$(elementName).toggleFullScreen();
}

</script>
