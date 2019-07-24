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
    newLike.style.display = 'none';
    newLike = 'L';
    xhr.open("POST", "actions/likes.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("like=" + newLike + "&imageid=" + imageId + "&userid=" + userId + "&snapshot=" + snapshotDb);
}

function ajaxToBackDislike(newDislike, imageId, userId, snapshotDb) {

    let xhr = new XMLHttpRequest();
    newDislike.style.display = 'none';
    newDislike = 'D';
    xhr.open("POST", "actions/likes.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("like=" + newDislike + "&imageid=" + imageId + "&userid=" + userId + "&snapshot=" + snapshotDb);
}