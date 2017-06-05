if(typeof showYesNoWarning !== 'undefined'){
  
    var modalYesNo = document.getElementById('modalYesNo');
    modalYesNo.style.display = "block";
    var yesNoSpanClose = document.getElementById("warningModalClose");
    yesNoSpanClose.onclick = function() {
        modalYesNo.style.display = "none";
    }
    var botoCancel = document.getElementById("cancelWarningButton");
    botoCancel.onclick = function() {
        modalYesNo.style.display = "none";
    }
}

var errorModal = document.getElementById('errorModal');
if(typeof showError !== 'undefined'){
    errorModal.style.display = "block";
    var spanError = document.getElementById("errorClose");
    spanError.onclick = function() {
        errorModal.style.display = "none";
    }
}

if(document.getElementById("myBtn")!=null){
    // Get the modal
    var modal = document.getElementById('myModal');
    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks on the button, open the modal

    btn.onclick = function() {
        modal.style.display = "block";
    }
    
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
}



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }else if(event.target == errorModal){
        errorModal.style.display = "none";
    }else if(event.target == modalYesNo){
        modalYesNo.style.display = "none";
    }
}
