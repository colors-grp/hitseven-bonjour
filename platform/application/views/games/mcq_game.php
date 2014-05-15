<?php $q = implode("~",$ques);
$c = array(array());
for ($i = 0; $i < count($choice) ; $i ++) {
	$c[$i] = implode("~",$choice[$i]);
}
$cc = implode("^", $c);
$a = implode("~",$ans);
?>
<div id = "mcq_game" class="popup-container">
	<div id="game-content">
		<div id="mcq-content" style="display: none;">
			<table id="Q-score-table">
				<tr>
					<?php for ($i = 0 ; $i < count($ques); $i ++) { ?>
					<td>
						<div id="question-<?=$i?>" class="empty-circle">
							<font id="question-score-<?=$i?>" class="Q-score"
								style="color: #68c220;">Q<?=($i + 1)?>
							</font>
						</div>
					</td>
					<?php }?>
				</tr>
			</table>
			<div id="final_score" style="display: none;">
				<h3 align="center" id="final-score-title">Final Score</h3>
				<h1 align="center" id="total-score"></h1>
				<div class="play-button" style="position: relative; top: 100px;">
					<font id="button-text"> <a href="javascript:void(0);"
						id="close_game" class="simplemodal-close"
						style="text-decoration: none;"><font color="white">Done</font> </a>
					</font>
				</div>
			</div>
			<div id="current_question" style="position: relative; top: -26px;">
				<table id="Q-number">
					<tr>
						<td><img
							src="<?=base_url()?>h7-assets/resources/img/main-icons/green-arrow.png"
							style="margin-right: 10px;"><font id="question_count"></font></td>
					</tr>
				</table>

				<div class="Ques">
					<font id="question_content" align="center"></font> <br /> <br /> <input
						id="c1" type="radio" name="choice"> <label for="c1"><font id="a1">A1</font>
					</label> <br /> <input id="c2" type="radio" name="choice"> <label
						for="c2"><font id="a2">A2</font> </label> <br /> <input id="c3"
						type="radio" name="choice"> <label for="c3"><font id="a3">A3</font>
					</label> <br /> <input id="c4" type="radio" name="choice"> <label
						for="c4"><font id="a4">A4</font> </label>
				</div>

				<a href="javascript:void(0);" onclick="next_question();"
					style="text-decoration: none;">
					<div class="play-button" style="position: relative; top: 102px;">
						<font id="button-text" style="margin-left: 38px;">Score It</font>
					</div>
				</a>
			</div>
		</div>
		<div id="confirm_exit" class="Ques" style="display: none;">
			<font align="center">Are you sure you want to exit ?</font>
			<div class="play-button"
				style="position: relative; top: 101px; left: -110px;">
				<font id="button-text"> <a href="javascript:void(0);"
					id="close_game" style="text-decoration: none;" onclick="done_fun()"><font
						color="white">Yes</font> </a>
				</font>
			</div>
			<div class="play-button"
				style="position: relative; top: 51px; left: 110px;">
				<font id="button-text"> <a href="javascript:void(0);"
					id="close_game" style="text-decoration: none;"
					onclick="cont_game()"><font color="white">No</font> </a>
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
				more than 2 minutes, you will only score 50 points. <br /> <b>WARNING</b><br />
				IF you closed the window or the tab, you will not be able to proceed 
				to other questions. <br /> You will get only your current score. <br /> <br />
			</p>
			<a href="javascript:void(0);" style="text-decoration: none;"
				onclick="init_questions('<?= $q ?>', '<?= $cc ?>', '<?= $a ?>', '<?=$is_played?>');">
				<div class="play-button">
					<font id="button-text">Play!</font>
				</div>
			</a>
		</div>
	</div>

	<div id="right-bar">
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
				style="margin-right: 5px;">Pick the Correct Choice
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
<script>
var questions;
var choices;
var answers;
var id;
game_started = false;
var score;
final_score = 0;
var time_interval;
cur_game_type = "mcq";

