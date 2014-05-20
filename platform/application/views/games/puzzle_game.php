<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Image puzzle</title>

<style type="text/css">
a:hover {
	text-decoration: underline;
}

#puzzle_container {
	line-height: 500px;
	text-align: center;
	vertical-align: center;
	border: 10px outset #CCCCCC;
	position: absolute;
	color: #FFFFFF;
	background-color: #707070;
	width /* */: /**/ 500px; /* Other browsers */
	width: /**/ 500px;
	height /* */: /**/ 500px; /* Other browsers */
	height: /**/ 500px;
	display: block;
	width: 319px;
	height: 320px;
}

#puzzle_container .square {
	overflow: hidden;
	border-left: 1px solid #FFF;
	border-top: 1px solid #FFF;
	position: absolute;
}

.activeImageIndicator {
	border: 1px solid #FF0000;
	position: absolute;
	z-index: 10000;
}

.revealedImage {
	position: absolute;
	left: 0px;
	opacity: 0;
	filter: alpha(opacity =                         50);
	top: -103px;
	z-index: 50000;
}
</style>


<script type="text/javascript">
	/*
	(C) www.dhtmlgoodies.com, September 2005
	
	You are free to use this script as long as the copyright message is kept intact
	
	
	Alf Magne Kalleland
	
	*/
	cur_game_type = "puzzle";
		
	var puzzleImages = ['<?=base_url()?>/h7-assets/images/games/<?=$data->image_name?>'];	// Array of images to choose from
	var rows = <?=$data->image_length?>;
	var cols = <?=$data->image_width?>;
		
	var imageArray = new Array();
	var imageInUse = false;
	var puzzleContainer;
	var activeImageIndicator = false;
	var activeSquare = false; 	// Reference to active puzzle square
	var squareArray = new Array(); // Array with references to all the squares

	
	var emptySquare_x;
	var emptySquare_y;
	
	var colWidth;
	var rowHeight;
	
	var gameInProgress = false;
	
	var revealedImage = false;

	var counter = 0;
	var myInterval;
	
	var timer = 0;
	var score = 200;
	var time_interval;
	var score_interval;
	var puzzle_game_started = true;

	function count_timer(){
		if (puzzle_game_started)
			return;
	  timer++;
	}
	function calc_score(){
		if (puzzle_game_started)
			return;
	  if (timer % 3 == 0 && score > 5) {
		  if (score > 100)
		  	score -= 5;
		  score -= 5;
	  }
	  document.getElementById('timer').innerHTML = score;
	}
	// 1,000 means 1 second.
	// time_interval = setInterval('count_timer()', 1000);
	// score_interval = setInterval('calc_score()', 1000);
	
	for(var no=0;no<puzzleImages.length;no++){
		imageArray[no] = new Image();
		imageArray[no].src = puzzleImages[no];	
	}
	
	function initPuzzle()
	{
		gameInProgress = false;
		var tmpInUse = imageInUse;
		imageInUse = imageArray[Math.floor(Math.random() * puzzleImages.length)];
		if(puzzleImages.length<=1) {
			puzzle_game_started = false;
			clearInterval(myInterval);
			clearInterval(time_interval);
			clearInterval(score_interval);
			time_interval = setInterval('count_timer()', 1000);
			score_interval = setInterval('calc_score()', 1000);
			myInterval = setInterval(function () {
			  ++counter;
			}, 1000);
			 document.getElementById('timer').innerHTML = score;
			var ob3 = document.getElementById('score-count');
			ob3.style.display = 'block';
			puzzleContainer = document.getElementById('puzzle_container');
			document.getElementById('puzzle_container').style.display = "block";
			document.getElementById('intro').style.display = "none";
			getImageWidth();
			scramble();
		}
	}
	
	function getImageWidth()
	{
		if(imageInUse.width>0){
			startPuzzle();	
		}else{
			setTimeout('getImageWidth()',100);	
		}
	}
	
	function scramble()
	{
		gameInProgress = true;
		var currentRow = cols-1;
		var currentCol = rows-1;
		
		document.getElementById('revealedImage').style.display='none';
		
		for(var no=0;no<rows;no++){
			for(var no2=0;no2<cols;no2++){
				if(no<rows.length || no2<cols.length){
					var el = document.getElementById('square_' + no2 + '_' + no);
					if(el){
						el.style.left = (no2 * colWidth) + (no2) + 'px';
						el.style.top = (no * rowHeight) + (no) + 'px';	
					}else{
						initPuzzle();
						return;
					}
				}			
			}
		}		
		
		
		var lastPos=false;
		var countMoves = 0;
		while(countMoves<(50*cols*rows)){
			var dir = Math.floor(Math.random()*4);
			var readyToMove = false;
			if(dir==0 && currentRow>0 && lastPos!=1){	// Moving peice down
				currentRow = currentRow-1;	
				readyToMove = true;
			}				
			if(dir==1 && currentRow<(rows-1) && lastPos!=0){	// Moving peice up
				currentRow = currentRow+1;
				readyToMove = true;
			}	
			if(dir==2 && currentCol>0 && lastPos!=3){ 	// Moving peice right
				currentCol = currentCol -1;
				readyToMove = true;
			}	
			if(dir==3 && currentCol<(cols-1) && lastPos!=2){ 	// Moving peice right
				currentCol = currentCol + 1;
				readyToMove = true;
			}
			if(readyToMove){
				activeSquare = document.getElementById('square_' + currentCol + '_' + currentRow);
				moveImage(false,true);	
				lastPos = dir;
				countMoves++;
			}
		}
		
		return;
	}

	
	
	function gameFinished()
	{
		var string = "";

		var squareWidth = colWidth + 1;
		var squareHeight = rowHeight + 1;		
		var squareCounter = 0;
		var errorsFound = false;
		var correctSquares = 0;
		for(var prop in squareArray){
			var currentCol = squareCounter % cols; 
			var currentRow = Math.floor(squareCounter/cols);
			var correctLeft = currentCol * squareWidth;
			var correctTop = currentRow * squareHeight;
			if(squareArray[prop].style.left.replace('px','') != correctLeft || squareArray[prop].style.top.replace('px','') != correctTop){
				//return;			
			}else{
				correctSquares++;
			}
				
			squareCounter++;	
		}	
		
		if(correctSquares == ((cols * rows) -1)){
			// Update Score
			game_score = score;
			// to stop the counter
			clearInterval(myInterval);
			clearInterval(time_interval);
			clearInterval(score_interval);
		  	document.getElementById('score-count').style.display = 'none';
			var obj = document.getElementById('puzzle_container');
			obj.style.display = 'none';
			var obj = document.getElementById('puzzle_final_score');
			obj.style.display = 'block';
			document.getElementById('total-score').innerHTML = score + " Points";
			game_page = "<?=base_url()?>index.php?/game_center/update_score";
			$.post(game_page, { game_score : game_score })
			.done(function( data ) {
		    	$("#score-<?=$cat_id?>").html(data);
			});
			gameInProgress = false;
			revealImage();
			timer = 0;
			score = 200;
			puzzle_game_started = true;
		}else{
			// document.getElementById('messageDiv').innerHTML = 'Currently, you have ' + correctSquares + ' out of ' + ((cols * rows) -1) + ' pieces placed correctly';
		}
		
	}
	
	var currentOpacity = 0;
	function revealImage()
	{
		if(currentOpacity==100)currentOpacity=0;
		var obj = document.getElementById('revealedImage');
		obj.style.display = 'block';
		currentOpacity = currentOpacity +2;
		if(document.all){
			obj.style.filter = 'alpha(opacity='+currentOpacity+')';
		}else{
			obj.style.opacity = currentOpacity/100;
		}
		
		if(currentOpacity<100)setTimeout('revealImage()',10);
		
	}
	function displayActiveImage()
	{
		if(!gameInProgress)return;
		if(!activeImageIndicator){
			activeImageIndicator = document.createElement('DIV');
			activeImageIndicator.className = 'activeImageIndicator';
			puzzleContainer.appendChild(activeImageIndicator);
			activeImageIndicator.onclick = moveImage;
			
		}
		activeImageIndicator.style.display='block';
		activeImageIndicator.style.left = this.offsetLeft +  'px';
		activeImageIndicator.style.top = this.offsetTop + 'px';
		activeImageIndicator.style.width = this.style.width;
		activeImageIndicator.style.height = this.style.height;
		activeImageIndicator.innerHTML = '<span></span>';
		activeSquare = this;
	}
	
	function moveImage(e,fromShuffleFunction)
	{
		if(!activeSquare)return;
		if(!gameInProgress && !fromShuffleFunction){
			alert('You have to shuffle the cards first');
			return;
		}
		var currentLeft = activeSquare.style.left.replace('px','') /1;
		var currentTop = activeSquare.style.top.replace('px','') /1;
		
		var diffLeft = Math.round((currentLeft - emptySquare_x) / colWidth);
		var diffTop = Math.round((currentTop - emptySquare_y) / rowHeight);	
		
		if(((diffLeft==-1 || diffLeft==1) && diffTop==0) || ((diffTop==-1 || diffTop==1) && diffLeft==0)){	// Moving right
			activeSquare.style.left = emptySquare_x + 'px';
			activeSquare.style.top = emptySquare_y + 'px';
			emptySquare_x = currentLeft;
			emptySquare_y = currentTop;	
			activeSquare = false;	
			if(activeImageIndicator)activeImageIndicator.style.display = 'none';
			if(!fromShuffleFunction)gameFinished();	
		}
	}
	
	function startPuzzle()
	{
		puzzleContainer.innerHTML = '';


		var subDivs = puzzleContainer.getElementsByTagName('DIV');
		for(var no=0;no<subDivs.length;no++){
			subDivs[no].parentNode.removeChild(subDivs[no]);
		}
		activeImageIndicator = false;
		squareArray.length = 0; 

		
		if(document.getElementById('revealedImage')){
			var obj = document.getElementById('revealedImage');
			obj.parentNode.removeChild(obj);
		}
		var revealedImage = document.createElement('DIV');
		revealedImage.style.display='none';
		revealedImage.id='revealedImage';;
		revealedImage.className='revealedImage';;
		var img = document.createElement('IMG');
		img.src = imageInUse.src;
		revealedImage.appendChild(img);
		puzzleContainer.appendChild(revealedImage);
			
		colWidth = Math.round(imageInUse.width / cols)-1;
		rowHeight = Math.round(imageInUse.height / rows)-1;

		puzzleContainer.style.width = colWidth * cols + (cols * 1) + 20 + 'px';
		puzzleContainer.style.height = rowHeight * rows + (rows * 1) + 20 + 'px';
		
		if(navigator.appVersion.indexOf('5.')>=0 && navigator.userAgent.indexOf('MSIE')>=0){
			puzzleContainer.style.width = colWidth * cols + (cols * 1) + 20 + 'px';
			puzzleContainer.style.height = rowHeight * rows + (rows * 1) + 20 + 'px';			
			
		}
				
		if(!revealedImage){
			revealedImage = document.createElement('DIV');
			revealedImage.style.display='none';	
			revealedImage.innerHTML = '';
			
		}
		for(var no=0;no<rows;no++){
			for(var no2=0;no2<cols;no2++){
				if(no2==cols-1 && no==rows-1){
					emptySquare_x = (no2 * colWidth) + (no2);	
					emptySquare_y = (no * rowHeight) + (no);	
					break;
				}
				var newDiv = document.createElement('DIV');
				newDiv.id = 'square_' + no2 + '_' + no;
				newDiv.onmouseover = displayActiveImage;
				newDiv.onclick = moveImage;
				newDiv.className = 'square';
				newDiv.style.width = colWidth + 'px';
				newDiv.style.height = rowHeight + 'px';	
				newDiv.style.left = (no2 * colWidth) + (no2) + 'px';
				newDiv.style.top = (no * rowHeight) + (no) + 'px';
				newDiv.setAttribute('initPosition',(no2 * colWidth) + (no2) + '_' + (no * rowHeight) + (no));
				var img = new Image();
				img.src = imageInUse.src;
				img.style.position = 'absolute';
				img.style.left = 0 - (no2 * colWidth) + 'px';
				img.style.top = 0 - (no * rowHeight) + 'px';
				newDiv.appendChild(img);				
				puzzleContainer.appendChild(newDiv);
				squareArray.push(newDiv);
			}
		}	
		
		
	}
	window.onload = initPuzzle;
	</script>
