function submitLike(imageId, userId, snapshot) {
    
    let newLike = document.getElementById('submit-like-' + imageId);
    let separator = snapshot.split('/');
    let snapshotDb = separator[separator.length - 1];
    ajaxToBackLike(newLike, imageId, userId, snapshotDb);
}

function submitDislike(imageId, userId, snapshot) {

    let newDislike = document.getElementById('submit-dislike-' + imageId);
    let separator = snapshot.split('/');
    let snapshotDb = separator[separator.length - 1];
    ajaxToBackDislike(newDislike, imageId, userId, snapshotDb);
}

function ajaxToBackLike(newLike, imageId, userId, snapshotDb) {
    let xhr = new XMLHttpRequest();
    let nbLikes = document.getElementById('display-like-' + imageId);
    let count = nbLikes.innerHTML[0];
    nbLikes.innerHTML = parseInt(count * 1 + 1) + ' &#8593';
    newLike.style.display = 'none';
    newLike = 'L';
    xhr.open("POST", "actions/likes.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("like=" + newLike + "&imageid=" + imageId + "&userid=" + userId + "&snapshot=" + snapshotDb);
}

function ajaxToBackDislike(newDislike, imageId, userId, snapshotDb) {

    let xhr = new XMLHttpRequest();
    let nbDislikes = document.getElementById('display-dislike-' + imageId);
    let count = nbDislikes.innerHTML[0];
    nbDislikes.innerHTML = parseInt(count * 1 + 1) + ' &#8595';
    newDislike.style.display = 'none';
    newDislike = 'D';
    xhr.open("POST", "actions/likes.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("like=" + newDislike + "&imageid=" + imageId + "&userid=" + userId + "&snapshot=" + snapshotDb);
}