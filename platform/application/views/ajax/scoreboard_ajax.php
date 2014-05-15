<?php
                $scoreboard = $_SESSION [ 'user_data' ];
                $all_users = $scoreboard ['all'];
                $top_users = $scoreboard ['top'];
                //log_message('error','mo7eb scoreboard_ajax $scoreboard[fb_ids]='.  print_r($scoreboard['fb_ids'],TRUE));
?>
<div id="ranks_table_div" >
        <?php
    $removedRanks = 0;
    $min = count($all_users);
    if ($min > count($top_users))
            $min = count($top_users);
    for($i = 0; $i < $min && count($all_users) > 0; $i ++) {
            if ($i % 2 == 0) {
                //Check if 1st friend's rank is not 1 then donot display his image 
                if(!$_SESSION['all']){ if($all_users[0]['rank'] != 1){$removedRanks++; continue;} }
            ?>
            <!-- GOLD TABLE -->
                    <table>
                            <tr style = "height: 20px;"></tr>
                            <tr>
                                    <td rowspan = "2" style = "width: 190px; text-align: center;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/<?=$top_users[$i]->name;?>_icon.png" alt="gold" style = "width:70px; margin-left: 26px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/bigarrow_right_icon.png" alt="arrow" style = "width:80px; margin-left: -6px;">
                                    </td>
                                    <td rowspan = "2" class = "score-td" style = "width: 70px;">
                                            <?php if($_SESSION['all'] == TRUE) { ?>
                                            <img class = "score-profile-pic" src="http://graph.facebook.com/<?=$scoreboard['fb_ids'][$i]?>/picture?width=200&height=200" alt="profile-pic" >
                                            <?php } else { ?>
                                            <img class = "score-profile-pic" src="http://graph.facebook.com/<?=$all_users[$i]['fb_id']?>/picture?width=200&height=200" alt="profile-pic" >
                                            <?php } ?>
                                    </td>
                                    <td class = "score-name" style = "width: 299px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/profile_icon.png" alt="profile-icon" >
                                            <?=($_SESSION['all'])?$all_users[$i]->user_name:$all_users[$i]['user_name'];?>
                                    </td>
                                    <td rowspan = "2" align = "center" class = "score-td" style = "width: 27px;">
                                            <img src="<?=base_url()?>h7-assets/images/scoreboard/change/<?=($_SESSION['all'])?$all_users[$i]->change:$all_users[$i]['change']?>.png" alt="<?=($_SESSION['all'])?$all_users[$i]->change:$all_users[$i]['change']?>">
                                    </td>
                                    <td rowspan = "2" style = "width: 13px;"></td>
                            </tr>
                            <tr>
                                    <td class = "score-td" style = "padding-left: 10px;"><img src="<?=base_url()?>/h7-assets/resources/img/main-icons/score_icon2.png" alt="score-icon" ><?=($_SESSION['all'])?$all_users[$i]->score:$all_users[$i]['score']?></td>
                            </tr>
                            <tr style = "height: 20px;"></tr>
                    </table>
            <!-- end of gbold table -->
    <?php } else {
                //Check if 2nd friend's rank is not 2 then donot display his image 
                if(!$_SESSION['all']){ if($all_users[1]['rank'] != 2){$removedRanks++; continue;} }
        ?>
                    <table>
                            <tr style = "height: 20px;"></tr>
                            <tr>
                                    <td rowspan = "2" style = "width: 35px;"></td>

                                    <td rowspan = "2" class = "score-td" style = "width: 70px;">
                                            <img class = "score-profile-pic" src="http://graph.facebook.com/<?=($_SESSION['all'])?$scoreboard['fb_ids'][$i]:$all_users[$i]['fb_id']?>/picture?width=200&height=200" alt="profile-pic" >
                                    </td>
                                    <td class = "score-name" style = "width: 299px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/profile_icon.png" alt="profile-icon" >
                                            <?=($_SESSION['all'])?$all_users[$i]->user_name:$all_users[$i]['user_name'];?>
                                    </td>
                                    <td rowspan = "2" align = "center" class = "score-td" style = "width: 27px;">
                                            <img src="<?=base_url()?>h7-assets/images/scoreboard/change/<?=($_SESSION['all'])?$all_users[$i]->change:$all_users[$i]['change']?>.png" alt="<?=($_SESSION['all'])?$all_users[$i]->change:$all_users[$i]['change']?>">
                                    </td>
                                    <td rowspan = "2" style = "width: 190px; text-align: center;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/bigarrow_left_icon.png" alt="arrow" style = "width:80px; margin-right: -6px;">
                                            <img src="<?=base_url()?>/h7-assets/resources/img/main-icons/<?=$top_users[$i]->name?>_icon.png" alt="silver" style = "width:70px; margin-right: 26px;">
                                    </td>
                            </tr>
                            <tr>
                                    <td class = "score-td" style = "padding-left: 10px;"><img src="<?=base_url()?>/h7-assets/resources/img/main-icons/score_icon2.png" alt="score-icon" ><?=($_SESSION['all'])?$all_users[$i]->score:$all_users[$i]['score']?></td>
                            </tr>
                            <tr style = "height: 20px;"></tr>
                    </table>
    <?php }
    } ?>
    <!-- RANK TABLE -->
    <table id = "rank-table">
            <tr id = "rank-head">
                    <td class = "first-col">Rank</td>
                    <td style = "width: 235px;"><img src="<?=base_url()?>/h7-assets/resources/img/main-icons/profile_icon.png" alt="profile-icon"> Name</td>
                    <td><img src="<?=base_url()?>/h7-assets/resources/img/main-icons/score_icon2.png" alt="score-icon"> Score</td>
                    <td>Change</td>
            </tr>
            <?php
            //log_message('error','mo7eb scoreboard_ajax $all='.(($_SESSION['all'])?'TRUE':'FALSE'));
            if ($min < (count($all_users) + $removedRanks)) {
            for($i = (count( $top_users ) - $removedRanks); $i < count ( $all_users); $i ++) {
                            $class = 'odd-row';
                            if ($i % 2 == 0) {
                                    $class = 'even-row';
                            } ?>
                            <tr class = "<?=$class?>">
                                    <td class = "first-col"><?=($_SESSION['all'])?$all_users[$i]->rank:$all_users[$i]['rank']?></td>
                                    <td><?=($_SESSION['all'])?$all_users[$i]->user_name:$all_users[$i]['user_name']?></td>
                                    <td><?=($_SESSION['all'])?$all_users[$i]->score:$all_users[$i]['score']?></td>
                                    <td><img src="<?=base_url()?>h7-assets/images/scoreboard/change/<?=($_SESSION['all'])?$all_users[$i]->change:$all_users[$i]['change']?>.png" alt="<?=($_SESSION['all'])?$all_users[$i]->change:$all_users[$i]['change']?>"></td>
                            </tr>
            <?php } } else {
                    echo 'No Users<br />';
            }?>
    </table>
</div>
    <!-- end of rank table -->