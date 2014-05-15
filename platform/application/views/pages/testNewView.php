<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>	
<div class="container" id="My-container">
	<!-- Left Header -->
	<div id="left-header">
		<div id="logo">
			<img
				src="<?=base_url()?>/h7-assets/resources/img/main-icons/Logo.png"
				alt="Logo" style="margin-left: 11.5px;">
			<div id="profile">
				<div id="profile-white-background">
					<div id="profile-orange-background">
						<!-- <img
							src="http://graph.facebook.com/<?php //$fb_id?>/picture?width=200&height=200"
							alt="profile picture" id="profile-pic">
						<div style="position: relative; top: -23px; width: 229px; text-align: center; color: white; font-size: 18px;">
                                                    <font><?php // $name?> </font>
						</div> -->
                                                <?php /*if($user_points != 0){ ?>
						<div id="points-image">
							<img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/points_icon.png"
								alt=""> <font id="user_points"><?php// $user_points?> </font> Points
							<br /> <img
								src="<?=base_url()?>/h7-assets/resources/img/main-icons/arrow_icon.png"
								alt=""> <a id="getPointsButton" href="#"
								style="text-decoration: none;">Get More Points</a>
						</div>
                                                <?php } */ ?>
					</div>
				</div>
			</div>
		</div>
		<!-- 	Load the Buy Credit Popup ... -->
		<?php
		$this->load->view('popups/buy_credit_popup');
		?>
		<!-- 		Load Interset Categories -->
		<div id="cat_interest_my_collection"></div>
		<!-- 		Load Other Categories -->
		<div id="catss_not_interest_my_collection"></div>

	</div>
	<!-- end of left header -->
	<!-- Content -->
	<div id="content">

		<!-- pages bar -->
		<div id="pages-bar">
			<div class="row">
				<table style="margin-left: 25px; text-align: center;">
					<tr>
						<td style="width: 158px;"><a
							href="javascript:void(0);" onclick="getMarketView()"
							style="text-decoration: none;"><h4>MARKET</h4> </a></td>
						<td><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/separator.png"
							alt="separator"></td>
						<td style="width: 200px;"><a
							href="javascript:void(0);" onclick="getMyCollectionView()"
							style="text-decoration: none;"><h4>MY COLLECTION</h4> </a></td>
						<td><img
							src="<?=base_url()?>/h7-assets/resources/img/main-icons/separator.png"
							alt="separator"></td>
						<td style="width: 200px;"><a
							href="javascript:void(0);" onclick="getScoreboardView()"
							style="text-decoration: none;"><h4>SCOREBOARDS</h4> </a></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- end of pages bar -->

		<!-- 		Load Dashboard -->
		
		<!-- 		End of Dashboard -->


		<div id="card-details">

			<!-- Category cards -->
			<div id="left_panel"></div>
			<!-- Category cards End -->

			<!-- Card Details -->
			<div id="right_panel"></div>
			<!-- Card Details End -->

		</div>
	</div>
</div>
<script>
    
    function getMarketView(){
        $("#right_panel").html('Market ya 3amr :D!!');
    }
    function getMyCollectionView(){
        $("#right_panel").html('My_Collection ya 3amr bardo :D!!!');
    }
    function getScoreboardView(){
        $("#right_panel").html('Scoreboard w3eb tshok f kodoraty ba2a 3eb 3alek :D');
    }
</script>