function update_game_score() {
	game_page = "<?=base_url()?>index.php?/game_center/update_score";
	$.post(game_page, { game_score : final_score })
	.done(function( data ) {
    	$("#score-<?=$cat_id?>").html(data);
	});
}

function done_fun() {
  	document.getElementById('Q-score-table').style.display = 'none';
  	document.getElementById('confirm_exit').style.display = 'none';
  	document.getElementById('timer').style.display = 'none';
  	document.getElementById('final_score').style.display = 'block';
  	document.getElementById('current_question').style.display = 'none';
	document.getElementById('total-score').innerHTML = final_score + " Points";
	game_started = false;
	update_game_score();
}

function cont_game() {
  	document.getElementById('current_question').style.display = 'block';
  	document.getElementById('confirm_exit').style.display = 'none';
}

function count_timer(){
  	if (score > 50)
  		score -= 10;
  	else
  		score -= 5;
  	if (score < 10)
  		score = 10;
  	document.getElementById('timer').innerHTML = score;
}

function init_questions (q, c, a, is_played) {
	game_started = true;
	questions = new Array();
	questions = q.split('~');
	answers = new Array();
	answers = a.split('~');
	var ch = new Array();
	ch = c.split('^');
	choices = new Array();
	for (var i = 0; i < ch.length ; i ++) {
		choices[i] = new Array();
		choices[i] = ch[i].split('~');
	}
	var ob1 = document.getElementById('intro');
	ob1.style.display = 'none';
	var ob2 = document.getElementById('mcq-content');
	ob2.style.display = 'block';
	id = 0;
	final_score = 0;
	score = 200;
	clearInterval(time_interval);
	time_interval = setInterval('count_timer()', 1000);
	var ob3 = document.getElementById('score-count');
	ob3.style.display = 'block';
	if (is_played != '-1') {
		game_started = false;
	  	document.getElementById('Q-score-table').style.display = 'none';
	  	document.getElementById('timer').style.display = 'none';
		var obj = document.getElementById('current_question');
		obj.style.display = 'none';
		var obj = document.getElementById('final_score');
		obj.style.display = 'block';
		document.getElementById('total-score').innerHTML = is_played + " Points";
	}
	next_question();
}
function next_question() {
  	document.getElementById('timer').innerHTML = score;
	if (id != 0) {
		var ans = -1;
		for (var i = 1; i <= 4; i ++) {
			var cur = "c";
			var num = i.toString();
			cur += num;
			var ch = document.getElementById(cur).checked;
			if (ch)
				ans = i - 1;
		}
		id --;
		var cur_id = id.toString();
		id ++;
		if (ans == answers[id - 1]) {
			final_score += score;
			document.getElementById("question-" + cur_id).className = "green-circle";
			document.getElementById("question-score-" + cur_id).innerHTML = score;
		}
		else {
			document.getElementById("question-" + cur_id).className = "red-circle";
			document.getElementById("question-score-" + cur_id).innerHTML = "0";
		}
		document.getElementById("question-score-" + cur_id).style.color = "white";
	}
	var tmp = questions.length;
	var len = tmp.toString();
	var cur_id = (id + 1).toString();
	document.getElementById("question_count").innerHTML = ("Question " + cur_id + " of " + len);
	if (id == questions.length) {
	  	document.getElementById('timer').style.display = 'none';
		var obj = document.getElementById('current_question');
		obj.style.display = 'none';
		var obj = document.getElementById('final_score');
		obj.style.display = 'block';
		document.getElementById('total-score').innerHTML = final_score + " Points";
		game_page = "<?=base_url()?>index.php?/game_center/update_score";
		$.post(game_page, { game_score : final_score })
		.done(function( data ) {
	    	$("#score-<?=$cat_id?>").html(data);
		});
		game_started = false;
	}
	document.getElementById('question_content').innerHTML = questions[id];
	for (var i = 0; i < 4; i ++) {
		document.getElementById("a" + (i + 1)).innerHTML = choices[id][i];
	}
	$("#c1").prop('checked',true);
	id ++;
	score = 200;
	clearInterval(time_interval);
	time_interval = setInterval('count_timer()', 1000);
}
</script>