</head>
<div id = "puzzle_game" class="popup-container">
	<div id="game-content">
		<div id="puzzle_container" style="display: none;"></div>

		<div id="puzzle_final_score" style="display: none;">
			<h3 align="center" id="final-score-title">Final Score</h3>
			<h1 align="center" id="total-score"></h1>
			<div class="play-button" style="position: relative; top: 100px;">
				<font id="button-text"> <a href="javascript:void(0);"
					id="close_game" class="simplemodal-close"
					style="text-decoration: none;"><font color="white">Done</font> </a>
				</font>
			</div>
		</div>
		<div id="intro">

			<table id="How-to-play">
				<tr>
					<td><img
						src="<?=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
						style="margin-right: 10px;">How to Play?</td>
				</tr>
			</table>
			<p id="game-intro">
				Solve the puzzle really FAST to score more! <br /> Every 10 seconds
				you lose 5 possible score points. <br /> If you solve the game in
				more than 2 minutes, you will only score 50 points. <br /> <br />
				You can play the game again to get a better score ;)...
			</p>
			<a href="javascript:void(0);" style="text-decoration: none;"
				onclick="initPuzzle();">
				<div class="play-button">
					<font id="button-text">Play!</font>
				</div>
			</a>
		</div>
	</div>
	<div id="right-bar">
            <a href="javascript:void(0);" onclick="toggleFullScreen('#display_game');"><img id="fullscreen-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
            <a href="javascript:void(0);" onclick="closeModal('#display_game');"><img id="close-popup-button" src="<?=base_url()?>h7-assets/resources/img/main-icons/score_icon2.png"></a>
		<table style="margin-top: 5px;">
			<tr>
				<td>
					<h4 style="margin-top: -31px;">
						<?=$card_name?>
					</h4>
				</td>
				<td>
					<div class="card-holder-popup" style="margin-left: 25px;">
						<img align="center"
							src="<?=base_url()?>h7-assets/images/categories/<?=$cat_name?>/cards/<?=$card_id?>/ui/list_view.png"
							class="card-pic-popup" alt="card">
					</div>
				</td>
			</tr>
			<tr style="height: 40px;">
				<td colspan="2" style="border-bottom: 4px solid #68c220;"></td>
			</tr>
		</table>
		<h5>
			<img
				src="<?=base_url()?>h7-assets/resources/img/main-icons/game_sort.png"
				style="margin-right: 5px;">Puzzle
		</h5>
		<div id="score-count" style="display: none;">
			<h5 style="margin-top: 20px;">
				<img
					src="<?=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
					style="margin-right: 5px;">Score
			</h5>
			<h1 id="timer" align="center"
				style="color: #68c220; margin-top: -6px;"></h1>
		</div>
	</div>
</div>
</html>
