function submitDelete(imageId, userId, snapshot) {

    let content = document.getElementById('submit-delete-' + imageId);
    let separator = snapshot.split('/');
    let snapshotDb = separator[separator.length - 1];
    ajaxtoBackDelete(content, imageId, userId, snapshotDb);
}

function ajaxtoBackDelete(content, imageId, userId, snapshotDb) {

    let xhr = new XMLHttpRequest();
    let container = document.querySelector('div[data-src="' + imageId + '"]');

    container.style.display = 'none';
    xhr.open("POST", "actions/delete.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("imageid=" + imageId + "&userid=" + userId + "&snapshot=" + snapshotDb);
}