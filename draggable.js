
const image_drop_area = document.querySelector("#image_drop_area");

let uploaded_image ;

image_drop_area.addEventListener('dragover', (event) => {
    event.stopPropagation();
    event.preventDefault();
    event.dataTransfer.dropEffect = 'copy';
});



image_drop_area.addEventListener('drop', (event) => {
    event.stopPropagation();
    event.preventDefault();
    const fileList = event.dataTransfer.files;
    readImage(fileList[0]);
});



readImage = (file) => {
    const reader = new FileReader();
    reader.addEventListener('load', (event) => {
    uploaded_image = event.target.result;
    document.querySelector("#image_drop_area").style.backgroundImage = `url(${uploaded_image})`;
    uploadImage(uploaded_image);
});
reader.readAsDataURL(file);
}


function uploadImage(){
     var SendData = {"newProfilePic":uploaded_image};
    var URL = "validateDraggable.php";
    $.ajax({ type:'POST', dataType:'text', data:SendData, url:URL, success(Response){
        // If the response was successfull we will get the output in this callback
          console.log("Success Response === ", Response);
    }, error(jqXHR, textStatus, error){
        // If the response was NOT successfull we will get the error in this callback
          console.log("Error Response === ", error);
    } });
}
