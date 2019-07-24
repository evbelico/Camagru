function submitComment(imageId, userId, snapshot) {
    
    let newComment = document.getElementById('new-comment-' + imageId);
    let newCommentText = newComment.value;        

     if (newCommentText.length > 0 && newCommentText.length <= 1000) {
        let separator = snapshot.split('/');
        let snapshotDb = separator[separator.length - 1];
        ajaxToBack(newCommentText, imageId, userId, snapshotDb);
    }
    else if (newCommentText.length <= 0) {
        alert("Enter a comment first !");
    }
    else if (newCommentText.length > 1000) {
        alert("Sorry, your comment is too long. Comments can only contain 1000 characters maximum.");
    }
}

function ajaxToBack(comment, imageId, userId, snapshotDb) {

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "actions/comments.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("comment=" + comment + "&imageid=" + imageId + "&userid=" + userId + "&snapshot=" + snapshotDb);
}