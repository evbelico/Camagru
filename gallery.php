<?php
require_once('html_fragments/header.php');
require_once('config/database.php');
require_once('functions/montage_todatabase.php');
require_once('functions/comments.php');
require_once('functions/likes.php');
?>
<script type="text/javascript" src="<?php echo URLROOT; ?>javascript/comment.js"></script>
<script type="text/javascript" src="<?php echo URLROOT; ?>javascript/like.js"></script>
<script type="text/javascript" src="<?php echo URLROOT; ?>javascript/delete.js"></script>
<div id="select-gallery">
    <div class="centered-gallery">
        <a href="gallery.php"><button type="submit" name="gallery-latest">Latest</button></a>
    </div>
    <br/>
    <?php 
    $per_page = 5;

    if (isset($_GET['page']) && $_GET['page'] >= 1) {
        $page = $_GET['page'] - 1;
        $offset = $page * $per_page;
    }
    else {
        $page = 0;
        $offset = 0;
    }
    
    $total_snapshots = count_montages();
    if ($total_snapshots > $per_page) {
        $total_pages = ceil(intval($total_snapshots) / $per_page);
        $page_up = $page + 2;
        $page_down = $page;
        $display='';
    }
    else {
        $pages = 1;
        $total_pages = 1;    
    }
		$cpt = 1;

        echo '<div class="centered-gallery">';
		echo '<h3 class="typewriter">Page '; echo $page + 1 .' of '.$total_pages.'</h3><br/>';

		if ($page) {
			//echo '<a href="gallery.php"><button>First</button></a>'; // Back to first page <<
			//echo '<a href="gallery.php?page='.$page_down.'"><button>Prev</button></a>'; // Back to previous page <
		}

		for ($cpt = 1; $cpt <= $total_pages; $cpt++) {
			if (($cpt == $page + 1)) {
				echo '<a href="gallery.php?page='.$cpt.'"><button>'.$cpt.'</button></a>'; // Active page
            }
        
			if (($cpt != $page + 1) && ($cpt <= $page + 3) && ($cpt >= $page - 1)) { // Two below & above curr page
				echo '<a href="gallery.php?page='.$cpt.'"><button>'.$cpt.'</button></a>';
            }
        
			//else if ($page + 1 < $total_pages) {
			//	echo '<a href="gallery.php?page='.$page_up.'"><button>Next</button></a>'; // Next page
				//echo '<a href="gallery.php?page='.$total_pages.'"><button>Last</button></a>'; // Last page !
            //}
        }
        
    echo "</div>";
    echo "</div>";
    $snapshots = get_montages($offset, $per_page);
    echo '<div id="gallery-container">';
    if ($snapshots != "") {
        $i = 0;
        while ($i != $per_page && $snapshots[$i]) {
            echo '<div id="container" data-src="'.$snapshots[$i]['id'].'">';
		    echo '<a href="/snapshots/'.$snapshots[$i]['img'].'">';
            echo '<img src="/snapshots/'.$snapshots[$i]['img'].'" id="'.$snapshots[$i]['id'].'">';
            echo '</a>';
            echo '<br/>';
            $comments = get_comments($snapshots[$i]['id'], $snapshots[$i]['img']);
            $j = 0;
            if ($comments != "") {
                while ($comments[$j] != null) {
                    if ($comments[$j]['imageid'] == $snapshots[$i]['id']) {
                        echo '<p class="typewriter" style="font-style: oblique"><b>'. $comments[$j]['username']. '</b> '. $comments[$j]['content']. '<br/><b>at '. $comments[$j]['creation_date']. '</b></p>';
                    }
                    $j++;
                }
            }
            if (isset($_SESSION['loggued-on-user']) && !empty($_SESSION['loggued-on-user']) && isset($_SESSION['userid']) && !empty($_SESSION['userid'])) {
                $new_comment = '<input type="text" id="new-comment-'. $snapshots[$i]['id'] .'" name="new-comment" placeholder="Comment here" maxlength="1000" minlength="1">';
                $send_button = '<button type="submit" id="submit-comment" name="submit-comment" onclick="submitComment('. $snapshots[$i]['id'] .', '. $snapshots[$i]['userid']. ', \'/snapshots/'. $snapshots[$i]['img'] .'\')">Submit</button>';
                
                echo $new_comment;
                echo '<br/>';
                echo $send_button;

                $likes = get_likes($_SESSION['userid'], $snapshots[$i]['id']);
                $k = 0;
                $type_l = 'style=""';
                $type_d = 'style=""';

                if ($likes != "") {
                    while ($likes[$k] != null) {
                        if ($likes[$k]['imageid'] == $snapshots[$i]['id']) {
                            if ($likes[$k]['type'] == 'D')
                                $type_d = 'style="display: none;"';
                            else if ($likes[$k]['type'] == 'L')
                                $type_l = 'style="display: none;"';
                        }
                        else if ($likes[$k]['imageid'] != $snapshots[$i]['id']) {
                            $type_l = '';
                            $type_d = '';
                        }
                        $k++;
                    }
                }
                $like_button = '<button type="submit" '. $type_l .'  id="submit-like-'. $snapshots[$i]['id'] .'" name="submit-like" onclick="submitLike('. $snapshots[$i]['id'] .', '. $snapshots[$i]['userid'] .', \'/snapshots/'. $snapshots[$i]['img'] .'\')"> &#8593; </button>';
                $dislike_button = '<button type="submit" '. $type_d .' id="submit-dislike-'. $snapshots[$i]['id'] .'" name="submit-dislike" onclick="submitDislike('. $snapshots[$i]['id'] .', '. $snapshots[$i]['userid'] .', \'/snapshots/'. $snapshots[$i]['img'] .'\')"> &#8595; </button>';
                echo $like_button;
                echo $dislike_button;
                
                $nb_likes_btn = '<button type="submit" id="display-like-'. $snapshots[$i]['id'] .'" name="display-like" disabled>'. get_nb_likes($snapshots[$i]['id']) .' &#8593; </button>';
                $nb_dislikes_btn = '<button type="submit" id="display-dislike-'. $snapshots[$i]['id'] .'" name="display-dislike" disabled>'. get_nb_dislikes($snapshots[$i]['id']) .' &#8595; </button>';
                echo $nb_likes_btn;
                if ($_SESSION['userid'] == $snapshots[$i]['userid']) {
                    $delete_button = '<button type="submit" id="submit-delete-'. $snapshots[$i]['id'] .'" class="delete-btn" name="submit-delete" onclick="submitDelete('. $snapshots[$i]['id'] .', '. $snapshots[$i]['userid'] .', \'/snapshots/'. $snapshots[$i]['img'] .'\')"> Delete </button>';
                    echo $delete_button;
                }
                echo $nb_dislikes_btn;

            }
            $i++;
            echo '</div>';
        }
    }
    echo '</div>';
?>
<?php require_once('html_fragments/footer.php'); ?>